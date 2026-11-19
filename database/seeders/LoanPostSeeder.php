<?php

namespace Database\Seeders;

use App\Models\LoanPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LoanPostSeeder extends Seeder
{
    public function run(): void
    {
        $users = collect([
            ['name' => 'Budi Santoso', 'email' => 'budi@test.com', 'whatsapp_number' => '6281111111111'],
            ['name' => 'Siti Rahayu', 'email' => 'siti@test.com', 'whatsapp_number' => '6282222222222'],
            ['name' => 'Andi Wijaya', 'email' => 'andi@test.com', 'whatsapp_number' => '6283333333333'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@test.com', 'whatsapp_number' => '6284444444444'],
            ['name' => 'Rizky Pratama', 'email' => 'rizky@test.com', 'whatsapp_number' => '6285555555555'],
        ])->map(fn($u) => User::create([...$u, 'password' => Hash::make('password')]));

        $posts = [
            [
                'title' => 'Need capital for small warung expansion',
                'description' => '<div>I need funds to expand my small food stall. <strong>Business has been running for 2 years</strong> and I want to add more menu items and buy a bigger cart.</div>',
                'amount_needed' => 5000000,
                'interest_rate' => 5,
                'collateral_description' => 'BPKB Motor Honda Beat 2022',
            ],
            [
                'title' => 'Emergency medical expenses',
                'description' => '<div>My father needs surgery and insurance doesn\'t cover the full amount. <em>Will repay within 3 months</em> from my salary.</div>',
                'amount_needed' => 15000000,
                'interest_rate' => 3,
                'collateral_description' => 'Gold jewelry 10 grams',
            ],
            [
                'title' => 'Laptop for freelance work',
                'description' => '<div>I\'m a freelance designer and my laptop broke. Need a new one to continue working. <strong>Can show portfolio and client contracts.</strong></div>',
                'amount_needed' => 8000000,
                'interest_rate' => 7,
                'collateral_description' => 'iPhone 14 Pro',
            ],
            [
                'title' => 'School tuition for children',
                'description' => '<div>Need to pay semester tuition for 2 kids. Will repay after harvest season in 4 months.</div>',
                'amount_needed' => 3000000,
                'interest_rate' => 4,
                'collateral_description' => 'Land certificate 200m²',
            ],
            [
                'title' => 'Online shop inventory restock',
                'description' => '<div>Running a Shopee store selling accessories. Need to restock before <strong>year-end sale season</strong>. Monthly revenue ~Rp 10jt.</div>',
                'amount_needed' => 10000000,
                'interest_rate' => 8,
                'collateral_description' => 'BPKB Mobil Avanza 2019',
            ],
        ];

        foreach ($posts as $i => $postData) {
            LoanPost::create([
                ...$postData,
                'user_id' => $users[$i]->id,
                'status' => $i === 3 ? 'closed' : 'open',
                'closed_at' => $i === 3 ? now()->subDays(2) : null,
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}