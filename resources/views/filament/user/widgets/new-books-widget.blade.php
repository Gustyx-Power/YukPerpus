<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ static::$heading }}
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($books as $book)
                <div class="flex flex-col lg:flex-row bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div class="w-full lg:w-1/3 h-48 lg:h-auto flex items-center justify-center bg-gray-100 dark:bg-gray-700">
                        <img src="{{ $book->cover ? Storage::url($book->cover) : 'https://via.placeholder.com/180x220?text=No+Cover' }}" alt="Cover" class="object-contain h-full w-auto rounded-lg" />
                    </div>
                    <div class="p-4 flex flex-col justify-between w-full lg:w-2/3">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ $book->judul }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">{{ $book->pengarang }}</p>
                            <p class="text-gray-500 dark:text-gray-300 text-xs line-clamp-2">{{ $book->deskripsi }}</p>
                        </div>
                        <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                            <p><strong>Stok:</strong> {{ $book->stok }}</p>
                            <p><strong>Kategori:</strong> {{ $book->category->nama }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 p-8">
                    <p class="text-lg">Tidak ada buku baru yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
