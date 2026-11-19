<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Kamibantu' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-background text-foreground antialiased">
    <div class="flex min-h-full flex-col items-center justify-center px-4 py-12">
        {{-- Logo --}}
        <div class="mb-8 text-center">
            <a href="{{ route('feed') }}" class="inline-flex items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary">
                    <svg class="h-5 w-5 text-primary-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xl font-semibold tracking-tight">Kamibantu</span>
            </a>
        </div>

        {{-- Card --}}
        <div class="w-full max-w-md rounded-xl border border-border bg-card p-8 shadow-sm">
            {{ $slot }}
        </div>
    </div>
</body>
</html>