<x-layouts.app title="Feed">
    {{-- Search bar --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('feed') }}" class="flex gap-2">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search loan requests..."
                       class="w-full rounded-lg border border-input bg-background pl-10 pr-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
            </div>
            <button type="submit" class="rounded-lg border border-border px-4 py-2 text-sm font-medium hover:bg-muted transition-colors">
                Search
            </button>
            @if(request()->hasAny(['q', 'min_amount', 'max_amount']))
                <a href="{{ route('feed') }}" class="rounded-lg px-3 py-2 text-sm text-muted-foreground hover:text-foreground transition-colors">Clear</a>
            @endif
        </form>
    </div>

    {{-- Feed header --}}
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-lg font-semibold">Loan Requests</h1>
        <span class="text-sm text-muted-foreground">{{ $posts->total() }} open requests</span>
    </div>

    {{-- Thread-style feed --}}
    <div class="divide-y-0">
        @forelse($posts as $post)
            <x-loan-card :post="$post" />
        @empty
            <div class="py-16 text-center">
                <svg class="mx-auto h-12 w-12 text-muted-foreground/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                <h3 class="mt-4 text-sm font-medium">No loan requests yet</h3>
                <p class="mt-1 text-sm text-muted-foreground">Be the first to post a loan request.</p>
                @auth
                    <a href="{{ route('posts.create') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
                        Create a post
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($posts->hasPages())
        <div class="mt-6 border-t border-border pt-4">
            {{ $posts->links() }}
        </div>
    @endif
</x-layouts.app>