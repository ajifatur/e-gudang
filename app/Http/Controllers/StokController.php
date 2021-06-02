<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Barang;
use App\Grup;
use App\Kantor;
use App\Role;
use App\Stok;
use App\User;

class StokController extends Controller
{
    /**
     * Menampilkan data stok
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Jika role admin grup
        if(Auth::user()->role == role_admin_grup()){
            // Redirect
            if($request->query('kantor') == null || $request->query('bulan') == null || $request->query('tahun') == null){
                // Get Head Office
                $head_office = Kantor::where('id_grup','=',Auth::user()->id_grup)->first();

                // Redirect
                return redirect('/admin/stok?kantor='.$head_office->id_kantor.'&bulan='.date('n').'&tahun='.date('Y'));
            }

            // Get bulan
            $bulan = strlen($request->query('bulan')) == 2 ? $request->query('bulan') : '0'.$request->query('bulan');

            // Get tanggal awal
            $tanggal_awal = $request->query('tahun').'-'.$bulan.'-01';

            // Get tanggal akhir
            $tanggal_akhir = $request->query('tahun').'-'.$bulan.'-'.array_month_days($request->query('tahun'))[$request->query('bulan')-1];

            // Get data barang
            $barang = Barang::where('id_kantor','=',$request->query('kantor'))->whereDate('barang_at','<=',$tanggal_akhir)->get();

            // Get kantor
            $kantor = Kantor::where('id_grup','=',Auth::user()->id_grup)->get();

            // View
            return view('admin/stok/index', [
                'barang' => $barang,
                'kantor' => $kantor,
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
            ]);
        }
        // Jika role admin kantor
        elseif(Auth::user()->role == role_admin_kantor()){
            // Redirect
            if($request->query('bulan') == null || $request->query('tahun') == null){
                // Redirect
                return redirect('/admin/stok?bulan='.date('n').'&tahun='.date('Y'));
            }

            // Get bulan
            $bulan = strlen($request->query('bulan')) == 2 ? $request->query('bulan') : '0'.$request->query('bulan');

            // Get tanggal awal
            $tanggal_awal = $request->query('tahun').'-'.$bulan.'-01';

            // Get tanggal akhir
            $tanggal_akhir = $request->query('tahun').'-'.$bulan.'-'.array_month_days($request->query('tahun'))[$request->query('bulan')-1];

            // Get data barang
            $barang = Barang::where('id_kantor','=',Auth::user()->id_kantor)->whereDate('barang_at','<=',$tanggal_akhir)->get();

            // View
            return view('admin/stok/index', [
                'barang' => $barang,
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
            ]);

        }
    }

    /**
     * Mengupdate data stok
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Get data stok
        $stok = Stok::where('id_barang', '=', $request->barang)->where('bulan', '=', $request->bulan)->where('tahun', '=', $request->tahun)->first();

        // Jika belum ada data
        if(!$stok){
            $stok = new Stok;
            $stok->id_barang = $request->barang;
            $stok->bulan = $request->bulan;
            $stok->tahun = $request->tahun;
            $stok->stok_at = date('Y-m-d H:i:s');
        }

        // Update stok terpilih
        $array = $request->array;
        $stok->stok_awal = $array[0];
        $stok->pembelian = $array[1];
        $stok->terjual = $array[2];
        $stok->sisa = $array[3];
        $stok->selisih = $array[4];
        $stok->stok_akhir = $array[5];
        $stok->save();
        
        // Update stok setelahnya (efek domino)
        $stok_akhir = $stok->stok_akhir;
        $bulan = $request->bulan == 12 ? 1 : $request->bulan + 1;
        $tahun = $request->bulan == 12 ? $request->tahun + 1 : $request->tahun;
        $bulan = strlen($bulan) == 2 ? $bulan : '0'.$bulan;
        $tanggal = $tahun.'-'.$bulan.'-01';

        for($y=date('Y'); $y>=$tahun; $y--){
            for($m=1; $m<=12; $m++){
                if($tanggal <= date('Y-m-').array_month_days(date('Y'))[date('n')-1]){
                    $stok_after = Stok::where('id_barang', '=', $request->barang)->where('bulan', '=', $m)->where('tahun', '=', $y)->first();
                    if($stok_after){
                        $stok_after->stok_awal = $stok_akhir;
                        $stok_after->sisa = $stok_after->stok_awal + $stok_after->pembelian - $stok_after->terjual;
                        $stok_after->stok_akhir = $stok_after->sisa + $stok_after->selisih;
                        $stok_after->save();
                        $stok_akhir = $stok_after->stok_akhir;
                    }
                }
            }
        }
    }
}
