<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\obat;
use App\Models\stok_obat;
use App\Models\detail_obat_masuk;
use App\Models\detail_obat_keluar;
use App\Models\obat_keluar;

use App\Models\KeluarPuskesmas;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['auth','ceklevel:admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        //line chart obat masuk
        $total_obat_masuk = detail_obat_masuk::select(DB::raw("CAST(SUM(jumlah) as int) as total_masuk"))->GroupBy(DB::raw("Month(created_at)"))->orderBy("detail_obat_masuks.created_at")->pluck("total_masuk");
        $bulan = detail_obat_masuk::select(DB::raw("MONTHNAME(created_at) as bulan"))->GroupBy(DB::raw("MONTHNAME(created_at)"))->orderBy("detail_obat_masuks.created_at")->pluck("bulan");
        //line chart obat keluar
        $total_obat_keluar = detail_obat_keluar::select(DB::raw("CAST(SUM(jumlah) as int) as total_keluar"))->GroupBy(DB::raw("Month(created_at)"))->orderBy("detail_obat_keluars.created_at")->pluck("total_keluar");
        $bulan_keluar = detail_obat_keluar::select(DB::raw("MONTHNAME(created_at) as bulan_keluar"))->GroupBy(DB::raw("MONTHNAME(created_at)"))->orderBy("detail_obat_keluars.created_at")->pluck("bulan_keluar");
        $stok_keluar = detail_obat_keluar::select(DB::raw("CAST(SUM(jumlah) as int) as totals"))->GroupBy(DB::raw("id_obat"))->orderBy("totals","DESC")->take(5)->pluck("totals");
        $nama_obatnya = detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'id_obat_keluar')->join('obats','obats.id', '=', 'id_obat')->select(DB::raw("CAST(SUM(jumlah) as int) as totals"),"nama_obat")->GroupBy(DB::raw("obats.nama_obat"))->orderBy("totals","DESC")->take(5)->pluck("nama_obat");
        // dd($bulan,$bulan_keluar);

        $obat = obat::all();
        $obat_limpul = obat::whereBetween('total_stok',[0,49])->where('updated_at','!=',null)->get();
        $obat_duatus = obat::whereBetween('total_stok',[50,199])->where('updated_at','!=',null)->get();
        $obat_matus = obat::whereBetween('total_stok',[200,500])->where('updated_at','!=',null)->get();
        //  dd($obat_matus);
        $obat = obat::where('total_stok','>',0)->orderBy("total_stok","DESC")->take(5)->get();
        // dd($obat);
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];

        // dd($total_obat_masuk,$bulan_keluar);
        return view('dashboard',compact('nama_obatnya','tanggal','count','total_obat_masuk','bulan','total_obat_keluar','bulan_keluar','obat','obat_limpul','obat_duatus','obat_matus','stok_keluar'));
    }

    public function expired(){
        $now = Carbon::now()->format('Y-m-d');
        $stok_obat = stok_obat::all();
        foreach($stok_obat as $stok){
            $exp = $stok->expired;
        }

        $tanggal = stok_obat::whereDate('expired','<=',$now)->where('sisa_stok','>',0)->get();
        $count = stok_obat::whereDate('expired','<=',$now)->where('sisa_stok','>',0)->count();
        // dd($now,$exp,$count);
        return compact('tanggal','count');
    }
}
