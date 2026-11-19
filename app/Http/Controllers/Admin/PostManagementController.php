<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanPost;

class PostManagementController extends Controller
{
    public function index()
    {
        $posts = LoanPost::with('user')->latest()->get();
        return view('admin.posts', compact('posts'));
    }

    public function destroy(LoanPost $post)
    {
        $post->delete();
        return back()->with('success', 'Post deleted by admin.');
    }
}