@extends('template/admin/main')

@section('title', 'Edit Barang')

@section('content')

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-list"></i> Edit Barang</h1>
      <p>Menu untuk mengedit data barang</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="/admin/barang">Barang</a></li>
      <li class="breadcrumb-item">Edit Barang</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-lg-6 mx-auto">
      <div class="tile">
        <form method="post" action="/admin/barang/update">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $barang->id_barang }}">
            <div class="tile-title-w-btn">
                <h3 class="title">Edit Barang</h3>
                <p><button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-save mr-2"></i>Simpan</button></p>
            </div>
            <div class="tile-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_barang" class="form-control {{ $errors->has('nama_barang') ? 'is-invalid' : '' }}" value="{{ $barang->nama_barang }}" placeholder="Masukkan Nama Barang">
                        @if($errors->has('nama_barang'))
                        <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('nama_barang')) }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label>Harga Jual <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text {{ $errors->has('harga_jual') ? 'border-danger' : '' }}">Rp.</span></div>
                            <input type="text" name="harga_jual" class="form-control number-only thousand-format {{ $errors->has('harga_jual') ? 'is-invalid' : '' }}" value="{{ number_format($barang->harga_jual,0,'.','.') }}" placeholder="Masukkan Harga Jual">
                        </div>
                        @if($errors->has('harga_jual'))
                        <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('harga_jual')) }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label>HPP <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text {{ $errors->has('hpp') ? 'border-danger' : '' }}">Rp.</span></div>
                            <input type="text" name="hpp" class="form-control number-only thousand-format {{ $errors->has('hpp') ? 'is-invalid' : '' }}" value="{{ number_format($barang->hpp,0,'.','.') }}" placeholder="Masukkan Harga Jual">
                        </div>
                        @if($errors->has('hpp'))
                        <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('hpp')) }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label>Stok Awal <span class="text-danger">*</span></label>
                        <input type="text" name="stok_awal" class="form-control number-only thousand-format {{ $errors->has('stok_awal') ? 'is-invalid' : '' }}" value="{{ number_format($barang->stok_awal,0,'.','.') }}" placeholder="Masukkan Stok Awal">
                        @if($errors->has('stok_awal'))
                        <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('stok_awal')) }}</div>
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
    // Input Hanya Nomor
    $(document).on("keypress", ".number-only", function(e){
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode >= 48 && charCode <= 57) { 
            // 0-9 only
            return true;
        }
        else{
            return false;
        }
    });

    // Input Format Ribuan
    $(document).on("keyup", ".thousand-format", function(){
        var value = $(this).val();
        $(this).val(formatRibuan(value, ""));
    });

    // Function Format Ribuan
    function formatRibuan(angka, prefix){
        var number_string = angka.replace(/\D/g,'');
        number_string = (number_string.length > 1) ? number_string.replace(/^(0+)/g, '') : number_string;
        var split = number_string.split(',');
        var sisa = split[0].length % 3;
        var rupiah = split[0].substr(0, sisa);
        var ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
    
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }
</script>

@endsection