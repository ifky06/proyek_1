@extends('layouts.template')

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


          <div class="card col-lg-5 col-6">
            <h5>Top 5 Barang Cepat Habis</h5>
                Urutan Barang Cepat Habis
            <ul class="products-list product-list-in-card pl-2 pr-2">
                  <li class="item">
                    <div class="product-img">
                      {{-- <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50"> --}}
                    </div>
                    <div class="product-info">
                     Nama Barang
                        <span class="float-right">Total</span>
                      {{-- <span class="product-description">
                        Samsung 32" 1080p 60Hz LED Smart HDTV.
                      </span> --}}
                    </div>
                  </li>

              
              <!-- /.item -->
              <li class="item">
                <div class="product-img">
                  {{-- <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50"> --}}
                </div>
                <div class="product-info">
                  <a href="javascript:void(0)" class="product-title">Bibit Jagung
                    <span class="badge badge-info float-right">30</span></a>
                  {{-- <span class="product-description">
                    26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                  </span> --}}
                </div>
              </li>
              <!-- /.item -->
              <li class="item">
                <div class="product-img">
                  {{-- <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50"> --}}
                </div>
                <div class="product-info">
                  <a href="javascript:void(0)" class="product-title">
                    Bibit <span class="badge badge-danger float-right">
                    10
                  </span>
                  </a>
                  {{-- <span class="product-description">
                    Xbox One Console Bundle with Halo Master Chief Collection.
                  </span> --}}
                </div>
              </li>
            </ul>
          </div> 


          <div class="card col-lg-6 col-6">
            <h5>Top 5 Barang Cepat Habis</h5>
                Urutan Barang Cepat Habis
            <ul class="products-list product-list-in-card pl-2 pr-2">
                  <li class="item">
                    <div class="product-img">
                      {{-- <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50"> --}}
                    </div>
                    <div class="product-info">
                     Nama Barang
                        <span class="float-right">Total</span>
                      {{-- <span class="product-description">
                        Samsung 32" 1080p 60Hz LED Smart HDTV.
                      </span> --}}
                    </div>
                  </li>
                  
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
