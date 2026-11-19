<x-layouts.guest title="Sign up">
    <h1 class="text-xl font-semibold text-center mb-1">Create an account</h1>
    <p class="text-sm text-muted-foreground text-center mb-6">Join Kamibantu to request or offer loans</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium mb-1.5">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus autocomplete="off"
                   class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
            @error('name')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-1.5">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="off"
                   class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
            @error('email')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="whatsapp_number" class="block text-sm font-medium mb-1.5">WhatsApp Number</label>
            <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number') }}"
                   placeholder="e.g. 081234567890 or 6281234567890" required
                   class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
            <p class="mt-1 text-xs text-muted-foreground">This won't be shown publicly. Lenders contact you via button.</p>
            @error('whatsapp_number')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-1.5">Password</label>
            <input type="password" name="password" id="password" required
                   class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
            @error('password')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-1.5">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
        </div>

        <button type="submit"
                class="w-full rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
            Create account
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-muted-foreground">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-foreground underline underline-offset-4 hover:text-primary">Log in</a>
    </p>
</x-layouts.guest>