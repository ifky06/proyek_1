@extends('layouts.template')

@section('title', 'Dashboard')

@section('content')

        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Dashboard Kios Sahabat Tani</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  <li class="breadcrumb-item active">Dashboard</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="nav-icon fas fa-tachometer-alt"></i> Dashboard</h3>
            </div>
            <div class="card-body">

              <div class="row">
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">
                      <h3><i class="nav-icon fas fa-book"></i></h3>

                      <p>{{$barangHabis}} Barang Habis</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    <a href="barang" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-success">
                    <div class="inner">
                      <h3><i class="nav-icon fas fa-book"></i></h3>

                      <p>{{$barangSegeraHabis}} Barang Segera Habis</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="barang" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                    <div class="inner">
                      <h3><i class="nav-icon fas fa-book"></i></h3>

                      <p>{{$barangTersedia}} Barang Tersedia</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-person-add"></i>
                    </div>
                    <a href="barang" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-danger">
                    <div class="inner">
                      <h3><i class="nav-icon fas fa-exchange-alt"></i><h3>

                      <p>{{$totalTransaksi}} Total Transaksi</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
              </div>
            </div>
          </div>
            <div class="d-flex justify-content-between">
                <div class="card w-100 mr-1">
                    <div class="card-header">
                        <h5>Top 5 Barang Cepat Habis</h5>
                    </div>
                    <div class="card-body">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach ($barangCepatHabis as $item)
                                <li class="item">
                                    <div class="product-info">
                                        <p class="product-title">{{$item->barang->nama}}
                                            <span class="badge badge-info float-right">{{$item->total}}</span></p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card w-100 ml-1">
                    <div class="card-header">
                        <h5>Top 5 Barang Baru Masuk</h5>
                    </div>
                    <div class="card-body">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach ($barangBaruMasuk as $item)
                                <li class="item">
                                    <div class="product-info">
                                        <p class="product-title pb-0 mb-0">{{$item->barang->nama}}</p>
                                        <span class="m-0 p-0">{{$item->tanggal}}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
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
