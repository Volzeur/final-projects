@props(['name' => 'description', 'value' => ''])

<div class="wysiwyg-wrapper">
    {{-- Hidden input that holds the HTML for form submission --}}
    <input type="hidden" name="{{ $name }}" id="{{ $name }}-input" value="{{ $value }}">

    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center gap-0.5 rounded-t-lg border border-border bg-muted px-2 py-1.5">
        <button type="button" onclick="wysiwygCmd('bold')" title="Bold"
                class="wysiwyg-btn rounded-md p-1.5 hover:bg-background transition-colors" data-cmd="bold">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/><path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/></svg>
        </button>
        <button type="button" onclick="wysiwygCmd('italic')" title="Italic"
                class="wysiwyg-btn rounded-md p-1.5 hover:bg-background transition-colors" data-cmd="italic">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="4" x2="10" y2="4"/><line x1="14" y1="20" x2="5" y2="20"/><line x1="15" y1="4" x2="9" y2="20"/></svg>
        </button>
        <button type="button" onclick="wysiwygCmd('underline')" title="Underline"
                class="wysiwyg-btn rounded-md p-1.5 hover:bg-background transition-colors" data-cmd="underline">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3v7a6 6 0 0 0 6 6 6 6 0 0 0 6-6V3"/><line x1="4" y1="21" x2="20" y2="21"/></svg>
        </button>

        <div class="mx-1 h-5 w-px bg-border"></div>

        <button type="button" onclick="wysiwygCmd('insertUnorderedList')" title="Bullet List"
                class="wysiwyg-btn rounded-md p-1.5 hover:bg-background transition-colors" data-cmd="insertUnorderedList">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><circle cx="4" cy="6" r="1" fill="currentColor"/><circle cx="4" cy="12" r="1" fill="currentColor"/><circle cx="4" cy="18" r="1" fill="currentColor"/></svg>
        </button>
        <button type="button" onclick="wysiwygCmd('insertOrderedList')" title="Numbered List"
                class="wysiwyg-btn rounded-md p-1.5 hover:bg-background transition-colors" data-cmd="insertOrderedList">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><text x="3" y="8" font-size="7" fill="currentColor" stroke="none" font-family="sans-serif">1</text><text x="3" y="14" font-size="7" fill="currentColor" stroke="none" font-family="sans-serif">2</text><text x="3" y="20" font-size="7" fill="currentColor" stroke="none" font-family="sans-serif">3</text></svg>
        </button>

        <div class="mx-1 h-5 w-px bg-border"></div>

        <button type="button" onclick="wysiwygHeading()" title="Heading"
                class="wysiwyg-btn rounded-md p-1.5 hover:bg-background transition-colors" data-cmd="heading">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 4v16"/><path d="M18 4v16"/><path d="M6 12h12"/></svg>
        </button>
        <button type="button" onclick="wysiwygLink()" title="Insert Link"
                class="wysiwyg-btn rounded-md p-1.5 hover:bg-background transition-colors">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
        </button>
        <button type="button" onclick="wysiwygCmd('removeFormat')" title="Clear Formatting"
                class="wysiwyg-btn rounded-md p-1.5 hover:bg-background transition-colors">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16"/><path d="M10 7v10"/><path d="M3 21l18-18"/></svg>
        </button>
    </div>

    {{-- Editable area --}}
    <div id="{{ $name }}-editor"
         contenteditable="true"
         class="min-h-[180px] rounded-b-lg border border-t-0 border-border bg-background px-4 py-3 text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 prose prose-sm prose-zinc max-w-none"
         data-placeholder="Describe your loan request...">{!! $value !!}</div>
</div>

<style>
    [contenteditable=true]:empty:before {
        content: attr(data-placeholder);
        color: #a1a1aa;
        pointer-events: none;
        display: block;
    }
    [contenteditable=true]:focus {
        outline: none;
    }
    [contenteditable=true] ul {
        list-style-type: disc;
        padding-left: 1.5em;
        margin: 0.5em 0;
    }
    [contenteditable=true] ol {
        list-style-type: decimal;
        padding-left: 1.5em;
        margin: 0.5em 0;
    }
    [contenteditable=true] h3 {
        font-size: 1.1em;
        font-weight: 600;
        margin: 0.5em 0;
    }
    [contenteditable=true] a {
        color: #3b82f6;
        text-decoration: underline;
    }
    .wysiwyg-btn.active {
        background-color: #e4e4e7;
    }
</style>

<script>
(function() {
    const editorId = '{{ $name }}-editor';
    const inputId = '{{ $name }}-input';
    const editor = document.getElementById(editorId);
    const hiddenInput = document.getElementById(inputId);

    // Sync content to hidden input on every change
    function syncContent() {
        hiddenInput.value = editor.innerHTML;
        updateToolbarState();
    }

    editor.addEventListener('input', syncContent);
    editor.addEventListener('keyup', updateToolbarState);
    editor.addEventListener('mouseup', updateToolbarState);

    // Sync before form submit
    const form = editor.closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            hiddenInput.value = editor.innerHTML;
        });
    }

    // Execute formatting command
    window.wysiwygCmd = function(command, value) {
        editor.focus();
        document.execCommand(command, false, value || null);
        syncContent();
    };

    // Toggle heading
    window.wysiwygHeading = function() {
        editor.focus();
        const current = document.queryCommandValue('formatBlock');
        if (current === 'h3') {
            document.execCommand('formatBlock', false, 'p');
        } else {
            document.execCommand('formatBlock', false, 'h3');
        }
        syncContent();
    };

    // Insert link
    window.wysiwygLink = function() {
        const url = prompt('Enter URL:', 'https://');
        if (url) {
            editor.focus();
            document.execCommand('createLink', false, url);
            syncContent();
        }
    };

    // Highlight active toolbar buttons
    function updateToolbarState() {
        const commands = ['bold', 'italic', 'underline', 'insertUnorderedList', 'insertOrderedList'];
        commands.forEach(function(cmd) {
            const btn = document.querySelector('[data-cmd="' + cmd + '"]');
            if (btn) {
                if (document.queryCommandState(cmd)) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            }
        });

        // Heading state
        const headingBtn = document.querySelector('[data-cmd="heading"]');
        if (headingBtn) {
            if (document.queryCommandValue('formatBlock') === 'h3') {
                headingBtn.classList.add('active');
            } else {
                headingBtn.classList.remove('active');
            }
        }
    }

    // Prevent losing focus when clicking toolbar buttons
    document.querySelectorAll('.wysiwyg-btn').forEach(function(btn) {
        btn.addEventListener('mousedown', function(e) {
            e.preventDefault(); // Keep focus in editor
        });
    });
})();
</script>