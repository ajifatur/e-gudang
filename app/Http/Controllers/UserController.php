<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use App\Grup;
use App\Kantor;
use App\Role;
use App\User;

class UserController extends Controller
{
    /**
     * Menampilkan data user
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get data user
        if(Auth::user()->role == role_admin_sistem())
            $user = User::join('role','users.role','=','role.id_role')->get();
        elseif(Auth::user()->role == role_admin_grup())
            $user = User::join('role','users.role','=','role.id_role')->where('id_grup','=',Auth::user()->id_grup)->get();
        else
            return view('error/403');

        // Custom data user
        if(count($user)>0){
            foreach($user as $key=>$data){
                $grup = Grup::find($data->id_grup);
                $kantor = Kantor::find($data->id_kantor);
                $user[$key]->nama_grup = $grup ? $grup->nama_grup : '-';
                $user[$key]->nama_kantor = $kantor ? $kantor->nama_kantor : '-';
            }
        }

        // View
        return view('admin/user/index', [
            'user' => $user,
        ]);
    }

    /**
     * Menambah data user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Data grup
        $grup = Grup::all();

        // View
        return view('admin/user/create', [
            'grup' => $grup
        ]);
    }

    /**
     * Menyimpan data user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'id_grup' => Auth::user()->role == role_admin_sistem() ? 'required' : '',
            'id_kantor' => 'required',
            'nama' => 'required|string|max:255',
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'nomor_hp' => 'required|numeric',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menyimpan data
            $user = new User;
            $user->id_grup = Auth::user()->role == role_admin_sistem() ? $request->id_grup : Auth::user()->id_grup;
            $user->id_kantor = $request->id_kantor;
            $user->nama_user = $request->nama;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt(default_password());
            $user->nomor_hp = $request->nomor_hp;
            $user->role = $request->id_kantor == 0 ? role_admin_grup() : role_admin_kantor();
            $user->register_at = date('Y-m-d H:i:s');
            $user->save();
        }

        // Redirect
        return redirect('/admin/user')->with(['message' => 'Berhasil menambah data.']);
    }
    
    /**
     * Menampilkan profil admin
     * 
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        // Get data admin
        $admin = User::join('role','users.role','=','role.id_role')->find(Auth::user()->id_user);

        if(!$admin){
            abort(404);
        }

        // View
        return view('admin/user/profile', [
            'admin' => $admin,
        ]);
    }

    /**
     * Mengedit data user
     * 
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get data user
        $user = User::join('role','users.role','=','role.id_role')->where('role','!=',role_admin_sistem())->find($id);

        // Jika tidak ada user
        if(!$user){
            abort(404);
        }

        // Data kantor
        $kantor = Kantor::where('id_grup','=',$user->id_grup)->get();

        // View
        return view('admin/user/edit', [
            'kantor' => $kantor,
            'user' => $user,
        ]);
    }

    /**
     * Mengupdate data user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'id_kantor' => Auth::user()->role == role_admin_sistem() ? 'required' : '',
            'nama' => 'required|string|max:255',
            'username' => ['required', Rule::unique('users')->ignore($request->id, 'id_user')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->id, 'id_user')],
            'nomor_hp' => 'required|numeric',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menyimpan data
            $user = User::find($request->id);
            $user->id_kantor = Auth::user()->role == role_admin_sistem() ? $request->id_kantor : $user->id_kantor;
            $user->nama_user = $request->nama;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->nomor_hp = $request->nomor_hp;
            $user->role = $request->id_kantor == 0 ? role_admin_grup() : role_admin_kantor();
            $user->save();
        }

        // Redirect
        return redirect('/admin/user')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Mengupdate data user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => ['required', 'alpha_dash', Rule::unique('users')->ignore($request->id, 'id_user')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->id, 'id_user')],
            'password' => $request->password != '' ? 'required|string|min:4' : '',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menyimpan data
            $user = User::find($request->id);
            $user->nama_user = $request->nama;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = $request->password != '' ? bcrypt($request->password) : $user->password;
            $user->save();
        }

        // Redirect
        return redirect('/admin/profil')->with(['message' => 'Berhasil mengupdate data.']);
    }
    
    /**
     * Menghapus user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Menghapus user
        $user = User::find($request->id);
        $user->delete();

        // Redirect
        return redirect('/admin/user')->with(['message' => 'Berhasil menghapus data.']);
    }
    
    /**
     * Export ke Excel
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
		ini_set("memory_limit", "-1");
		
        // Get data user
        $users = User::join('pekerjaan','users.pekerjaan','=','pekerjaan.id_pekerjaan')->where('role','=',role_member())->get();

        return Excel::download(new UserExport($users), 'Data User.xlsx');
    }
 
    /**
     * Import dari Excel
     *
     * @return \Illuminate\Http\Response
     */
	public function import(Request $request) 
	{        
        ini_set('max_execution_time', 600);

        // Mengkonversi data di Excel ke bentuk array
        $array = Excel::toArray(new UserImport, $request->file('file'));

        if(count($array)>0){
            foreach($array[0] as $data){
                // Mengecek data user berdasarkan id
                $user = User::where('role','=',role_member())->find($data[9]);

                // Jika data user tidak ditemukan
                if(!$user){
                    $check_user = User::where('role','=',role_member())->where('username','=',$data[2])->first();

                    if(!$check_user){
                        // Konversi format tanggal
                        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[5]);
                        $date = (array)$date;
                        
                        // Tambah data user
                        $user = new User;
                        $user->tanggal_lahir = date('Y-m-d', strtotime($date['date']));
                        $user->role = role_member();
                        $user->register_at = date('Y-m-d H:i:s');

                        // Menyimpan atau mengupdate user
                        $user->nama_user = $data[1];
                        $user->username = $data[2];
                        $user->email = $data[3] != null ? $data[3] : '';
                        $user->password = '';
                        $user->nomor_hp = $data[4];
                        $user->jenis_kelamin = $data[6];
                        $user->pekerjaan = get_pekerjaan($data[7]);
                        $user->pendaftaran = get_pendaftaran($data[8]);
                        $user->save();
                    }
                }
                else{
                    $user->tanggal_lahir = generate_date_format($data[5], 'y-m-d');

                    // Menyimpan atau mengupdate user
                    $user->nama_user = $data[1];
                    $user->username = $data[2];
                    $user->email = $data[3] != null ? $data[3] : '';
                    $user->password = '';
                    $user->nomor_hp = $data[4];
                    $user->jenis_kelamin = $data[6];
                    $user->pekerjaan = get_pekerjaan($data[7]);
                    $user->pendaftaran = get_pendaftaran($data[8]);
                    $user->save();
                }
                //
            }

            // Redirect
            return redirect('/admin/user')->with(['message' => 'Berhasil mengimport data.']);
        }
        else{
            // Redirect
            return redirect('/admin/user')->with(['message' => 'Data di Excel kosong.']);
        }
	}
}
