@extends('layouts.template')

@section('title', 'Pengguna')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pengguna</h1>
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
                <h3 class="card-title">Pengguna</h3>
            </div>
            <div class="card-body">
                <a href="{{url('user/create')}}" class="btn btn-sm btn-success my-2">Tambah Data</a>
                <div class="row pt-1">
                    <p class="mx-2">Filter:</p>
                    <select class="form-control form-control-sm mr-1" style="width: 15%" id="roleFilter">
                        <option value="">-- Pilih Role --</option>
                    </select>
                    <button class="btn btn-sm btn-warning h-75" disabled id="clearButton">Clear</button>
                </div>
                <table id="dataTable" class="table table-bordered table-striped mb-3">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
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
            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('user/data') }}",
                    dataType: 'json',
                    type: 'POST',
                },
                columns: [
                    {data: 'number', name: 'number'},
                    {data: 'username', name: 'username'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'rolename', name: 'rolename'},
                    {data: 'id', name: 'id', orderable: false, searchable: false,
                        render: function (data, type, full, meta) {
                            let user_id = {{Auth::user()->id}};
                            if (user_id === data) {
                                return '<a href="{{url('user')}}/'+data+'/edit" class="btn btn-primary btn-sm mr-1">Edit</a>';
                            }
                            return '<a href="{{url('user')}}/'+data+'/edit" class="btn btn-primary btn-sm mr-1">Edit</a>' +
                                '<button class="btn btn-danger btn-sm btn-delete" data-id="'+ data +'">Delete</button>';
                        }
                    },
                ]
            });

            const role = ['Owner', 'Admin', 'Kasir'];

            $.each(role, function (index, value) {
                $('#roleFilter').append('<option value="'+value+'">'+value+'</option>');
            });

            $('#roleFilter').change(function () {
                table.column(4).search($(this).val()).draw()
            });

            $('#clearButton').click(function () {
                $('#roleFilter').val('');

                table.column(4).search('').draw();
                $(this).attr('disabled', true);
            });

            $('#roleFilter').change(function () {
                if ($('#roleFilter').val() != '') {
                    $('#clearButton').attr('disabled', false)
                } else {
                    $('#clearButton').attr('disabled', true)
                }
            })

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
                            action: "{{url('user')}}/" + id,
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
