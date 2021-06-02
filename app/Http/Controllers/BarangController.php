<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Barang;
use App\Grup;
use App\Kantor;
use App\Stok;
use App\User;

class BarangController extends Controller
{
    /**
     * Menampilkan data barang
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == role_admin_sistem()){
            // Get data barang
            $barang = Barang::all();
        }
        elseif(Auth::user()->role == role_admin_grup()){
            // Get data barang
            $barang = Barang::join('kantor','barang.id_kantor','=','kantor.id_kantor')->join('grup','kantor.id_grup','=','grup.id_grup')->where('grup.id_grup','=',Auth::user()->id_grup)->get();
        }
        elseif(Auth::user()->role == role_admin_kantor()){
            // Get data barang
            $barang = Barang::join('kantor','barang.id_kantor','=','kantor.id_kantor')->join('grup','kantor.id_grup','=','grup.id_grup')->where('kantor.id_kantor','=',Auth::user()->id_kantor)->get();
        }

        // View
        return view('admin/barang/index', [
            'barang' => $barang,
        ]);
    }

    /**
     * Menambah data barang
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Data grup
        $grup = Grup::all();

        // View
        return view('admin/barang/create', [
            'grup' => $grup
        ]);
    }

    /**
     * Menyimpan data barang
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'id_grup' => Auth::user()->role == role_admin_sistem() ? 'required' : '',
            'id_kantor' => Auth::user()->role == role_admin_kantor() ? '' : 'required',
            'nama_barang' => 'required|string|max:255',
            'harga_jual' => 'required|numeric',
            'hpp' => 'required|numeric',
            'stok_awal' => 'required|numeric',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menyimpan data
            $barang = new Barang;
            $barang->id_kantor = Auth::user()->role == role_admin_kantor() ? Auth::user()->id_kantor : $request->id_kantor;
            $barang->nama_barang = $request->nama_barang;
            $barang->harga_jual = str_replace('.', '', $request->harga_jual);
            $barang->hpp = str_replace('.', '', $request->hpp);
            $barang->stok_awal = str_replace('.', '', $request->stok_awal);
            $barang->barang_at = date('Y-m-d H:i:s');
            $barang->save();

            // Mengambil data barang yang baru saja disimpan
            $new_barang = Barang::where('barang_at','=',$barang->barang_at)->first();

            // Menyimpan data stok
            $stok = new Stok;
            $stok->id_barang = $new_barang->id_barang;
            $stok->stok_awal = $new_barang->stok_awal;
            $stok->pembelian = 0;
            $stok->terjual = 0;
            $stok->sisa = $new_barang->stok_awal;
            $stok->selisih = 0;
            $stok->stok_akhir = $new_barang->stok_awal;
            $stok->bulan = date('n', strtotime($new_barang->barang_at));
            $stok->tahun = date('Y', strtotime($new_barang->barang_at));
            $stok->stok_at = date('Y-m-d H:i:s');
            $stok->save();
        }

        // Redirect
        return redirect('/admin/barang')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Mengedit data barang
     * 
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get data barang
        $barang = Barang::join('kantor','barang.id_kantor','=','kantor.id_kantor')->join('grup','kantor.id_grup','=','grup.id_grup')->find($id);

        // Jika tidak ada barang
        if(!$barang){
            abort(404);
        }

        // View
        return view('admin/barang/edit', [
            'barang' => $barang,
        ]);
    }

    /**
     * Mengupdate data barang
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'harga_jual' => 'required|numeric',
            'hpp' => 'required|numeric',
            'stok_awal' => 'required|numeric',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menyimpan data
            $barang = Barang::find($request->id);
            $barang->nama_barang = $request->nama_barang;
            $barang->harga_jual = str_replace('.', '', $request->harga_jual);
            $barang->hpp = str_replace('.', '', $request->hpp);
            $barang->stok_awal = str_replace('.', '', $request->stok_awal);
            $barang->save();
        }

        // Redirect
        return redirect('/admin/barang')->with(['message' => 'Berhasil mengupdate data.']);
    }
    
    /**
     * Menghapus barang
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Menghapus barang
        $barang = Barang::find($request->id);
        $barang->delete();

        // Redirect
        return redirect('/admin/barang')->with(['message' => 'Berhasil menghapus data.']);
    }
    
    /**
     * Export ke Excel
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
		ini_set("memory_limit", "-1");
		
        // Get data barang
        $barang = Barang::all();

        // return Excel::download(new UserExport($users), 'Data User.xlsx');
    }
    
    /**
     * JSON data kantor
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function json_kantor($id)
    {		
        // Get data kantor berdasarkan id_grup
        $kantor = Kantor::where('id_grup','=',$id)->get();
        echo json_encode($kantor);
    }
}
