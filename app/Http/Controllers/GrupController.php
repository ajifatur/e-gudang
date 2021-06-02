<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Grup;
use App\Kantor;
use App\User;

class GrupController extends Controller
{
    /**
     * Menampilkan data grup
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == role_admin_sistem()){
            // Get data grup
            $grup = Grup::all();
			
			if(count($grup)>0){
				foreach($grup as $key=>$data){
					$grup[$key]->kantor = Kantor::where('id_grup','=',$data->id_grup)->count();
				}
			}

            // View
            return view('admin/grup/index', [
                'grup' => $grup,
            ]);
        }
		elseif(Auth::user()->role == role_admin_grup()){
            // Get data grup
            $grup = Grup::where('id_grup','=',Auth::user()->id_grup)->get();
			
			if(count($grup)>0){
				foreach($grup as $key=>$data){
					$grup[$key]->kantor = Kantor::where('id_grup','=',$data->id_grup)->count();
				}
			}

            // View
            return view('admin/grup/index', [
                'grup' => $grup,
            ]);
		}
        else{
            // Redirect
            return view('error/403');
        }
    }

    /**
     * Menambah data grup
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == role_admin_sistem()){
            // View
            return view('admin/grup/create');
        }
        else{
            // Redirect
            return view('error/403');
        }
    }

    /**
     * Menyimpan data grup
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_grup' => 'required|string|max:255',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menyimpan data
            $grup = new Grup;
            $grup->nama_grup = $request->nama_grup;
            $grup->grup_at = date('Y-m-d H:i:s');
            $grup->save();
			
			// Get data grup
			$new_grup = Grup::where('grup_at','=',$grup->grup_at)->latest('grup_at')->first();
			
			// Menambah data kantor "Head Office"
			$kantor = new Kantor;
			$kantor->id_grup = $new_grup->id_grup;
			$kantor->nama_kantor = "Head Office";
			$kantor->kantor_at = date('Y-m-d H:i:s');
            $kantor->save();
        }

        // Redirect
        return redirect('/admin/grup')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Mengedit data grup
     * 
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == role_admin_sistem()){
            // Get data grup
            $grup = Grup::find($id);

            // Jika tidak ada grup
            if(!$grup){
                abort(404);
            }

            // View
            return view('admin/grup/edit', [
                'grup' => $grup,
            ]);
        }
		elseif(Auth::user()->role == role_admin_grup()){
            // Get data grup
            $grup = Grup::where('id_grup','=',Auth::user()->id_grup)->find($id);

            // Jika tidak ada grup
            if(!$grup){
                abort(404);
            }

            // View
            return view('admin/grup/edit', [
                'grup' => $grup,
            ]);
		}
        else{
            // Redirect
            return view('error/403');
        }
    }

    /**
     * Mengupdate data grup
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_grup' => 'required|string|max:255',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menyimpan data
            $grup = Grup::find($request->id);
            $grup->nama_grup = $request->nama_grup;
            $grup->save();
        }

        // Redirect
        return redirect('/admin/grup')->with(['message' => 'Berhasil mengupdate data.']);
    }
    
    /**
     * Menghapus grup
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Menghapus grup
        $grup = Grup::find($request->id);
        $grup->delete();

        // Redirect
        return redirect('/admin/grup')->with(['message' => 'Berhasil menghapus data.']);
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
            
            // Get data grup
            $grup = Grup::all();

            // return Excel::download(new UserExport($users), 'Data User.xlsx');
        }
        else{
            // Redirect
            return view('error/403');
        }
    }
}
