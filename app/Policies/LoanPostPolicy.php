<?php

namespace App\Policies;

use App\Models\LoanPost;
use App\Models\User;

class LoanPostPolicy
{
    public function update(User $user, LoanPost $loanPost): bool
    {
        return $user->id === $loanPost->user_id;
    }

    public function delete(User $user, LoanPost $loanPost): bool
    {
        return $user->id === $loanPost->user_id;
    }

    public function close(User $user, LoanPost $loanPost): bool
    {
        return $user->id === $loanPost->user_id && $loanPost->isOpen();
    }

    public function downloadPdf(User $user, LoanPost $loanPost): bool
    {
        return $user->id === $loanPost->user_id;
    }
}