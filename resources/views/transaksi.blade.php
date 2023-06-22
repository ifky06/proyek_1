@extends('layouts.template')

@section('title', 'Transaksi Masuk')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pembelian</h1>
                </div>
                {{--                <div class="col-sm-6">--}}
                {{--                    <ol class="breadcrumb float-sm-right">--}}
                {{--                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>--}}
                {{--                        <li class="breadcrumb-item active">Dashboard</li>--}}
                {{--                    </ol>--}}
                {{--                </div>--}}
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-around">
                    <div class="input-group mb-3">
                        <input id="code" type="text" class="form-control w-50" placeholder="Kode Barang"
                               value="">
                        <ul class="list-group" id="result"></ul>
                        <input id="value" type="text" class="form-control" placeholder="Jumlah"
                               value="">
                        <input id="totalqty" type="hidden" class="form-control" placeholder="Jumlah"
                               value="0">
                        <div class="input-group-append">
                            <button id="add" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped mb-3">
                    <thead>
                    <tr>
                        <th style="width: 10%">Kode</th>
                        <th>Nama</th>
                        <th style="width: 10%">QTY</th>
                        <th style="width: 5%">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="input-group-append">
                    <button type="button" id="input" class="btn btn-success">Input Data</button>
                </div>
            </div>
        </div>

        <!-- /.card -->

    </section>


@endsection

@push('css')
    <style>
        #result {
            position: absolute;
            top: 38px;
            width: 63%;
            max-width: 870px;
            cursor: pointer;
            overflow-y: auto;
            max-height: 400px;
            box-sizing: border-box;
            z-index: 1001;
        }

        .link-class:hover {
            background-color: #f1f1f1;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            let data = [];
            $.ajax({
                url: "{{ url('barang/datajson') }}",
                method: "POST",
                data: {query: ''},
                success: function (response) {
                    data = response;
                }
            });
            $('#code').keyup(function () {
                let html = '';
                let query = $(this).val();
                if (query !== '') {
                    let regex = new RegExp(query, 'i');
                    let result = $.grep(data, function (v) {
                        return regex.test(v.kode);
                    });
                    for (let i = 0; i < result.length; i++) {
                        if (i === 5) {
                            break;
                        }
                        html += '<li class="list-group-item link-class">' + result[i].kode + ' | ' + result[i].nama + '</li>';
                    }
                }
                $('#result').html(html);
            });
            $('#result').on('click', 'li', function () {
                let value = $(this).text().split(' | ');
                $('#code').val(value[0]);
                $('#result').html('');
            });

        });
        $(document).ready(function() {
            var data = {!! json_encode($data) !!};
            var item = [];

            updateTable();

            function updateTable() {
                var total = 0;
                var totalqty = 0;
                $('tbody').empty();

                if (item.length === 0) {
                    $('tbody').html('<tr><td colspan="6">No data</td></tr>');
                } else {
                    item.forEach(function(i) {
                        var row = `<tr>
                    <input type="hidden" class="code" value="${i.kode}">
                    <td>${i.kode}</td>
                    <td>${i.nama}</td>

                    <td>
                        <input type="number" class="form-control form-control-sm value" value="${i.qty}">
                    </td>

                    <td><button class="btn btn-danger btn-sm delete">Delete</button></td>
                </tr>`;
                        totalqty += parseInt(i.qty);
                        total += i.subtotal;
                        $('tbody').append(row);
                    });
                }
                $('#totalqty').val(totalqty);
                $('#total').html(total.toLocaleString());
            }

            $('#add').click(function() {
                var code = $('#code').val();
                var value = $('#value').val();
                var foundItem = data.find(function(item) {
                    return item.kode === code;
                });

                if (foundItem) {
                    var existingItem = item.find(function(item) {
                        return item.kode === foundItem.kode;
                    });

                    if (existingItem) {
                        existingItem.qty = parseInt(existingItem.qty) + parseInt(value);
                    } else {
                        item.push({
                            id: foundItem.id,
                            kode: foundItem.kode,
                            nama: foundItem.nama,
                            harga: foundItem.harga,
                            qty: value
                        });
                    }

                    updateTable();
                }
            });

            $(document).on('change', '.value', function() {
                var code = $(this).closest('tr').find('.code').val();
                var value = $(this).val();
                var existingItem = item.find(function(item) {
                    return item.kode === code;
                });

                if (existingItem && value > 0) {
                    existingItem.qty = value;
                    updateTable();
                }
            });

            $(document).on('click', '.delete', function() {
                var code = $(this).closest('tr').find('.code').val();
                var index = item.findIndex(function(item) {
                    return item.kode === code;
                });

                if (index !== -1) {
                    item.splice(index, 1);
                    updateTable();
                }
            });

            $('#payingForm').click(function() {
                var total = $('#total').html().replace(/,/g, '');
                $('#totalInput').val(total);
            });

            $(document).on('change', '#payingInput', function() {
                var total = $('#totalInput').val();
                var paying = $(this).val();
                var change = parseInt(paying) - parseInt(total);
                $('#changeInput').val(change);
            });

            $('#input').click(function() {
                var qty =
                    {
                        'qty': parseInt($('#totalqty').val()),
                    }
                // console.log(payment);
                storeData(qty);

            });

            // store data to database

            function storeData(qty) {
                $.ajax({
                    url: "{{ route('transaksimasuk.store') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        data: {
                            'item': item,
                            'qty': qty
                        }
                    },
                    success: function (response) {
                        clearData();

                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Transaksi Berhasil',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('transaksimasuk.index') }}";
                            }
                        })
                    }
                });
            }

            function clearData() {
                item = [];
                updateTable();

                $('#code').val('');
                $('#value').val('');
                $('#totalqty').val('');
                $('#total').html('');
                $('#totalInput').val('');
                $('#payingInput').val('');
                $('#changeInput').val('');
            }
        });
            {{--$.ajax({--}}
            {{--    url: "{{ route('kasir.store') }}",--}}
            {{--    method: "POST",--}}
            {{--    data: {--}}
            {{--        _token: '{{ csrf_token() }}',--}}
            {{--        data: item--}}
            {{--    },--}}
            {{--    success: function (response) {--}}
            {{--        console.log(response);--}}
            {{--    }--}}
            {{--});--}}

    </script>

@endpush
