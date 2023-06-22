<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Masuk</title>
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
    <h3>Laporan Transaksi Masuk</h3>
</div>
<table class="table text-center">
    <thead>
    <tr>
        <th>Tanggal</th>
        <th>Jumlah</th>
        <th>User</th>
    </tr>
    </thead>
    <tbody>
        @foreach($tmasuk as $row)
            <tr>
                <td>{{ $row->created_at}}</td>
                <td>{{ $row->qty}}</td>
                <td>{{ $row->id_users}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>