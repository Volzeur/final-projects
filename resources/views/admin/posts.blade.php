<x-layouts.admin title="All Posts">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">All Posts</h1>
        <span class="text-sm text-muted-foreground">{{ $posts->count() }} total</span>
    </div>

    <div class="rounded-xl border border-border bg-card p-5">
        <table id="posts-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Borrower</th>
                    <th>Title</th>
                    <th>Amount (Rp)</th>
                    <th>Interest</th>
                    <th>Status</th>
                    <th>Posted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ Str::limit($post->title, 40) }}</td>
                        <td data-order="{{ $post->amount_needed }}">{{ number_format($post->amount_needed, 0, ',', '.') }}</td>
                        <td>{{ $post->interest_rate }}%</td>
                        <td>
                            @if($post->status === 'open')
                                <span class="badge-open">Open</span>
                            @else
                                <span class="badge-closed">Closed</span>
                            @endif
                        </td>
                        <td data-order="{{ $post->created_at->timestamp }}">{{ $post->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="actions-cell">
                                <a href="{{ route('posts.show', $post) }}" class="btn-action">View</a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                      onsubmit="return confirm('Delete this post?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-action btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#posts-table').DataTable({
                order: [[0, 'desc']],
                pageLength: 25,
                layout: {
                    topStart: { pageLength: { menu: [10, 25, 50, 100] } },
                    topEnd: { search: { placeholder: 'Search posts...' } },
                    bottomStart: 'info',
                    bottomEnd: { paging: { numbers: 3 } }
                },
                columnDefs: [
                    { orderable: false, targets: -1 } // disable sort on Actions column
                ]
            });
        });
    </script>
    @endpush
</x-layouts.admin>