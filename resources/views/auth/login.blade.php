<x-layouts.guest title="Log in">
    <h1 class="text-xl font-semibold text-center mb-1">Welcome back</h1>
    <p class="text-sm text-muted-foreground text-center mb-6">Log in to your Kamibantu account</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium mb-1.5">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="off"
                   class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
            @error('email')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-1.5">Password</label>
            <input type="password" name="password" id="password" required
                   class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember"
                   class="h-4 w-4 rounded border-input text-primary focus:ring-ring">
            <label for="remember" class="text-sm text-muted-foreground">Remember me</label>
        </div>

        <button type="submit"
                class="w-full rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">
            Log in
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-muted-foreground">
        Don't have an account?
        <a href="{{ route('register') }}" class="font-medium text-foreground underline underline-offset-4 hover:text-primary">Sign up</a>
    </p>
</x-layouts.guest>