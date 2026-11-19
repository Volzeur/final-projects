<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'whatsapp_number',
        'role',
        'avatar',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function loanPosts()
    {
        return $this->hasMany(LoanPost::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        // Generate initials-based avatar URL
        $initials = collect(explode(' ', $this->name))
            ->map(fn($word) => strtoupper(mb_substr($word, 0, 1)))
            ->take(2)
            ->join('');
        return "https://ui-avatars.com/api/?name={$initials}&background=18181b&color=fafafa&size=128";
    }

    public function getFormattedWhatsappAttribute(): string
    {
        // Strip everything except digits, ensure starts with country code
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp_number ?? '');
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1); // Default Indonesia, adjust as needed
        }
        return $number;
    }
}