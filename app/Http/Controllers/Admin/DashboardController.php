<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanPost;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary stats
        $stats = [
            'total_users' => User::count(),
            'total_posts' => LoanPost::count(),
            'open_posts' => LoanPost::open()->count(),
            'closed_posts' => LoanPost::closed()->count(),
            'total_amount_requested' => LoanPost::sum('amount_needed'),
            'total_amount_closed' => LoanPost::closed()->sum('amount_needed'),
            'avg_interest' => LoanPost::avg('interest_rate') ?? 0,
        ];

        // Monthly loan volume (last 12 months)
        $monthlyVolume = LoanPost::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(amount_needed) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // For MySQL, replace strftime with DATE_FORMAT:
        // DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")

        // Status distribution
        $statusDistribution = LoanPost::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Interest rate distribution (buckets)
        $interestBuckets = LoanPost::select(
                DB::raw("CASE
                    WHEN interest_rate <= 5 THEN '0-5%'
                    WHEN interest_rate <= 10 THEN '5-10%'
                    WHEN interest_rate <= 20 THEN '10-20%'
                    ELSE '20%+'
                END as bucket"),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('bucket')
            ->pluck('count', 'bucket');

        // Top borrowers
        $topBorrowers = User::withCount('loanPosts')
            ->withSum('loanPosts', 'amount_needed')
            ->orderByDesc('loan_posts_sum_amount_needed')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'monthlyVolume', 'statusDistribution',
            'interestBuckets', 'topBorrowers'
        ));
    }
}