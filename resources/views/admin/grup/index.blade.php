@extends('template/admin/main')

@section('title', 'Kelola Grup')

@section('content')

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dot-circle-o"></i> Kelola Grup</h1>
      <p>Menu untuk mengelola data grup</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="/admin/grup">Grup</a></li>
      <li class="breadcrumb-item">Kelola Grup</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-title-w-btn">
          <h3 class="title">Kelola Grup</h3>
		  @if(Auth::user()->role == role_admin_sistem())
          <div class="btn-group">
            <a class="btn btn-primary" href="/admin/grup/create" title="Tambah Grup"><i class="fa fa-lg fa-plus"></i></a>
            <!-- <a class="btn btn-primary" href="/admin/grup/export" title="Export Data Grup"><i class="fa fa-lg fa-file-excel-o"></i></a> -->
          </div>
		  @endif
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
                        <th>Nama Grup</th>
                        <th width="80">Kantor</th>
                        <th width="150">Waktu</th>
                        <th width="40">Edit</th>
                        <th width="40">Hapus</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($grup as $data)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $data->nama_grup }}</td>
                                <td>{{ number_format($data->kantor,0,'.','.') }}</td>
                                <td>{{ date('Y-m-d H:i:s', strtotime($data->grup_at)) }}</td>
                                <td><a href="/admin/grup/edit/{{ $data->id_grup }}" class="btn btn-warning btn-sm btn-block" data-id="{{ $data->id_grup }}" title="Edit"><i class="fa fa-edit"></i></a></td>
                                <td><a href="#" class="btn btn-danger btn-sm btn-block {{ Auth::user()->role == role_admin_sistem() ? 'btn-delete' : '' }}" data-id="{{ $data->id_grup }}" style="{{ Auth::user()->role == role_admin_sistem() ? '' : 'cursor: not-allowed' }}" title="Hapus"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <form id="form-delete" class="d-none" method="post" action="/admin/grup/delete">
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