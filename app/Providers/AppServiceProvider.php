<?php

namespace App\Providers;

use App\Models\LoanPost;
use App\Policies\LoanPostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::policy(LoanPost::class, LoanPostPolicy::class);
        Paginator::defaultView('vendor.pagination.tailwind');
    }
}