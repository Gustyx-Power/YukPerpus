@php($panel = filament()->getCurrentPanel())

<x-filament::layouts.app :title="__('filament-panels::pages/auth/login.title')">
    <div class="w-full max-w-md mx-auto my-10">
        <x-filament-panels::auth.login-form />
        <div class="mt-6 flex flex-col gap-2">
            <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="filament-button w-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center gap-2">
                <x-dynamic-component :component="Filament::getIconComponent('google')" class="w-5 h-5" />
                Login / Daftar dengan Google
            </a>
            <a href="{{ route('social.redirect', ['provider' => 'github']) }}" class="filament-button w-full bg-gray-800 hover:bg-gray-900 text-white flex items-center justify-center gap-2">
                <x-dynamic-component :component="Filament::getIconComponent('github')" class="w-5 h-5" />
                Login / Daftar dengan GitHub
            </a>
        </div>
    </div>
</x-filament::layouts.app> 