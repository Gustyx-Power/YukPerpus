<!DOCTYPE html>
<html>
<head>
    <title>Laporan Buku</title>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Data Buku</h1>
    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
                <th>Stok</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book->judul }}</td>
                <td>{{ $book->pengarang }}</td>
                <td>{{ $book->penerbit }}</td>
                <td>{{ $book->tahun_terbit }}</td>
                <td>{{ $book->stok }}</td>
                <td>{{ $book->category->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>