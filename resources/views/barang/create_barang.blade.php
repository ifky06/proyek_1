@extends('layouts.template')

@section('title', 'Barang')

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

                <form action="{{$url_form}}" method="post">
                    @csrf
                    {!! (isset($data))? method_field('PUT'):'' !!}
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{isset($data)?$data->nama:old('nama')}}">
                        @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select name="id_kategori" id="kategori" class="form-control">
                            @foreach($kategori as $row)
                            <option value="{{$row->id}}" @isset($data) @selected($data->id_kategori == $row->id) @endisset>{{$row->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pemasok">Pemasok</label>
                        <select name="id_pemasok" id="pemasok" class="form-control">
                            @foreach($pemasok as $row)
                            <option value="{{$row->id}}" @isset($data) @selected($data->id_pemasok == $row->id) @endisset>{{$row->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <select name="id_satuan" id="satuan" class="form-control">
                            @foreach($satuan as $row)
                            <option value="{{$row->id}}" @isset($data) @selected($data->id_satuan == $row->id) @endisset>{{$row->satuan}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" value="{{isset($data)?$data->harga:old('harga')}}">
                        @error('harga')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" value="{{isset($data)?$data->stok:old('stok')}}">
                        @error('stok')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
        <!-- /.card -->

    </section>
@endsection

@push('css')

@endpush

@push('scripts')

    {{--    <script>--}}
    {{--        alert('Selamat Datang');--}}
    {{--    </script>--}}

@endpush
