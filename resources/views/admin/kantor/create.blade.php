@extends('template/admin/main')

@section('title', 'Tambah Kantor')

@section('content')

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-home"></i> Tambah Kantor</h1>
      <p>Menu untuk menambah data kantor</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="/admin/kantor">Kantor</a></li>
      <li class="breadcrumb-item">Tambah Kantor</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-lg-6 mx-auto">
      <div class="tile">
        <form method="post" action="/admin/kantor/store">
            {{ csrf_field() }}
            <div class="tile-title-w-btn">
                <h3 class="title">Tambah Kantor</h3>
                <p><button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-save mr-2"></i>Simpan</button></p>
            </div>
            <div class="tile-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Nama Kantor <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kantor" class="form-control {{ $errors->has('nama_kantor') ? 'is-invalid' : '' }}" value="{{ old('nama_kantor') }}" placeholder="Masukkan Nama kantor">
                        @if($errors->has('nama_kantor'))
                        <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('nama_kantor')) }}</div>
                        @endif
                    </div>
					@if(Auth::user()->role == role_admin_sistem())
                    <div class="form-group col-md-12">
                        <label>Grup <span class="text-danger">*</span></label>
                        <select name="id_grup" class="form-control {{ $errors->has('id_grup') ? 'is-invalid' : '' }}">
                            <option value="" disabled selected>--Pilih--</option>
                            @foreach($grup as $data)
                            <option value="{{ $data->id_grup }}" {{ old('id_grup') == $data->id_grup ? 'selected' : '' }}>{{ $data->nama_grup }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('id_grup'))
                        <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('id_grup')) }}</div>
                        @endif
                    </div>
					@endif
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