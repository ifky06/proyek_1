@extends('layouts.template')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Barang</h1>
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
                        <input id="value" type="text" class="form-control" placeholder="Jumlah"
                               value="">
                        <div class="input-group-append">
                            <button id="add" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                    <div class="input-group text-right">
                        <h2 id="total" class="p-0 w-100"></h2>
                    </div>
                </div>
                <table class="table table-bordered table-striped mb-3">
                    <thead>
                    <tr>
                        <th style="width: 10%">Kode</th>
                        <th>Nama</th>
                        <th style="width: 10%">Harga</th>
                        <th style="width: 10%">QTY</th>
                        <th style="width: 10%">Subtotal</th>
                        <th style="width: 5%">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
{{--                <div class="input-group mb-3 w-50">--}}
{{--                    <input id="total" type="text" class="form-control w-50" placeholder="Total"--}}
{{--                           value="">--}}
{{--                    <div class="input-group-append">--}}
{{--                        <button id="bayar" class="btn btn-primary" >Bayar</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
        <!-- /.card -->

    </section>


@endsection

@push('css')

@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            var data = {!! json_encode($data) !!};
            var item = [];

            function updateTable() {
                var total = 0;
                $('tbody').empty();

                if (item.length === 0) {
                    $('tbody').html('<tr><td colspan="6">No data</td></tr>');
                } else {
                    item.forEach(function(i) {
                        i.subtotal = parseInt(i.harga) * parseInt(i.qty);
                        var row = `<tr>
                    <input type="hidden" class="code" value="${i.kode}">
                    <td>${i.kode}</td>
                    <td>${i.nama}</td>
                    <td>${i.harga.toLocaleString()}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm value" value="${i.qty}">
                    </td>
                    <td>${i.subtotal.toLocaleString()}</td>
                    <td><button class="btn btn-danger btn-sm delete">Delete</button></td>
                </tr>`;
                        total += i.subtotal;
                        $('tbody').append(row);
                    });
                }

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

                if (existingItem) {
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

            updateTable();


            $('#bayar').click(function() {
                var total = $('#total').val();
                var bayar = prompt('Total: ' + total + '\nBayar: ');

                if (bayar) {
                    var kembali = parseInt(bayar) - parseInt(total);
                    alert('Kembali: ' + kembali);
                    item = [];
                    updateTable();
                }
            });
            // store data to database
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
