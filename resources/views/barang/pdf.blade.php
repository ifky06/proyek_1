<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" 
    crossorigin="anonymous">

    <style>
        .text-center {
            text-align: center;
        }
        .table {
            width: 100%;
            margin: 0 1rem;
            color: #212529;
            border: 1px solid #262626;
        }
        table tr td, table tr th {
            border: 1px solid #262626;
            padding: 0.5rem;
        }
    </style>
</head>
<body>
<div class="text-center">
    <h3>Data Barang</h3>
</div>
<table class="table text-center">
    <thead>
    <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Pemasok</th>
        <th>Satuan</th>
        <th>Harga</th>
        <th>Stok</th>
    </tr>
    </thead>
    <tbody>
        @foreach($barang as $row)
            <tr>
                <td>{{ $row->kode}}</td>
                <td>{{ $row->nama}}</td>
                <td>{{ $row->kategori->nama}}</td>
                <td>{{ $row->pemasok->nama}}</td>
                <td>{{ $row->satuan->satuan}}</td>
                <td>{{ $row->harga}}</td>
                <td>{{ $row->stok}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>