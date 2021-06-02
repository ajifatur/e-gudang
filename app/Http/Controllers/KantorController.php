<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Grup;
use App\Kantor;
use App\User;

class KantorController extends Controller
{
    /**
     * Menampilkan data kantor
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == role_admin_sistem()){
            // Get data kantor
            $kantor = Kantor::join('grup','kantor.id_grup','=','grup.id_grup')->get();

            // View
            return view('admin/kantor/index', [
                'kantor' => $kantor,
            ]);
        }
		elseif(Auth::user()->role == role_admin_grup()){
            // Get data kantor
            $kantor = Kantor::join('grup','kantor.id_grup','=','grup.id_grup')->where('grup.id_grup','=',Auth::user()->id_grup)->get();

            // View
            return view('admin/kantor/index', [
                'kantor' => $kantor,
            ]);
		}
        else{
            // Redirect
            return view('error/403');
        }
    }

    /**
     * Menambah data kantor
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == role_admin_sistem() || Auth::user()->role == role_admin_grup()){
            // Data grup
            $grup = Grup::all();

            // View
            return view('admin/kantor/create', [
                'grup' => $grup
            ]);
        }
        else{
            // Redirect
            return view('error/403');
        }
    }

    /**
     * Menyimpan data kantor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'id_grup' => Auth::user()->role == role_admin_sistem() ? 'required' : '',
            'nama_kantor' => 'required|string|max:255',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menyimpan data
            $kantor = new Kantor;
            $kantor->id_grup = Auth::user()->role == role_admin_sistem() ? $request->id_grup : Auth::user()->id_grup;
            $kantor->nama_kantor = $request->nama_kantor;
            $kantor->kantor_at = date('Y-m-d H:i:s');
            $kantor->save();
        }

        // Redirect
        return redirect('/admin/kantor')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Mengedit data kantor
     * 
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == role_admin_sistem()){
            // Get data kantor
            $kantor = Kantor::join('grup','kantor.id_grup','=','grup.id_grup')->find($id);

            // Jika tidak ada kantor
            if(!$kantor){
                abort(404);
            }

            // Data grup
            $grup = Grup::all();

            // View
            return view('admin/kantor/edit', [
                'grup' => $grup,
                'kantor' => $kantor,
            ]);
        }
		elseif(Auth::user()->role == role_admin_grup()){
            // Get data kantor
            $kantor = Kantor::join('grup','kantor.id_grup','=','grup.id_grup')->where('grup.id_grup','=',Auth::user()->id_grup)->find($id);

            // Jika tidak ada kantor
            if(!$kantor){
                abort(404);
            }

            // Data grup
            $grup = Grup::all();

            // View
            return view('admin/kantor/edit', [
                'grup' => $grup,
                'kantor' => $kantor,
            ]);
		}
        else{
            // Redirect
            return view('error/403');
        }
    }

    /**
     * Mengupdate data kantor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'id_grup' => Auth::user()->role == role_admin_sistem() ? 'required' : '',
            'nama_kantor' => 'required|string|max:255',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menyimpan data
            $kantor = Kantor::find($request->id);
            $kantor->id_grup = Auth::user()->role == role_admin_sistem() ? $request->id_grup : Auth::user()->id_grup;
            $kantor->nama_kantor = $request->nama_kantor;
            $kantor->save();
        }

        // Redirect
        return redirect('/admin/kantor')->with(['message' => 'Berhasil mengupdate data.']);
    }
    
    /**
     * Menghapus kantor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Menghapus kantor
        $kantor = Kantor::find($request->id);
        $kantor->delete();

        // Redirect
        return redirect('/admin/kantor')->with(['message' => 'Berhasil menghapus data.']);
    }
    
    /**
     * Export ke Excel
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        if(Auth::user()->role == role_admin_sistem() || Auth::user()->role == role_admin_grup()){
            ini_set("memory_limit", "-1");
            
            // Get data kantor
            $kantor = Kantor::all();

            // return Excel::download(new UserExport($users), 'Data User.xlsx');
        }
        else{
            // Redirect
            return view('error/403');
        }
    }
}
