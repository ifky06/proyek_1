@extends('layouts.template')

@section('title', 'Barang')

@section('content')

    {{--    add sweetalert2 message--}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Barang</h1>
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
        @if(Auth::user()->role != 2)
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="importForm" method="post" action="{{url('import/barang')}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="file" accept=".xlsx" name="file" id="image" class="form-control-file">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{url('import/barang/template')}}" class="btn btn-sm btn-success">Download
                                        Template</a>
                                    <button type="submit" class="btn btn-sm btn-primary" id="importButton">Import
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Barang</h3>
            </div>
            <div class="card-body">
                @if(Auth::user()->role != 2)
                    <a href="{{url('barang/create')}}" class="btn btn-sm btn-success my-2">Tambah Data</a>
                @endif
                <a href="{{url('satuan')}}" class="btn btn-sm btn-info my-2">Data Satuan</a>
                <a href="{{url('export/barang')}}" class="btn btn-sm btn-success my-2">Export Excel</a>
                @if(Auth::user()->role != 2)
                    <a href="#" class="btn btn-sm btn-warning my-2" data-toggle="modal" data-target="#exampleModal">Import
                        Excel</a>
                @endif
                <table class="table table-bordered table-striped mb-3 w-100" id="dataTable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Pemasok</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        @if(Auth::user()->role != 2)
                            <th style="width: 13%">Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->

    </section>

@endsection

@push('css')

@endpush

@push('scripts')
    {{--    add delete confirmation alert--}}
    <script>
        // format number harga
        $(document).ready(function () {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('barang/data') }}",
                    dataType: 'json',
                    type: 'POST',
                },
                columns: [
                    {data: 'number', name: 'number'},
                    {data: 'kode', name: 'kode'},
                    {data: 'nama', name: 'nama'},
                    {data: 'id_kategori', name: 'id_kategori'},
                    {data: 'id_pemasok', name: 'id_pemasok'},
                    {data: 'id_satuan', name: 'id_satuan'},
                    {
                        data: 'harga', name: 'harga',
                        render: function (data) {
                            return 'Rp. ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        },
                    },
                    {data: 'stok', name: 'stok'},
                        @if(Auth::user()->role != 2)
                    {
                        data: 'id', name: 'id', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            return '<a href="{{url('barang')}}/' + data + '/edit" class="btn btn-primary btn-sm mr-1">Edit</a>' +
                                '<button class="btn btn-danger btn-sm btn-delete" data-id="' + data + '">Delete</button>';
                        }
                    },
                    @endif
                ]
            });
        });

        $(document).ready(function () {
            // Event click pada tombol delete
            $(document).on('click', '.btn-delete', function () {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Setelah dihapus, Anda tidak dapat memulihkan Data ini lagi!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mengirimkan form penghapusan
                        var form = $('<form>').attr({
                            action: "{{url('barang')}}/" + id,
                            method: 'POST',
                            class: 'delete-form'
                        }).append('@csrf', '@method("DELETE")');

                        form.appendTo('body').submit();
                    }
                });
            });
        });
    </script>

@endpush
