<x-filament-panels::page>
    <!-- List Card Buku -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @php
            $books = \App\Models\Book::where('status', 'tersedia')->get();
        @endphp
        @forelse($books as $book)
            <x-filament::section>
                <div class="flex flex-col items-center p-0 overflow-hidden" style="min-height: 370px;">
                    <div class="w-full flex-1 flex items-center justify-center bg-gray-200 dark:bg-gray-700" style="height: 220px;">
                        <img src="{{ $book->cover ? Storage::url($book->cover) : 'https://via.placeholder.com/180x220?text=No+Cover' }}" alt="Cover" class="object-cover w-full h-full rounded-t-2xl rounded-lg" style="max-height: 220px;">
                    </div>
                    <div class="w-full px-4 py-3 flex flex-col items-start">
                        <div class="text-lg font-bold text-gray-900 dark:text-white mb-0">{{ $book->judul }}</div>
                        <div class="text-sm text-gray-500 mb-3">{{ $book->pengarang }}</div>
                        <div class="flex gap-2 w-full mt-4">
                            <x-filament::button
                                class="flex-1"
                                onclick="openDescModal({{ $book->id }}, '{{ addslashes($book->judul) }}', '{{ addslashes($book->pengarang) }}', `{{ addslashes($book->deskripsi) }}`, '{{ $book->cover ? Storage::url($book->cover) : 'https://via.placeholder.com/180x220?text=No+Cover' }}')"
                            >
                                lihat deskripsi
                            </x-filament::button>
                            <x-filament::button
                                class="flex-1"
                                onclick="openBorrowModal({{ $book->id }}, '{{ addslashes($book->judul) }}')"
                            >
                                pinjam
                            </x-filament::button>
                        </div>
                    </div>
                </div>
            </x-filament::section>
        @empty
            <div class="col-span-4 text-center text-gray-500">Tidak ada buku yang tersedia untuk dipinjam.</div>
        @endforelse
    </div>

    <!-- Modal Deskripsi Buku -->
    <div id="desc-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-lg flex flex-col md:flex-row w-full max-w-4xl relative overflow-hidden" style="min-height: 340px;">
            <button onclick="closeDescModal()" class="absolute top-4 right-6 text-gray-400 hover:text-gray-600 text-3xl font-bold z-10" style="width: 48px; height: 48px;">&times;</button>
            <div class="flex-shrink-0 w-full md:w-2/5 flex items-center justify-center bg-gray-200 dark:bg-gray-900" style="min-height: 320px; max-width: 320px;">
                <img id="desc-modal-cover" src="" alt="Cover" class="object-cover rounded-2xl shadow-lg" style="max-height: 260px; max-width: 200px;">
            </div>
            <div class="flex-1 flex flex-col justify-between p-8 md:pl-12 gap-2 min-w-0">
                <div>
                    <div class="text-2xl font-bold mb-2 break-words" id="desc-modal-title"></div>
                    <div class="text-base text-gray-500 mb-4 break-words" id="desc-modal-author"></div>
                    <div class="font-semibold text-base text-gray-700 dark:text-gray-300 mb-2">IKHTISAR</div>
                    <div class="mb-8 text-gray-700 dark:text-gray-200 text-base leading-relaxed break-words" id="desc-modal-content"></div>
                </div>
                <div class="flex justify-end mt-8">
                    <button id="desc-modal-borrow-btn" class="px-6 py-2 bg-primary-600 text-white rounded-lg text-base font-semibold hover:bg-primary-700 transition">Pinjam Buku Ini</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pinjam Buku -->
    <div id="borrow-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md relative">
            <button onclick="closeBorrowModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
            <form id="borrow-form" method="POST" action="{{ route('rakbuku.store') }}">
                @csrf
                <input type="hidden" name="book_id" id="modal-book-id">
                <h2 class="text-lg font-bold mb-4">Pinjam Buku: <span id="modal-book-title"></span></h2>
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="modal-tanggal-pinjam" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" id="modal-tanggal-kembali" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Keterangan</label>
                    <textarea name="keterangan" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white"></textarea>
                </div>
                <button type="submit" class="w-full py-2 bg-primary-600 text-white rounded hover:bg-primary-700 transition">Simpan Peminjaman</button>
            </form>
        </div>
    </div>

    <script>
        function openDescModal(bookId, title, author, desc, cover) {
            document.getElementById('desc-modal-title').innerText = title;
            document.getElementById('desc-modal-author').innerText = author;
            document.getElementById('desc-modal-content').innerText = desc;
            document.getElementById('desc-modal-cover').src = cover;
            document.getElementById('desc-modal').classList.remove('hidden');
            // Pinjam dari modal deskripsi
            document.getElementById('desc-modal-borrow-btn').onclick = function() {
                closeDescModal();
                openBorrowModal(bookId, title);
            };
        }
        function closeDescModal() {
            document.getElementById('desc-modal').classList.add('hidden');
        }
        function openBorrowModal(bookId, bookTitle) {
            document.getElementById('modal-book-id').value = bookId;
            document.getElementById('modal-book-title').innerText = bookTitle;
            // Set default tanggal pinjam = hari ini, tanggal kembali = 7 hari ke depan
            const today = new Date();
            const nextWeek = new Date();
            nextWeek.setDate(today.getDate() + 7);
            document.getElementById('modal-tanggal-pinjam').value = today.toISOString().slice(0,10);
            document.getElementById('modal-tanggal-kembali').value = nextWeek.toISOString().slice(0,10);
            document.getElementById('borrow-modal').classList.remove('hidden');
        }
        function closeBorrowModal() {
            document.getElementById('borrow-modal').classList.add('hidden');
        }
        // Optional: close modal on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeBorrowModal();
                closeDescModal();
            }
        });
    </script>
</x-filament-panels::page>
