<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; font-size: 9px; /* Ukuran font sedikit dikecilkan untuk memuat lebih banyak kolom */ word-wrap: break-word; /* Memastikan teks panjang tidak merusak layout */ }
        th { background-color: #f2f2f2; font-weight: bold; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Laporan Data Buku</h1>
    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 20%;">Judul</th>
                <th style="width: 10%;">ISBN</th>
                <th style="width: 15%;">Pengarang</th>
                <th style="width: 15%;">Penerbit</th>
                <th style="width: 7%;">Tahun Terbit</th>
                <th style="width: 7%;">Jml. Halaman</th>
                <th style="width: 5%;">Stok</th>
                <th style="width: 8%;">Lokasi Rak</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($books) && $books->count() > 0)
                @foreach($books as $index => $book)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $book->judul }}</td>
                    <td>{{ $book->isbn }}</td>
                    <td>{{ $book->pengarang }}</td>
                    <td>{{ $book->penerbit }}</td>
                    <td>{{ $book->tahun_terbit }}</td>
                    <td>{{ $book->jumlah_halaman }}</td>
                    <td>{{ $book->stok }}</td>
                    <td>{{ $book->lokasi_rak }}</td> {{-- Asumsi ada kolom 'lokasi_rak' di tabel buku --}}
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10" style="text-align: center;">Tidak ada data buku.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
