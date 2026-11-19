<?php

namespace App\Http\Controllers;

use App\Models\LoanPost;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        $query = LoanPost::with('user')->open()->latest('updated_at');

        // Optional search
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('collateral_description', 'like', "%{$search}%");
            });
        }

        // Optional amount filter
        if ($min = $request->get('min_amount')) {
            $query->where('amount_needed', '>=', $min);
        }
        if ($max = $request->get('max_amount')) {
            $query->where('amount_needed', '<=', $max);
        }

        $posts = $query->paginate(15)->withQueryString();

        return view('feed.index', compact('posts'));
    }
}