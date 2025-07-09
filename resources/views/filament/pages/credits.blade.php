<x-filament-panels::page>
    <div class="fi-page-content">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($this->developers as $developer)
                <x-filament::card>
                    <div class="flex flex-col items-center space-y-4">
                        <img src="{{ $developer['photo'] }}" alt="{{ $developer['name'] }}" class="w-24 h-24 rounded-full object-cover">
                        <h2 class="text-xl font-bold">{{ $developer['name'] }}</h2>
                        @if ($developer['github'])
                            <p class="text-gray-600 dark:text-gray-400"><a href="https://github.com/{{ $developer['github'] }}" target="_blank" class="text-primary-500 hover:underline flex items-center space-x-3"><img src="{{ asset('assets/img/github.png') }}" alt="GitHub" class="w-7 h-7"><span>{{ $developer['github'] }}</span></a></p>
                        @endif
                        @if ($developer['telegram'])
                            <p class="text-gray-600 dark:text-gray-400"><a href="https://t.me/{{ str_replace('@', '', $developer['telegram']) }}" target="_blank" class="text-primary-500 hover:underline flex items-center space-x-3"><img src="{{ asset('assets/img/telegram_104163.png') }}" alt="Telegram" class="w-7 h-7"><span>{{ $developer['telegram'] }}</span></a></p>
                        @endif
                    </div>
                </x-filament::card>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>