<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanPostRequest;
use App\Http\Requests\UpdateLoanPostRequest;
use App\Models\LoanPost;
use App\Services\PdfService;
use Illuminate\Http\Request;

class LoanPostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    public function store(StoreLoanPostRequest $request)
    {
        $post = $request->user()->loanPosts()->create($request->validated());

        return redirect()->route('posts.show', $post)
            ->with('success', 'Loan request posted successfully!');
    }

    public function show(LoanPost $post)
    {
        $post->load('user');
        return view('posts.show', compact('post'));
    }

    public function edit(LoanPost $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(UpdateLoanPostRequest $request, LoanPost $post)
    {
        $post->update($request->validated());

        return redirect()->route('posts.show', $post)
            ->with('success', 'Loan request updated.');
    }

    public function destroy(LoanPost $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('my-posts')
            ->with('success', 'Loan request deleted.');
    }

    public function close(LoanPost $post)
    {
        $this->authorize('close', $post);

        $post->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Offers closed! Your post is no longer visible in the feed.');
    }

    public function myPosts(Request $request)
    {
        $posts = $request->user()->loanPosts()->latest()->paginate(10);
        return view('posts.my-posts', compact('posts'));
    }

    public function downloadPdf(LoanPost $post, PdfService $pdfService)
    {
        $this->authorize('downloadPdf', $post);
        return $pdfService->generateLoanReceipt($post);
    }
}