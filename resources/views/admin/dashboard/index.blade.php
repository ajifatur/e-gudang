@extends('template/admin/main')

@section('title', 'Dashboard')

@section('content')

<main class="app-content">
	<div class="app-title">
		<div>
			<h1><i class="fa fa-dashboard"></i> Dashboard</h1>
			<p>Menu untuk menampilkan data dan statistik penting</p>
		</div>
		<ul class="app-breadcrumb breadcrumb">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
		</ul>
	</div>
	<div class="row">
		<div class="col-12 text-center">
			<div class="alert alert-success">
				Selamat datang <strong>{{ Auth::user()->nama_user }}</strong> di aplikasi <strong>{{ get_website_name() }}</strong>.
			</div>
		</div>
	</div>
  <!-- <div class="row">
    <div class="col-md-6 col-lg-6">
      <div class="widget-small info coloured-icon"><i class="icon fa fa-arrow-down fa-3x"></i>
        <div class="info">
          <h4>Top Up</h4>
          <p><b>Rp {{ number_format(0,0,'.','.') }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-6">
      <div class="widget-small danger coloured-icon"><i class="icon fa fa-arrow-up fa-3x"></i>
        <div class="info">
          <h4>TRX</h4>
          <p><b>Rp {{ number_format(0,0,'.','.') }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-6">
      <div class="widget-small warning coloured-icon"><i class="icon fa fa-money fa-3x"></i>
        <div class="info">
          <h4>Saldo</h4>
          <p><b>Rp {{ number_format(0,0,'.','.') }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-6">
      <div class="widget-small primary coloured-icon"><i class="icon fa fa-user fa-3x"></i>
        <div class="info">
          <h4>Member</h4>
          <p><b>{{ number_format(0,0,'.','.') }}</b></p>
        </div>
      </div>
    </div>
  </div> -->
</main>

@endsection

@section('js-extra')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>

@endsection

@section('css-extra')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />

@endsection