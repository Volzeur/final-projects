@props(['title' => 'Admin'])

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - Kamibantu Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- NO DataTables CSS - we style everything ourselves --}}

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

    <style>
        /* ══════════════════════════════════════════════════
           DataTables - fully custom shadcn-neutral theme
           No external DataTables CSS loaded.
           ══════════════════════════════════════════════════ */

        /* Container */
        .dt-container {
            font-family: inherit;
        }

        /* Layout rows (top controls + bottom controls) */
        .dt-layout-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            padding: 0.75rem 0;
        }

        .dt-layout-start,
        .dt-layout-end {
            display: flex;
            align-items: center;
        }

        .dt-layout-row.dt-layout-table {
            padding: 0 !important;
        }

        .dt-layout-cell.dt-layout-full {
            width: 100% !important;
            padding: 0 !important;
        }

        /* Length selector */
        .dt-length {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: #71717a;
        }

        .dt-length select {
            appearance: none;
            -webkit-appearance: none;
            border: 1px solid #e4e4e7;
            border-radius: 0.5rem;
            padding: 0.4rem 2rem 0.4rem 0.75rem;
            font-size: 0.8rem;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2371717a' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 0.6rem center;
            color: #09090b;
            outline: none;
            cursor: pointer;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .dt-length select:focus {
            border-color: #a1a1aa;
            box-shadow: 0 0 0 2px rgba(161, 161, 170, 0.2);
        }

        /* Search */
        .dt-search {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: #71717a;
        }

        .dt-search input {
            border: 1px solid #e4e4e7;
            border-radius: 0.5rem;
            padding: 0.4rem 0.75rem;
            font-size: 0.8rem;
            background: #fff;
            color: #09090b;
            outline: none;
            width: 200px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .dt-search input::placeholder {
            color: #a1a1aa;
        }

        .dt-search input:focus {
            border-color: #a1a1aa;
            box-shadow: 0 0 0 2px rgba(161, 161, 170, 0.2);
        }

        /* Table */
        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
            border-spacing: 0;
            margin: 0 !important;
        }

        table.dataTable thead th {
            padding: 0.625rem 1rem;
            text-align: left;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #71717a;
            border-bottom: 1px solid #e4e4e7;
            white-space: nowrap;
            position: relative;
            cursor: pointer;
            user-select: none;
            background: #fafafa;
        }

        table.dataTable thead th:first-child {
            border-radius: 0.5rem 0 0 0;
        }

        table.dataTable thead th:last-child {
            border-radius: 0 0.5rem 0 0;
        }

        table.dataTable thead th:hover {
            color: #18181b;
        }

        /* Sort arrows */
        table.dataTable thead th span.dt-column-order {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        table.dataTable thead th span.dt-column-order::before,
        table.dataTable thead th span.dt-column-order::after {
            display: block;
            font-size: 0.55rem;
            line-height: 1;
            color: #d4d4d8;
        }

        table.dataTable thead th.dt-orderable-asc span.dt-column-order::before,
        table.dataTable thead th.dt-orderable-desc span.dt-column-order::after {
            color: #d4d4d8;
        }

        table.dataTable thead th.dt-ordering-asc span.dt-column-order::before {
            color: #18181b;
        }

        table.dataTable thead th.dt-ordering-desc span.dt-column-order::after {
            color: #18181b;
        }

        /* Hide sort on non-sortable columns */
        table.dataTable thead th.dt-orderable-none span.dt-column-order {
            display: none;
        }

        table.dataTable tbody td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f4f4f5;
            color: #18181b;
            font-size: 0.8rem;
            vertical-align: middle;
        }

        table.dataTable tbody tr {
            transition: background 0.1s;
        }

        table.dataTable tbody tr:hover {
            background-color: #fafafa;
        }

        table.dataTable tbody tr:last-child td {
            border-bottom: none;
        }

        /* Empty table */
        table.dataTable tbody td.dataTables_empty,
        table.dataTable tbody td.dt-empty {
            text-align: center;
            color: #a1a1aa;
            padding: 2rem;
            font-style: italic;
        }

        /* Info */
        .dt-info {
            font-size: 0.8rem;
            color: #71717a;
        }

        /* Pagination */
        .dt-paging {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .dt-paging button.dt-paging-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2rem;
            height: 2rem;
            padding: 0 0.5rem;
            border: 1px solid #e4e4e7;
            border-radius: 0.5rem;
            background: #fff;
            color: #18181b;
            font-size: 0.75rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s;
            font-family: inherit;
        }

        .dt-paging button.dt-paging-button:hover:not(.disabled):not(.current) {
            background: #f4f4f5;
            border-color: #d4d4d8;
        }

        .dt-paging button.dt-paging-button.current {
            background: #18181b;
            color: #fafafa;
            border-color: #18181b;
        }

        .dt-paging button.dt-paging-button.disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        /* Processing indicator */
        .dt-processing {
            display: none;
        }

        /* ── Badges ── */
        .badge-open {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 500;
            background: rgba(15, 118, 110, 0.08);
            color: #0f766e;
        }

        .badge-closed {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 500;
            background: #f4f4f5;
            color: #71717a;
        }

        .badge-admin {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 500;
            background: #18181b;
            color: #fafafa;
        }

        .badge-user {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 500;
            background: #f4f4f5;
            color: #71717a;
        }

        /* ── Action buttons ── */
        .btn-action {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid #e4e4e7;
            background: #fff;
            color: #18181b;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
            font-family: inherit;
            line-height: 1;
        }

        .btn-action:hover {
            background: #f4f4f5;
            border-color: #d4d4d8;
        }

        .btn-danger {
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.2);
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.04);
            border-color: rgba(239, 68, 68, 0.3);
        }

        /* ── User cell ── */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }

        .user-cell img {
            width: 28px;
            height: 28px;
            border-radius: 9999px;
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid #e4e4e7;
        }

        .user-cell span {
            font-weight: 500;
        }

        .actions-cell {
            display: flex;
            gap: 0.375rem;
            align-items: center;
        }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-muted/30 text-foreground antialiased">
    <div class="min-h-full flex">
        {{-- Sidebar --}}
        <aside class="w-64 border-r border-border bg-card min-h-screen fixed left-0 top-0 hidden lg:block">
            <div class="p-6">
                <a href="{{ route('feed') }}" class="flex items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-md bg-primary">
                        <svg class="h-4 w-4 text-primary-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold tracking-tight">Kamibantu</span>
                </a>
                <p class="text-xs text-muted-foreground mt-1 ml-10">Admin Panel</p>
            </div>

            <nav class="px-3 space-y-1">
                @php
                    $adminLinks = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6'],
                        ['route' => 'admin.posts', 'label' => 'All Posts', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
                        ['route' => 'admin.reports', 'label' => 'Reports', 'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z'],
                        ['route' => 'admin.users', 'label' => 'Users', 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
                    ];
                @endphp

                @foreach($adminLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                              {{ request()->routeIs($link['route']) ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}">
                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
                        </svg>
                        {{ $link['label'] }}
                    </a>
                @endforeach

                <div class="pt-4 mt-4 border-t border-border">
                    <a href="{{ route('feed') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-muted-foreground hover:bg-muted hover:text-foreground transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" /></svg>
                        Back to Site
                    </a>
                </div>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 lg:ml-64">
            <div class="sticky top-0 z-40 border-b border-border bg-card lg:hidden">
                <div class="flex h-14 items-center justify-between px-4">
                    <span class="font-semibold">Admin Panel</span>
                    <a href="{{ route('feed') }}" class="text-sm text-muted-foreground">← Back</a>
                </div>
                <div class="flex gap-1 px-4 pb-2 overflow-x-auto">
                    @foreach($adminLinks as $link)
                        <a href="{{ route($link['route']) }}"
                           class="whitespace-nowrap rounded-lg px-3 py-1.5 text-xs font-medium
                                  {{ request()->routeIs($link['route']) ? 'bg-primary text-primary-foreground' : 'bg-muted text-muted-foreground' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            @if(session('success'))
                <div class="mx-6 mt-4">
                    <div class="rounded-lg border border-success/20 bg-success/5 px-4 py-3 text-sm text-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- jQuery + DataTables JS only (no CSS framework) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    
    <script>
        document.querySelectorAll('input, textarea').forEach(function(el) {
            el.setAttribute('autocomplete', 'off');
        });
        document.querySelectorAll('form').forEach(function(el) {
            el.setAttribute('autocomplete', 'off');
        });
    </script>

    @stack('scripts')
</body>
</html>