@extends('template/admin/main')

@section('title', 'Kelola Barang')

@section('content')

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-list"></i> Kelola Barang</h1>
      <p>Menu untuk mengelola data barang</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="/admin/barang">Barang</a></li>
      <li class="breadcrumb-item">Kelola Barang</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-title-w-btn">
          <h3 class="title">Kelola Barang</h3>
          <div class="btn-group">
            <a class="btn btn-primary" href="/admin/barang/create" title="Tambah Barang"><i class="fa fa-lg fa-plus"></i></a>
            <!-- <a class="btn btn-primary" href="/admin/barang/export" title="Export Data Barang"><i class="fa fa-lg fa-file-excel-o"></i></a> -->
          </div>
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
                        <th>Nama Barang</th>
                        <th width="100">Harga Jual (Rp.)</th>
                        <th width="100">HPP (Rp.)</th>
                        <th width="100">Stok Awal</th>
                        <th width="40">Edit</th>
                        <th width="40">Hapus</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($barang as $data)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $data->nama_barang }}</td>
                                <td>{{ number_format($data->harga_jual,0,'.','.') }}</td>
                                <td>{{ number_format($data->hpp,0,'.','.') }}</td>
                                <td>{{ number_format($data->stok_awal,0,'.','.') }}</td>
                                <td><a href="/admin/barang/edit/{{ $data->id_barang }}" class="btn btn-warning btn-sm btn-block" data-id="{{ $data->id_barang }}" title="Edit"><i class="fa fa-edit"></i></a></td>
                                <td><a href="#" class="btn btn-danger btn-sm btn-block btn-delete" data-id="{{ $data->id_barang }}" title="Hapus"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <form id="form-delete" class="d-none" method="post" action="/admin/barang/delete">
                {{ csrf_field() }}
                <input type="hidden" name="id">
            </form>
        </div>
      </div>
    </div>
  </div>
</main>

@endsection

@section('js-extra')

<script type="text/javascript" src="{{ asset('templates/vali-admin/js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('templates/vali-admin/js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
    // DataTable
    $('#table').DataTable();

    // Button Delete
    $(document).on("click", ".btn-delete", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var ask = confirm("Anda yakin ingin menghapus data ini?");
        if(ask){
            $("#form-delete input[name=id]").val(id);
            $("#form-delete").submit();
        }
    });
</script>

@endsection