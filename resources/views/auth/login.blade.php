<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kios Sahabat Tani | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset ('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset ('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset ('assets/dist/css/adminlte.min.css')}}">
    <!-- jQuery -->
    <script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>

    <style>
        .banner {
            width: 450px;
            height: 500px;
            background-image: url('{{asset ('assets/banner2.jpeg')}}');
            background-size: cover;
        }

        .card {
            box-shadow: none;
        }

        .row {
            border: solid;
            border-width: 3px;
        }

        .login-page {
            background-color: #ffffff;
        }

        .login-box-msg {
            margin-bottom: 20px;
        }
    </style>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

    <!-- SweetAlert2 -->
    <script src="{{asset('/assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
</head>
<body>
<div class="hold-transition login-page">
    <div class="row">
        <div class="col-6">
            <div class="login-box w-100" style="margin-top: 50px">
                <div class="login-logo">
                    <a href="../../index2.html"><b>Kios</b> Sahabat Tani</a>
                </div>
                <div class="card bg-transparent border-0">
                    <div class="card-body ">
                        <p class="login-box-msg">Masukkan Username dan Password</p>

                        <form action="{{url ('/login')}}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Usename"
                                       id="username">
                                @error('username')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                       id="password">
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block" disabled id="signInButton">Sign
                                    In
                                </button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6 banner" style="">
            {{-- <img src="{{asset ('assets/banner.jpg')}}" alt=""> --}}
        </div>
    </div>
</div>
<!-- /.login-box -->

<!-- Bootstrap 4 -->
<script href="{{asset ('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script href="{{asset ('assets/dist/js/adminlte.min.js')}}"></script>

<script>
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{session('error')}}',
    })
    @endif

    $(document).ready(function () {
        let usernamePasswordCheck = () => {
            if ($('#username').val() != '' && $('#password').val() != '') {
                $('#signInButton').attr('disabled', false);
            } else {
                $('#signInButton').attr('disabled', true);
            }
        }

        $('#username').keyup(function () {
            usernamePasswordCheck();
        });
        $('#password').keyup(function () {
            usernamePasswordCheck();
        });
    });

</script>


</body>
</html>
