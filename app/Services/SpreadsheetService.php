<?php

namespace App\Services;

use App\Models\LoanPost;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SpreadsheetService
{
    public function generateCirculationReport(?string $from = null, ?string $to = null): StreamedResponse
    {
        $query = LoanPost::with('user')->latest();

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        $posts = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Money Circulation');

        // Title row
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'Kamibantu - Money Circulation Report');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Date range subtitle
        $rangeLabel = 'All time';
        if ($from && $to) {
            $rangeLabel = "Period: {$from} to {$to}";
        } elseif ($from) {
            $rangeLabel = "From: {$from}";
        } elseif ($to) {
            $rangeLabel = "Until: {$to}";
        }

        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', $rangeLabel . ' | Generated: ' . now()->format('F j, Y H:i:s'));
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['rgb' => '71717A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Headers (row 4)
        $headers = [
            'A4' => 'Post ID',
            'B4' => 'Borrower',
            'C4' => 'Title',
            'D4' => 'Amount Needed (Rp)',
            'E4' => 'Interest Rate (%)',
            'F4' => 'Total Repayable (Rp)',
            'G4' => 'Status',
            'H4' => 'Posted Date',
            'I4' => 'Closed Date',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        $sheet->getStyle('A4:I4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '18181B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        // Data rows
        $row = 5;
        foreach ($posts as $post) {
            $sheet->setCellValue("A{$row}", $post->id);
            $sheet->setCellValue("B{$row}", $post->user->name);
            $sheet->setCellValue("C{$row}", $post->title);
            $sheet->setCellValue("D{$row}", $post->amount_needed);
            $sheet->setCellValue("E{$row}", $post->interest_rate);
            $sheet->setCellValue("F{$row}", $post->total_with_interest);
            $sheet->setCellValue("G{$row}", ucfirst($post->status));
            $sheet->setCellValue("H{$row}", $post->created_at->format('Y-m-d H:i'));
            $sheet->setCellValue("I{$row}", $post->closed_at?->format('Y-m-d H:i') ?? '-');
            $row++;
        }

        $lastDataRow = $row - 1;

        if ($lastDataRow >= 5) {
            $sheet->getStyle("D5:D{$lastDataRow}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("F5:F{$lastDataRow}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("E5:E{$lastDataRow}")->getNumberFormat()->setFormatCode('0.00"%"');
            $sheet->getStyle("A4:I{$lastDataRow}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E4E4E7']]],
            ]);
        }

        // Summary
        $summaryRow = $lastDataRow + 2;
        $sheet->setCellValue("A{$summaryRow}", 'SUMMARY');
        $sheet->getStyle("A{$summaryRow}")->getFont()->setBold(true)->setSize(12);

        $summaryRow++;
        $summaries = [
            ['Total Amount Requested', $posts->sum('amount_needed')],
            ['Total Closed Deals Value', $posts->where('status', 'closed')->sum('amount_needed')],
            ['Average Loan Size', $posts->avg('amount_needed') ?? 0],
            ['Average Interest Rate', $posts->avg('interest_rate') ?? 0],
            ['Total Posts', $posts->count()],
            ['Open Posts', $posts->where('status', 'open')->count()],
            ['Closed Posts', $posts->where('status', 'closed')->count()],
        ];

        foreach ($summaries as [$label, $value]) {
            $sheet->setCellValue("A{$summaryRow}", $label);
            $sheet->setCellValue("D{$summaryRow}", $value);
            $sheet->getStyle("A{$summaryRow}")->getFont()->setBold(true);
            if (is_numeric($value) && $value > 100) {
                $sheet->getStyle("D{$summaryRow}")->getNumberFormat()->setFormatCode('#,##0');
            }
            $summaryRow++;
        }

        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        // Filename includes date range
        $filename = 'Kamibantu-circulation';
        if ($from) $filename .= '-from-' . $from;
        if ($to) $filename .= '-to-' . $to;
        if (!$from && !$to) $filename .= '-' . now()->format('Y-m-d');
        $filename .= '.xlsx';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }
}