@extends('layouts.template')

@section('title', 'Pengguna')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profil Pengguna</h1>
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

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <i class="fas fa-user fa-5x my-4"></i>
              </div>
              <h3 class="profile-username text-center">{{$data->name}}</h3>

              <p class="text-muted text-center">{{$data->rolename}}</p>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- About Me Box -->
          
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
                <h4 class="pt-2 pl-2">Edit Profil</h4>
            </div><!-- /.card-header -->
            <div class="card-body">
                <form id="editProfil" action="{{url('user/profile')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="{{isset($data)?$data->username:old('username')}}">
                        @error('username')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{isset($data)?$data->name:old('name')}}">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{isset($data)?$data->email:old('email')}}">
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}">
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
@endsection

@push('scripts')

    <script>
        $(document).ready(function () {
            $('#editProfil').submit(function () {
                Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda ingin mengubah profil Anda?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6', // blue
                cancelButtonColor: '#d33', // red
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
                return false;
            })
        });
    </script>

@endpush