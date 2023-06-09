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
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" value="{{isset($data)?$data->alamat:old('alamat')}}">
                        @error('alamat')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="no_tlp">No.Telp</label>
                        <input type="number" name="no_tlp" id="no_tlp" class="form-control" value="{{isset($data)?$data->no_tlp:old('no_tlp')}}">
                        @error('harga')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-primary btn-md">Submit</button>
                        <a class="btn btn-primary btn-md" href="{{ url('/pemasok') }}">Back</a>
                    </div>
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
