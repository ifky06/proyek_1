@extends('layouts.template')

@section('title', 'Kategori')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kategori</h1>
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
