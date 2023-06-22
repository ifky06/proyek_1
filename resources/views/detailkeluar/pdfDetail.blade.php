<!DOCTYPE html>
<html>
<head>
    <title>Laporan Detail Transaksi Keluar</title>
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
    <h3>Laporan Detail Transaksi Keluar</h3>
</div>
<table class="table text-center">
    <thead>
    <tr>
        <th>Tanggal</th>
        <th>ID Transaksi</th>
        <th>Kode</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Total</th>
        <th>User</th>
    </tr>
    </thead>
    <tbody>
        @foreach($dtkeluar as $row)
            <tr>
                <td>{{ $row->tanggal}}</td>
                <td>{{ $row->id_transaksi}}</td>
                <td>{{ $row->barang->kode}}</td>
                <td>{{ $row->barang->nama}}</td>
                <td>{{ $row->qty}}</td>
                <td>{{ $row->grandtotal}}</td>
                <td>{{ $row->user}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>