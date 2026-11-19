<x-layouts.app title="My Posts">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">My Loan Requests</h1>
    </div>

    @forelse($posts as $post)
        <x-loan-card :post="$post" :showActions="true" />
    @empty
        <div class="py-16 text-center">
            <p class="text-muted-foreground">You haven't made any loan applications.</p>
            <a href="{{ route('posts.create') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
                Apply for your first loan
            </a>
        </div>
    @endforelse

    @if($posts->hasPages())
        <div class="mt-6 border-t border-border pt-4">
            {{ $posts->links() }}
        </div>
    @endif
</x-layouts.app>