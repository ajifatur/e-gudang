@extends('template/admin/main')

@section('title', 'Edit User')

@section('content')

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-user"></i> Edit User</h1>
      <p>Menu untuk mengedit data user</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="/admin/user">User</a></li>
      <li class="breadcrumb-item">Edit User</li>
    </ul>
  </div>
  <div class="row">
    <div class="col-lg-6 mx-auto">
      <div class="tile">
        <form method="post" action="/admin/user/update">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $user->id_user }}">
            <div class="tile-title-w-btn">
                <h3 class="title">Edit User</h3>
                <p><button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-save mr-2"></i>Simpan</button></p>
            </div>
            <div class="tile-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Kantor <span class="text-danger">*</span></label>
                        <select name="id_kantor" class="form-control {{ $errors->has('id_kantor') ? 'is-invalid' : '' }}" id="kantor" {{ Auth::user()->role == role_admin_sistem() ? '' : 'disabled' }}>
                            <option value="" disabled>--Pilih--</option>
                            <option value="0" {{ $user->id_kantor == 0 ? 'selected' : '' }}>ADMIN GRUP</option>
                            @foreach($kantor as $data)
                              <option value="{{ $data->id_kantor }}" {{ $user->id_kantor == $data->id_kantor ? 'selected' : '' }}>{{ $data->nama_kantor }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('id_kantor'))
                        <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('id_kantor')) }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}" value="{{ $user->nama_user }}" placeholder="Masukkan Nama">
                        @if($errors->has('nama'))
                        <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('nama')) }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" value="{{ $user->username }}" placeholder="Masukkan Username">
                        @if($errors->has('username'))
                        <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('username')) }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ $user->email }}" placeholder="Masukkan Email">
                        @if($errors->has('email'))
                        <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('email')) }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label>Nomor HP <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_hp" class="form-control number-only {{ $errors->has('nomor_hp') ? 'is-invalid' : '' }}" value="{{ $user->nomor_hp }}" placeholder="Masukkan Nomor HP">
                        @if($errors->has('nomor_hp'))
                        <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('nomor_hp')) }}</div>
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
    // Change Grup
    $(document).on("change", "#grup", function(){
        var grup = $(this).val();
        $.ajax({
        type: 'get',
        url: '/admin/barang/json-kantor/'+grup,
        success: function(response){
            var result = JSON.parse(response);
            var html = '<option value="" disabled>--Pilih--</option>';
            html += '<option value="0" selected>ADMIN GRUP</option>';
            $(result).each(function(key,value){
            html += '<option value="'+value.id_kantor+'">'+value.nama_kantor+'</option>';
            });
            $("#kantor").html(html).removeAttr("disabled");
        }
        })
    });

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
</script>

@endsection