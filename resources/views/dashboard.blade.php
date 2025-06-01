<x-app-layout>


    <x-slot name="header">
        <div class="d-flex align-items-center mb-4" style="min-height:48px;">
            <h1 class="section-title mb-0" style="font-size:2rem; font-weight:700; color:#34395e;">Dashboard</h1>
        </div>
    </x-slot>

    <div class="row mb-4 justify-content-center" style="gap: 0;">
        <div class="col-lg-3 col-md-6 col-12 mb-3 d-flex">
            <div class="card shadow-sm flex-fill d-flex flex-row align-items-center p-3" style="gap: 1rem; min-height: 100px;">
                <div>
                    <div class="text-muted small mb-1">Total Buku</div>
                    <div class="h4 mb-0 font-weight-bold">{{ \App\Models\Book::count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-3 d-flex">
            <div class="card shadow-sm flex-fill d-flex flex-row align-items-center p-3" style="gap: 1rem; min-height: 100px;">
                <div>
                    <div class="text-muted small mb-1">Peminjaman Aktif</div>
                    <div class="h4 mb-0 font-weight-bold">{{ \App\Models\Loan::whereIn('status', ['reserved', 'dipinjam'])->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-3 d-flex">
            <div class="card shadow-sm flex-fill d-flex flex-row align-items-center p-3" style="gap: 1rem; min-height: 100px;">
                <div>
                    <div class="text-muted small mb-1">Total Anggota</div>
                    <div class="h4 mb-0 font-weight-bold">{{ \App\Models\User::where('level', 'anggota')->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-3 d-flex">
            <div class="card shadow-sm flex-fill d-flex flex-row align-items-center p-3" style="gap: 1rem; min-height: 100px;">
                <div>
                    <div class="text-muted small mb-1">Total Kategori</div>
                    <div class="h4 mb-0 font-weight-bold">{{ \App\Models\Category::count() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Tombol Laporan --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4>Generate Laporan PDF</h4>
                </div>
                <div class="card-body d-flex justify-content-start" style="gap: 10px;">
                    <a href="{{ route('reports.books') }}" target="_blank" class="btn btn-primary btn-icon icon-left">
                        <i class="fas fa-book"></i> Laporan Buku
                    </a>
                    <a href="{{ route('reports.fines') }}" target="_blank" class="btn btn-danger btn-icon icon-left">
                        <i class="fas fa-file-invoice-dollar"></i> Laporan Denda
                    </a>
                    {{-- Tambahkan tombol laporan lain di sini jika ada --}}
                </div>
            </div>
        </div>
    </div>
    {{-- Akhir Bagian Tombol Laporan --}}


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Peminjaman Terbaru</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Buku</th>
                                    <th>Peminjam</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (\App\Models\Loan::with(['book', 'user'])->latest()->take(5)->get() as $loan)
                                    <tr>
                                        <td>
                                            <div class="font-weight-600">{{ $loan->book->judul }}</div>
                                            <div class="text-muted text-small">ISBN: {{ $loan->book->isbn }}</div>
                                        </td>
                                        <td>
                                            <div class="font-weight-600">{{ $loan->user->nama }}</div>
                                            <div class="text-muted text-small">{{ $loan->user->email }}</div>
                                        </td>
                                        <td>{{ $loan->tanggal_pinjam->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $loan->status === 'reserved' ? 'warning' :
                                                ($loan->status === 'dipinjam' ? 'primary' :
                                                ($loan->status === 'dikembalikan' ? 'success' : 'danger')) }}">
                                                {{ ucfirst($loan->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data peminjaman</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center pt-1 pb-1">
                        <a href="{{ route('loans.index') }}" class="btn btn-primary btn-lg btn-round">
                            Lihat Semua Peminjaman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-statistic-1 {
            display: inline-block;
            width: 100%;
        }
        .card-statistic-1 .card-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            line-height: 80px;
            text-align: center;
            font-size: 30px;
            color: #fff;
        }
        .card-statistic-1 .card-wrap {
            padding: 20px;
        }
        .card-statistic-1 .card-header {
            padding: 0;
            margin-bottom: 10px;
        }
        .card-statistic-1 .card-header h4 {
            font-size: 16px;
            font-weight: 600;
            color: #6c757d;
        }
        .card-statistic-1 .card-body {
            font-size: 24px;
            font-weight: 700;
            color: #34395e;
        }
        .table th {
            font-weight: 600;
            color: #6c757d;
        }
        .badge {
            padding: 0.5em 0.75em;
            font-size: 75%;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #fff;
        }
        .badge-primary {
            background-color: #34395e;
            color: #fff;
        }
        .badge-success {
            background-color: #1cc88a;
            color: #fff;
        }
        .badge-danger {
            background-color: #e74a3b;
            color: #fff;
        }
        .btn-round {
            border-radius: 50px;
        }
        .btn-primary {
            background-color: #34395e;
            border-color: #34395e;
        }
        .btn-primary:hover {
            background-color: #2a2f4a;
            border-color: #2a2f4a;
        }
        /* Tambahan untuk tombol laporan jika menggunakan Font Awesome */
        .btn-icon.icon-left i {
            margin-right: 0.5rem;
        }
    </style>
</x-app-layout>
