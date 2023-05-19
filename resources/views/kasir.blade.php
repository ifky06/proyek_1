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
                        <input id="totalqty" type="hidden" class="form-control" placeholder="Jumlah"
                               value="0">
                        <div class="input-group-append">
                            <button id="add" class="btn btn-primary">Add</button>
                            <button id="payingForm" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Pay</button>
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
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bayar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3 flex-nowrap">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text w-100" id="addon-wrapping">Total</span>
                            </div>
                            <input id="totalInput" type="number" class="form-control w-50" disabled placeholder="Nominal Pembayaran"
                                   value="">
                        </div>
                        <div class="input-group mb-3 flex-nowrap">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text w-100" id="addon-wrapping">Bayar</span>
                            </div>
                            <input id="payingInput" type="number" class="form-control w-50" placeholder="Masukkan Nominal"
                                   value="">
                        </div>
                        <div class="input-group mb-3 flex-nowrap">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text w-100" id="addon-wrapping">Kembalian</span>
                            </div>
                            <input id="changeInput" type="number" class="form-control w-50" disabled placeholder="Nominal Kembalian"
                                   value="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="pay" class="btn btn-primary">Bayar</button>
                    </div>
                </div>
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
            const data = {!! json_encode($data) !!};
            let item = [];

            updateTable();

            function updateTable() {
                let total = 0;
                let totalqty = 0;
                $('tbody').empty();

                if (item.length === 0) {
                    $('tbody').html('<tr><td colspan="6">No data</td></tr>');
                } else {
                    item.forEach(function(i) {
                        i.subtotal = parseInt(i.harga) * parseInt(i.qty);
                        let row = `<tr>
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
                        totalqty += parseInt(i.qty);
                        total += i.subtotal;
                        $('tbody').append(row);
                    });
                }
                $('#totalqty').val(totalqty);
                $('#total').html(total.toLocaleString());
            }

            $('#add').click(function() {
                let code = $('#code').val();
                let value = $('#value').val();
                let foundItem = data.find(function(item) {
                    return item.kode === code;
                });

                if (foundItem) {
                    let existingItem = item.find(function(item) {
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
                let code = $(this).closest('tr').find('.code').val();
                let value = $(this).val();
                let existingItem = item.find(function(item) {
                    return item.kode === code;
                });

                if (existingItem && value > 0) {
                    existingItem.qty = value;
                    updateTable();
                }
            });

            $(document).on('click', '.delete', function() {
                let code = $(this).closest('tr').find('.code').val();
                let index = item.findIndex(function(item) {
                    return item.kode === code;
                });

                if (index !== -1) {
                    item.splice(index, 1);
                    updateTable();
                }
            });

            $('#payingForm').click(function() {
                let total = $('#total').html().replace(/,/g, '');
                $('#totalInput').val(total);
            });

            $(document).on('change', '#payingInput', function() {
                let total = $('#totalInput').val();
                let paying = $(this).val();
                let change = parseInt(paying) - parseInt(total);
                $('#changeInput').val(change);
            });

            $('#pay').click(function() {
                let payment =
                    {
                        'qty': parseInt($('#totalqty').val()),
                        'total': parseInt($('#total').html().replace(/,/g, '')),
                        'bayar': parseInt($('#payingInput').val()),
                        'kembali': parseInt($('#changeInput').val())
                    }
                // console.log(payment);
                storeData(payment);

            });

            // store data to database

            function storeData(payment) {
                $.ajax({
                    url: "{{ route('kasir.store') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        data: {
                            'item': item,
                            'payment': payment
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
                                window.location.href = "{{ route('kasir.index') }}";
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
