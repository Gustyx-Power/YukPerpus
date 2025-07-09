
<div>
    <x-filament-panels::page>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-4 bg-red-500">
            @php
                $books = \App\Models\Book::where('status', 'tersedia')->get();
            @endphp

            @forelse ($books as $book)
                <x-filament::section>
                <div class="flex flex-col lg:flex-row">
                    <div class="w-full lg:w-1/3 h-64 flex items-center justify-center bg-gray-100 dark:bg-gray-700 lg:rounded-l-xl lg:rounded-tr-none rounded-t-xl">
                        <img src="{{ $book->cover ? Storage::url($book->cover) : 'https://via.placeholder.com/180x220?text=No+Cover' }}" alt="Cover" class="object-contain h-full w-auto rounded-lg" />
                    </div>
                    <div class="p-6 flex flex-col justify-between w-full lg:w-2/3">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $book->judul }}</h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">{{ $book->pengarang }}</p>
                            <p class="text-gray-500 dark:text-gray-300 text-sm line-clamp-3">{{ $book->deskripsi }}</p>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <x-filament::button
                                onclick="openBorrowModal({{ $book->id }}, '{{ addslashes($book->judul) }}')"
                            >
                                Pinjam
                            </x-filament::button>
                        </div>
                    </div>
                </div>
            </x-filament::section>
            @empty
                <div class="col-span-full text-center text-gray-500 p-8">
                    <p class="text-lg">Tidak ada buku yang tersedia untuk dipinjam.</p>
                </div>
            @endforelse
        </div>
    </x-filament-panels::page>


    {{-- Modal Deskripsi --}}
    <div id="desc-modal" class="fixed inset-0 z-[9999] hidden bg-black bg-opacity-60 flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl flex flex-col md:flex-row w-full max-w-5xl relative">
            <button onclick="closeDescModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-3xl font-bold">
                &times;
            </button>

            <div class="flex-shrink-0 w-full md:w-2/5 flex items-center justify-center p-6 bg-gray-100 dark:bg-gray-700">
                <img id="desc-modal-cover" src="" class="object-contain rounded-lg shadow-md w-full h-full">
            </div>

            <div class="flex-1 flex flex-col p-6 md:p-8 overflow-y-auto">
                <h2 id="desc-modal-title" class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2"></h2>
                <p id="desc-modal-author" class="text-base md:text-lg text-gray-600 dark:text-gray-400 mb-4"></p>
                <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300 mb-4">
                    <p><strong>ISBN:</strong> <span id="desc-modal-isbn"></span></p>
                    <p><strong>Penerbit:</strong> <span id="desc-modal-penerbit"></span></p>
                    <p><strong>Tahun:</strong> <span id="desc-modal-tahun-terbit"></span></p>
                    <p><strong>Halaman:</strong> <span id="desc-modal-jumlah-halaman"></span></p>
                    <p><strong>Stok:</strong> <span id="desc-modal-stok"></span></p>
                    <p><strong>Kategori:</strong> <span id="desc-modal-category"></span></p>
                    <p><strong>Rak:</strong> <span id="desc-modal-lokasi-rak"></span></p>
                </div>
                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-2">Ikhtisar</h3>
                <div id="desc-modal-content" class="w-full text-gray-700 dark:text-gray-300 text-base leading-relaxed prose dark:prose-invert mb-6"></div>
                <div class="flex justify-end mt-4">
                    <button id="desc-modal-borrow-btn" class="px-6 py-3 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700">
                        Pinjam Buku Ini
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Peminjaman --}}
    <div id="borrow-modal" class="fixed inset-0 z-[9999] hidden bg-black bg-opacity-60 flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md p-6 relative">
            <button onclick="closeBorrowModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-3xl font-bold">
                &times;
            </button>
            <form id="borrow-form" method="POST" action="{{ route('rakbuku.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="book_id" id="modal-book-id">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Pinjam Buku: <span id="modal-book-title" class="font-normal"></span></h2>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="modal-tanggal-pinjam" required
                           class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" id="modal-tanggal-kembali" required
                           class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                              class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                </div>
                <button type="submit"
                        class="w-full py-2.5 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700">
                    Simpan Peminjaman
                </button>
            </form>
        </div>
    </div>

    {{-- Script Modal --}}
    <script>
        function openDescModal(id, title, author, desc, cover, isbn, penerbit, tahun, halaman, stok, kategori, rak) {
            document.body.classList.add('overflow-hidden');
            document.getElementById('desc-modal-title').innerText = title;
            document.getElementById('desc-modal-author').innerText = author;
            document.getElementById('desc-modal-content').innerHTML = desc;
            document.getElementById('desc-modal-cover').src = cover;
            document.getElementById('desc-modal-isbn').innerText = isbn;
            document.getElementById('desc-modal-penerbit').innerText = penerbit;
            document.getElementById('desc-modal-tahun-terbit').innerText = tahun;
            document.getElementById('desc-modal-jumlah-halaman').innerText = halaman;
            document.getElementById('desc-modal-stok').innerText = stok;
            document.getElementById('desc-modal-category').innerText = kategori;
            document.getElementById('desc-modal-lokasi-rak').innerText = rak;
            document.getElementById('desc-modal').classList.remove('hidden');

            document.getElementById('desc-modal-borrow-btn').onclick = function () {
                closeDescModal();
                openBorrowModal(id, title);
            };
        }

        function closeDescModal() {
            document.body.classList.remove('overflow-hidden');
            document.getElementById('desc-modal').classList.add('hidden');
        }

        function openBorrowModal(id, title) {
            const now = new Date();
            const next = new Date();
            next.setDate(now.getDate() + 7);

            document.body.classList.add('overflow-hidden');
            document.getElementById('modal-book-id').value = id;
            document.getElementById('modal-book-title').innerText = title;
            document.getElementById('modal-tanggal-pinjam').value = now.toISOString().slice(0, 10);
            document.getElementById('modal-tanggal-kembali').value = next.toISOString().slice(0, 10);
            document.getElementById('borrow-modal').classList.remove('hidden');
        }

        function closeBorrowModal() {
            document.body.classList.remove('overflow-hidden');
            document.getElementById('borrow-modal').classList.add('hidden');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDescModal();
                closeBorrowModal();
            }
        });
    </script>
</div>
