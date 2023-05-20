@extends('layouts.template')

@section('title', 'Barang')

@section('content')

{{--    add sweetalert2 message--}}
    @if(session('success'))
        <script>
            Swal.fire(
                'Success!',
                '{{session('success')}}',
                'success'
            )
        </script>
    @endif
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
                <a href="{{url('barang/create')}}" class="btn btn-sm btn-success my-2">Tambah Data</a>
                <a href="{{url('satuan')}}" class="btn btn-sm btn-info my-2">Data Satuan</a>
                <form action="{{url('barang')}}" method="get">
                    <div class="input-group mb-3 w-25">
                        <input type="text" name="search" class="form-control" placeholder="Search"
                               value="{{request()->search}}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered table-striped mb-3">
                    <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Pemasok</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $row)
                        <tr>
                            <input type="hidden" class="code" value="{{$row->kode}}">
                            <td>{{$row->kode}}</td>
                            <td>{{$row->nama}}</td>
                            <td>{{$row->kategori->nama}}</td>
                            <td>{{$row->pemasok->nama}}</td>
                            <td>{{$row->satuan->satuan}}</td>
                            <td>Rp. <span class="harga">{{$row->harga}}</span></td>
                            <td>{{$row->stok}}</td>
                            <td>
                                <a href="{{route('barang.edit', $row->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{route('barang.destroy', $row->id)}}" method="post" class="delete d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
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
            $('.delete').submit(function () {
                var code = $(this).closest('tr').find('.code').val();
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Setelah dihapus, Anda tidak dapat memulihkan Data Barang "+ code +" ini lagi!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6', // blue
                    cancelButtonColor: '#d33', // red
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
                return false;
            });

            // format number harga
            $(document).ready(function () {
                // get all harga

                $('.harga').each(function () {
                    let harga = $(this).text();
                    let reverse = harga.toString().split('').reverse().join(''),
                        ribuan = reverse.match(/\d{1,3}/g);
                    ribuan = ribuan.join(',').split('').reverse().join('');
                    $(this).text(ribuan);
                });
            });
        </script>


@endpush
