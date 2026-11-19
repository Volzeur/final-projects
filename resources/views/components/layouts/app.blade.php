@props(['title' => 'Kamibantu'])

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | Kamibantu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-background text-foreground antialiased">
    <div class="min-h-full">
        {{-- Navigation --}}
        <nav class="sticky top-0 z-50 border-b border-border bg-background">
            <div class="mx-auto max-w-2xl px-4">
                <div class="flex h-14 items-center justify-between">
                    {{-- Left: Logo --}}
                    <a href="{{ route('feed') }}" class="flex items-center gap-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-md bg-primary">
                            <svg class="h-4 w-4 text-primary-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-lg font-semibold tracking-tight hidden sm:inline">Kamibantu</span>
                    </a>

                    {{-- Right: Actions --}}
                    <div class="flex items-center gap-2">
                        @auth
                            <a href="{{ route('posts.create') }}"
                               class="inline-flex items-center gap-1.5 rounded-lg bg-primary px-3 py-1.5 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span class="hidden sm:inline">Apply for a loan</span>
                            </a>

                            {{-- Dropdown --}}
                            <div class="relative" x-data="{ open: false }" id="user-menu">
                                <button onclick="document.getElementById('dropdown').classList.toggle('hidden')"
                                        class="flex items-center gap-2 rounded-lg p-1.5 hover:bg-muted transition-colors">
                                    <img src="{{ auth()->user()->avatar_url }}" alt="" class="h-7 w-7 rounded-full object-cover">
                                </button>
                                <div id="dropdown" class="hidden absolute right-0 mt-2 w-56 rounded-xl border border-border bg-card shadow-lg py-1 z-50">
                                    <div class="px-4 py-2 border-b border-border">
                                        <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-muted-foreground">{{ auth()->user()->email }}</p>
                                    </div>
                                    <a href="{{ route('my-posts') }}" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-muted transition-colors">
                                        <svg class="h-4 w-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                        Loan Requests
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-muted transition-colors">
                                        <svg class="h-4 w-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        Settings
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                        <div class="border-t border-border my-1"></div>
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-muted transition-colors">
                                            <svg class="h-4 w-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" /></svg>
                                            Admin Panel
                                        </a>
                                    @endif
                                    <div class="border-t border-border my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-destructive hover:bg-muted transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                                            Log out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="rounded-lg px-3 py-1.5 text-sm font-medium hover:bg-muted transition-colors">Log in</a>
                            <a href="{{ route('register') }}" class="rounded-lg bg-primary px-3 py-1.5 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">Sign up</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mx-auto max-w-2xl px-4 mt-4">
                <div class="rounded-lg border border-success/20 bg-success/5 px-4 py-3 text-sm text-success flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-auto max-w-2xl px-4 mt-4">
                <div class="rounded-lg border border-destructive/20 bg-destructive/5 px-4 py-3 text-sm text-destructive flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Main Content --}}
        <main class="mx-auto max-w-2xl px-4 py-6">
            {{ $slot }}
        </main>
    </div>

    {{-- Close dropdown when clicking outside --}}
    <script>
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('user-menu');
            const dropdown = document.getElementById('dropdown');
            if (menu && dropdown && !menu.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
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