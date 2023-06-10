@extends('layouts.template')

@section('title', 'Pemasok')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pemasok</h1>
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
            <div class="card-header">
                <h3 class="card-title">Pemasok</h3>
            </div>
            <div class="card-body">
                @if(Auth::user()->role != 2)
                <a href="{{url('pemasok/create')}}" class="btn btn-sm btn-success my-2">Tambah Data</a>
                @endif

                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No.Telp</th>
                        @if(Auth::user()->role != 2)
                            <th>Action</th>
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

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('pemasok/data') }}",
                    dataType: 'json',
                    type: 'POST',
                },
                columns: [
                    {data: 'number', name: 'number', orderable: false, searchable: false},
                    {data: 'kode', name: 'kode'},
                    {data: 'nama', name: 'nama'},
                    {data: 'alamat', name: 'alamat'},
                    {data: 'no_tlp', name: 'no_tlp'},
                    @if(Auth::user()->role != 2)
                    {data: 'id', name: 'id', orderable: false, searchable: false,
                        render: function (data, type, full, meta) {
                            return '<a href="{{url('pemasok')}}/'+data+'/edit" class="btn btn-primary btn-sm mr-1">Edit</a>' +
                                '<button class="btn btn-danger btn-sm btn-delete" data-id="'+ data +'">Delete</button>';
                        }
                    },
                    @endif
                ]
            });

            $(document).on('click', '.btn-delete', function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Setelah dihapus, Anda tidak dapat memulihkan Data ini lagi!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6', // blue
                    cancelButtonColor: '#d33', // red
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('<form>').attr({
                            action: "{{url('pemasok')}}/" + id,
                            method: 'POST',
                            class: 'delete-form'
                        }).append('@csrf', '@method("DELETE")');

                        form.appendTo('body').submit();
                    }
                })
            });
        });

    </script>

@endpush
