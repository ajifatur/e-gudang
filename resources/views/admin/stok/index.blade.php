@extends('template/admin/main')

@section('title', 'Kelola Stok')

@section('content')

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-retweet"></i> Kelola Stok</h1>
      <p>Menu untuk mengelola data stok</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="/admin/stok">Stok</a></li>
      <li class="breadcrumb-item">Kelola Stok</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-lg-auto mx-auto">
        <div class="tile">
            <div class="tile-body">
                <form id="form-filter" class="form-inline" method="get" action="">
                    @if(Auth::user()->role == role_admin_grup())
					<select name="kantor" class="form-control mr-2">
                        @foreach($kantor as $data)
					    <option value="{{ $data->id_kantor }}" {{ $_GET['kantor'] == $data->id_kantor ? 'selected' : '' }}>{{ $data->nama_kantor }}</option>
                        @endforeach
					</select>
                    @endif
					<select name="bulan" class="form-control mr-2">
                        @foreach(array_indo_month() as $key=>$data)
                        <option value="{{ $key+1 }}" {{ $_GET['bulan'] == ($key+1) ? 'selected' : '' }}>{{ $data }}</option>
                        @endforeach
                    </select>
					<select name="tahun" class="form-control mr-2">
                        @for($y=date('Y'); $y>=2020; $y--)
                        <option value="{{ $y }}" {{ $_GET['tahun'] == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="btn btn-primary btn-submit-filter">Submit</button>
                </form>
                <!-- <div class="form-inline mt-2 mx-auto">
                    <a href="#" class="btn btn-primary mr-2"><i class="fa fa-arrow-left mr-2"></i>Sebelumnya</a>
                    <a href="#" class="btn btn-primary">Selanjutnya<i class="fa fa-arrow-right ml-2"></i></a>
                </div> -->
            </div>
        </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-title-w-btn">
          <h3 class="title">Kelola Stok</h3>
          <!-- <div class="btn-group">
            <a class="btn btn-primary" href="/admin/stok/export" title="Export Data Stok"><i class="fa fa-lg fa-file-excel-o"></i></a>
          </div> -->
        </div>
        <div class="tile-body">
            @if(Session::get('message') != null)
            <div class="alert alert-dismissible alert-success">
                <button class="close" type="button" data-dismiss="alert">×</button>{{ Session::get('message') }}
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="table">
                    <thead>
                        <tr>
                            <th width="30">No.</th>
                            <th>Barang</th>
                            <th width="100">Stok Awal</th>
                            <th width="100">Pembelian</th>
                            <th width="100">Terjual</th>
                            <th width="100">Sisa</th>
                            <th width="100">Selisih</th>
                            <th width="100">Stok Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($barang)>0)
                            @php $i = 1; @endphp
                            @foreach($barang as $data)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $data->nama_barang }}</td>
                                <td><input type="text" data-id="{{ $i }}" data-barang="{{ $data->id_barang }}" data-bulan="{{ $_GET['bulan'] }}" data-tahun="{{ $_GET['tahun'] }}" class="form-control form-control-sm number-only thousand-format stok-awal" value="{{ number_format(get_data_stok($data->id_barang, $_GET['bulan'], $_GET['tahun'], 1),0,'.','.') }}" readonly></td>
                                <td><input type="text" data-id="{{ $i }}" data-barang="{{ $data->id_barang }}" data-bulan="{{ $_GET['bulan'] }}" data-tahun="{{ $_GET['tahun'] }}" class="form-control form-control-sm number-only thousand-format pembelian" value="{{ number_format(get_data_stok($data->id_barang, $_GET['bulan'], $_GET['tahun'], 2),0,'.','.') }}" {{ $tanggal_awal <= date('Y-m-').array_month_days(date('Y'))[date('n')-1]  ? '' : 'readonly' }}></td>
                                <td><input type="text" data-id="{{ $i }}" data-barang="{{ $data->id_barang }}" data-bulan="{{ $_GET['bulan'] }}" data-tahun="{{ $_GET['tahun'] }}" class="form-control form-control-sm number-only thousand-format terjual" value="{{ number_format(get_data_stok($data->id_barang, $_GET['bulan'], $_GET['tahun'], 3),0,'.','.') }}" {{ $tanggal_awal <= date('Y-m-').array_month_days(date('Y'))[date('n')-1]  ? '' : 'readonly' }}></td>
                                <td><input type="text" data-id="{{ $i }}" data-barang="{{ $data->id_barang }}" data-bulan="{{ $_GET['bulan'] }}" data-tahun="{{ $_GET['tahun'] }}" class="form-control form-control-sm number-only thousand-format sisa" value="{{ number_format(get_data_stok($data->id_barang, $_GET['bulan'], $_GET['tahun'], 4),0,'.','.') }}" readonly></td>
                                <td><input type="text" data-id="{{ $i }}" data-barang="{{ $data->id_barang }}" data-bulan="{{ $_GET['bulan'] }}" data-tahun="{{ $_GET['tahun'] }}" class="form-control form-control-sm number-only thousand-format selisih" value="{{ number_format(get_data_stok($data->id_barang, $_GET['bulan'], $_GET['tahun'], 5),0,'.','.') }}" {{ $tanggal_awal <= date('Y-m-').array_month_days(date('Y'))[date('n')-1]  ? '' : 'readonly' }}></td>
                                <td><input type="text" data-id="{{ $i }}" data-barang="{{ $data->id_barang }}" data-bulan="{{ $_GET['bulan'] }}" data-tahun="{{ $_GET['tahun'] }}" class="form-control form-control-sm number-only thousand-format stok-akhir" value="{{ number_format(get_data_stok($data->id_barang, $_GET['bulan'], $_GET['tahun'], 6),0,'.','.') }}" readonly></td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                        @else
                        <tr>
                            <td colspan="8" align="center"><strong class="text-danger">Tidak ada barang tersedia.</strong></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</main>

<div class="notification">
    <div class="alert alert-dismissible alert-danger">
        <button class="close" type="button" data-dismiss="alert">×</button>Berhasil mengupdate stok!
    </div>
</div>

@endsection

@section('js-extra')

<script type="text/javascript">
    // Change stok
    $(document).on("change", ".pembelian, .terjual, .selisih", function(){
        var id = $(this).data("id");
        updateStok(id);
    });

    function updateStok(id){
        // Deklarasi
        var barang = $(".stok-awal[data-id="+id+"]").data("barang");
        var bulan = $(".stok-awal[data-id="+id+"]").data("bulan");
        var tahun = $(".stok-awal[data-id="+id+"]").data("tahun");

        // Kalkulasi
        var stok_awal = formatClean($(".stok-awal[data-id="+id+"]").val());
        var pembelian = formatClean($(".pembelian[data-id="+id+"]").val());
        var terjual = formatClean($(".terjual[data-id="+id+"]").val());
        var sisa = Number(stok_awal) + Number(pembelian) - Number(terjual);
        var selisih = formatClean($(".selisih[data-id="+id+"]").val());
        var stok_akhir = Number(sisa) + Number(selisih);

        // Masukkan hasil kalkulasi ke array
        var array = [stok_awal, pembelian, terjual, sisa, selisih, stok_akhir];

        // Tampilkan sisa dan stok akhir
        sisa.toString().search("-") >= 0 ? $(".sisa[data-id="+id+"]").val("-" + formatRibuan(sisa.toString(), "")) : $(".sisa[data-id="+id+"]").val(formatRibuan(sisa.toString(), ""));
        stok_akhir.toString().search("-") >= 0 ? $(".stok-akhir[data-id="+id+"]").val("-" + formatRibuan(stok_akhir.toString(), "")) : $(".stok-akhir[data-id="+id+"]").val(formatRibuan(stok_akhir.toString(), ""));

        // Update via AJAX
        $.ajax({
            type: "post",
            url: "/admin/stok/update",
            data: {_token: "{{ csrf_token() }}", barang: barang, bulan: bulan, tahun: tahun, array: array},
            success: function(response){
                $(".notification").fadeIn(1000).delay(3000).fadeOut(1000);
            }
        });
    }

    // Input Hanya Nomor
    $(document).on("keypress", ".number-only", function(e){
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode >= 48 && charCode <= 57) {
            // 0-9 only
            return true;
        }
        else{
            if($(this).hasClass("selisih") && charCode == 45)
                return true;
            else
                return false;
        }
    });

    // Input Format Ribuan
    $(document).on("keyup", ".thousand-format", function(){
        var value = $(this).val();
        value.search("-") >= 0 ? $(this).val("-" + formatRibuan(value, "")) : $(this).val(formatRibuan(value, ""));
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

    // Function Format Clean
    function formatClean(angka){
        return angka.replace(".", "");
    }
</script>

@endsection

@section('css-extra')

<style type="text/css">
    .notification {position: fixed; width: 300px; z-index: 1050; top: 60px; right: 15px; display: none;}
</style>

@endsection