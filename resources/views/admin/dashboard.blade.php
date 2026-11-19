<x-layouts.admin title="Dashboard">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $cards = [
                ['label' => 'Total Users', 'value' => number_format($stats['total_users']), 'color' => 'text-foreground'],
                ['label' => 'Open Requests', 'value' => number_format($stats['open_posts']), 'color' => 'text-success'],
                ['label' => 'Closed Deals', 'value' => number_format($stats['closed_posts']), 'color' => 'text-muted-foreground'],
                ['label' => 'Total Requested', 'value' => 'Rp ' . number_format($stats['total_amount_requested'], 0, ',', '.'), 'color' => 'text-foreground'],
            ];
        @endphp
        @foreach($cards as $card)
            <div class="rounded-xl border border-border bg-card p-5">
                <p class="text-xs font-medium text-muted-foreground uppercase tracking-wider">{{ $card['label'] }}</p>
                <p class="mt-2 text-2xl font-bold {{ $card['color'] }}">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Monthly Volume Chart --}}
        <div class="rounded-xl border border-border bg-card p-5">
            <h2 class="text-sm font-semibold mb-4">Monthly Loan Volume (Last 12 Months)</h2>
            <canvas id="monthlyVolumeChart" height="250"></canvas>
        </div>

        {{-- Status Distribution --}}
        <div class="rounded-xl border border-border bg-card p-5">
            <h2 class="text-sm font-semibold mb-4">Post Status Distribution</h2>
            <canvas id="statusChart" height="250"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Interest Rate Distribution --}}
        <div class="rounded-xl border border-border bg-card p-5">
            <h2 class="text-sm font-semibold mb-4">Interest Rate Distribution</h2>
            <canvas id="interestChart" height="250"></canvas>
        </div>

        {{-- Top Borrowers --}}
        <div class="rounded-xl border border-border bg-card p-5">
            <h2 class="text-sm font-semibold mb-4">Top Borrowers by Amount</h2>
            <div class="space-y-3">
                @foreach($topBorrowers as $i => $borrower)
                    <div class="flex items-center gap-3">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-muted text-xs font-bold text-muted-foreground">
                            {{ $i + 1 }}
                        </span>
                        <img src="{{ $borrower->avatar_url }}" alt="" class="h-8 w-8 rounded-full object-cover">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ $borrower->name }}</p>
                            <p class="text-xs text-muted-foreground">{{ $borrower->loan_posts_count }} posts</p>
                        </div>
                        <span class="text-sm font-semibold">
                            Rp {{ number_format($borrower->loan_posts_sum_amount_needed ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Color palette matching our neutral theme
        const colors = {
            primary: '#18181b',
            muted: '#a1a1aa',
            success: '#0f766e',
            border: '#e4e4e7',
            accent: '#20968c',
            warning: '#f59e0b',
        };

        // Monthly Volume Chart
        const monthlyData = @json($monthlyVolume);
        new Chart(document.getElementById('monthlyVolumeChart'), {
            type: 'bar',
            data: {
                labels: monthlyData.map(d => d.month),
                datasets: [{
                    label: 'Amount (Rp)',
                    data: monthlyData.map(d => d.total),
                    backgroundColor: colors.primary,
                    borderRadius: 6,
                    barThickness: 24,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'Rp ' + Number(ctx.raw).toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: v => 'Rp ' + (v / 1000000).toFixed(0) + 'jt'
                        },
                        grid: { color: colors.border }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // Status Distribution (Doughnut)
        const statusData = @json($statusDistribution);
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Open', 'Closed'],
                datasets: [{
                    data: [statusData.open || 0, statusData.closed || 0],
                    backgroundColor: [colors.success, colors.muted],
                    borderWidth: 0,
                    spacing: 2,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } }
                }
            }
        });

        // Interest Rate Distribution (Bar)
        const interestData = @json($interestBuckets);
        new Chart(document.getElementById('interestChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(interestData),
                datasets: [{
                    label: 'Number of Posts',
                    data: Object.values(interestData),
                    backgroundColor: [colors.success, colors.accent, colors.warning, colors.primary],
                    borderRadius: 6,
                    barThickness: 40,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                        grid: { color: colors.border }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
    @endpush
</x-layouts.admin>