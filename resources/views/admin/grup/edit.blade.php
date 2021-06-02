@extends('template/admin/main')

@section('title', 'Edit Grup')

@section('content')

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dot-circle-o"></i> Edit Grup</h1>
      <p>Menu untuk mengedit data grup</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="/admin/grup">Grup</a></li>
      <li class="breadcrumb-item">Edit Grup</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-lg-6 mx-auto">
      <div class="tile">
        <form method="post" action="/admin/grup/update">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $grup->id_grup }}">
            <div class="tile-title-w-btn">
                <h3 class="title">Edit Grup</h3>
                <p><button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-save mr-2"></i>Simpan</button></p>
            </div>
            <div class="tile-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Nama Grup <span class="text-danger">*</span></label>
                        <input type="text" name="nama_grup" class="form-control {{ $errors->has('nama_grup') ? 'is-invalid' : '' }}" value="{{ $grup->nama_grup }}" placeholder="Masukkan Nama Grup">
                        @if($errors->has('nama_grup'))
                        <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('nama_grup')) }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tile-footer"><button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-save mr-2"></i>Simpan</button></div>
        </form>
      </div>
    </div>
  </div>
</main>

@endsection

@section('js-extra')

<script type="text/javascript">
</script>

@endsection