<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::withCount('loanPosts')
            ->withSum('loanPosts', 'amount_needed')
            ->latest()
            ->get();

        return view('admin.users', compact('users'));
    }

    public function toggleRole(User $user)
    {
        $user->update([
            'role' => $user->isAdmin() ? 'user' : 'admin',
        ]);

        return back()->with('success', "Role updated for {$user->name}.");
    }
}