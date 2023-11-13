<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\obat;
use App\Models\stok_obat;
use App\Models\detail_obat_masuk;
use App\Models\detail_obat_keluar;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\obat_keluar;
use App\Models\puskesmas;
use App\Models\KeluarPuskesmas;

use App\Models\jenis_keluar;

use Illuminate\Http\Request;

class PuskesmasController extends Controller
{
    public function show(){
        $now = Carbon::now()->format('Y-m-d');
        $stok_obat = stok_obat::all();
        foreach($stok_obat as $stok){
            $exp = $stok->expired;
        }

        $tanggal = stok_obat::whereDate('expired','<=',$now)->get();
        $count = stok_obat::whereDate('expired','<=',$now)->count();
        // dd($now,$exp,$count);
        $puskesmas = puskesmas::all();
        return view('admin.puskesmas_user.show',compact('puskesmas','tanggal','count'));
    }

    public function store(request $req){
        $req->validate([
            'nama_puskesmas' => 'required',
            'slug' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
        ]);
        $puskesmas = puskesmas::find($req->id_puskesmas);
        Puskesmas::create([
            'nama_puskesmas' => $req->nama_puskesmas,
            'slug' => $req->slug,
            'no_telp' => $req->no_telp,
            'alamat' => $req->alamat,
            'created_at' => now(),
            'updated_at' => now()
            ]);
        return redirect()->route('puskesmas-show.index');
    }

    public function profile(request $req, $id){
        $req->validate([
            'kepala_puskesmas' => 'required',
            'pengelola' => 'required',
            'nip_pengelola' =>'required',
            'nip_kapus' => 'required',
        ]);
        $puskesmas = puskesmas::find($id);
        puskesmas::where('id', $id)->update([
            'pengelola' => $req->pengelola,
            'kepala_puskesmas' => $req->kepala_puskesmas,
            'nip_kapus' => $req->nip_kapus,
            'nip_pengelola' => $req->nip_pengelola,
            'updated_at' => now()
            ]);
        return redirect()->route('profile.edit');
    }
    public function update(request $req,$id){
        $req->validate([
            'nama_puskesmas' => 'required',
            'alamat' => 'required',
            'slug' => 'required',
            'no_telp' => 'required',
        ]);
        $puskesmas = puskesmas::find($req->id_puskesmas);
        puskesmas::where('id', $id)->update([
            'nama_puskesmas' => $req->nama_puskesmas,
            'alamat' => $req->alamat,
            'slug' => $req->slug,
            'no_telp' => $req->no_telp,
            'updated_at' => now()
            ]);
        return redirect()->route('puskesmas-show.index');
    }
    public function destroy($id){
        Puskesmas::where('id', $id)->delete();
        return redirect()->route('puskesmas-show.index');
    }


    public function index()
    {

        $obat = obat::all();
        //line chart obat masuk
        $user = auth()->user()->puskesmas->id;
        $obat_keluar = obat_keluar::where('id_puskesmas','=',$user)->get();
        $total_obat_masuk = detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'id_obat_keluar')->where('id_puskesmas','=',$user)->select(DB::raw("CAST(SUM(jumlah) as int) as total_masuk"))->GroupBy(DB::raw("Month(detail_obat_keluars.created_at)"))->orderBy("detail_obat_keluars.created_at")->pluck("total_masuk");
        $bulan = detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'id_obat_keluar')->where('id_puskesmas','=',$user)->select(DB::raw("MONTHNAME(detail_obat_keluars.created_at) as bulan"))->GroupBy(DB::raw("MONTHNAME(detail_obat_keluars.created_at)"))->orderBy("detail_obat_keluars.created_at")->pluck("bulan");
        $sisa_obat_masuk = detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'id_obat_keluar')->where('id_puskesmas','=',$user)->select(DB::raw("CAST(SUM(sisa_stok) as int) as sisa_masuk"))->GroupBy(DB::raw("id_obat"))->orderBy("sisa_masuk","DESC")->take(5)->pluck("sisa_masuk");
        $nama_obatnya = detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'id_obat_keluar')->join('obats','obats.id', '=', 'id_obat')->where('id_puskesmas','=',$user)->select(DB::raw("CAST(SUM(sisa_stok) as int) as sisa_masuk"),"nama_obat")->GroupBy(DB::raw("obats.nama_obat"))->orderBy("sisa_masuk","DESC")->take(5)->pluck("nama_obat");
        // dd($total_obat_masuk,$sisa_obat_masuk,$nama_obatnya);


        //line chart obat keluar
        $total_obat_keluar = KeluarPuskesmas::where('id_puskesmas','=',$user)->select(DB::raw("CAST(SUM(jumlah) as int) as total_keluar"))->GroupBy(DB::raw("Month(created_at)"))->orderBy("keluar_puskesmas.created_at")->pluck("total_keluar");
        $bulan_keluar = KeluarPuskesmas::where('id_puskesmas','=',$user)->select(DB::raw("MONTHNAME(created_at) as bulan_keluar"))->GroupBy(DB::raw("MONTHNAME(created_at)"))->orderBy("keluar_puskesmas.created_at")->pluck("bulan_keluar");
        $stok_keluar = KeluarPuskesmas::join('detail_obat_keluars', 'detail_obat_keluars.id', '=', 'id_detail_obat_keluar')->join('obats','obats.id', '=', 'id_obat')->where('id_puskesmas','=',$user)->select(DB::raw("CAST(SUM(keluar_puskesmas.jumlah) as int) as totals"))->GroupBy(DB::raw("id_obat"))->orderBy("totals","DESC")->take(5)->pluck("totals");
        $nama_obatnya_keluar = KeluarPuskesmas::join('detail_obat_keluars', 'detail_obat_keluars.id', '=', 'id_detail_obat_keluar')->join('obats','obats.id', '=', 'detail_obat_keluars.id_obat')->where('id_puskesmas','=',$user)->select(DB::raw("CAST(SUM(keluar_puskesmas.jumlah) as int) as totals"),"nama_obat")->GroupBy(DB::raw("obats.nama_obat"))->orderBy("totals","DESC")->take(5)->pluck("nama_obat");

        // dd($stok_keluar,$nama_obatnya_keluar);

        // dd($stok_keluar,$bulan,$total_obat_masuk,$sisa_obat_masuk);
            $obat_limpul = detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'id_obat_keluar')->where('id_puskesmas','=',$user)->whereBetween('sisa_stok',[0,29])->get();
            $obat_duatus = detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'id_obat_keluar')->where('id_puskesmas','=',$user)->whereBetween('sisa_stok',[30,50])->get();
            $obat_matus = detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'id_obat_keluar')->where('id_puskesmas','=',$user)->whereBetween('sisa_stok',[51,70])->get();


        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];

        // dd($total_obat_masuk,$bulan_keluar);
        return view('puskesmas.dashboard_puskesmas.index',compact('nama_obatnya_keluar','nama_obatnya','sisa_obat_masuk','tanggal','count','total_obat_masuk','bulan','total_obat_keluar','bulan_keluar','obat','obat_limpul','obat_duatus','obat_matus','stok_keluar'));
    }
    public function expired(){
        $now = Carbon::now()->format('Y-m-d');
        $user = auth()->user()->puskesmas->id;
        $obat_keluar = obat_keluar::where('id_puskesmas','=',$user)->get();
        $tanggal = detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'id_obat_keluar')->where('id_puskesmas','=',$user)->whereDate('expired','<=',$now)->where('detail_obat_keluars.sisa_stok','>',0)->get();


        $stok_obat = stok_obat::all()->where('sisa_stok','>',0);
        foreach($stok_obat as $stok){
            $exp = $stok->expired;
        }

        // $tanggal = stok_obat::whereDate('expired','<=',$now)->get();
        $count = $tanggal->count();
        // dd($now,$exp,$count);
        return compact('tanggal','count');
    }

    public function obat()
    {
        $now = Carbon::now()->format('Y-m-d');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $obat = obat::all();
        $stok_obat = stok_obat::all();
        return view('puskesmas.stok_puskesmas.index',compact('now', 'stok_obat','obat','tanggal','count',));
    }
    public function stokobat()
    {
        $user = auth()->user()->id_pus;
        $now = Carbon::now()->format('Y-m-d');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $obat = obat::all();
        $obat_keluar = obat_keluar::where('id_puskesmas',$user)->get();
        $detail_obat_keluar = detail_obat_keluar::all();
        return view('puskesmas.stok_puskesmas.puskesmas',compact('detail_obat_keluar','obat_keluar','now','obat','tanggal','count',));
    }
    public function obat_masuk()
    {
        $now = Carbon::now()->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $user = auth()->user()->id_pus;
        $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $puskesmas = puskesmas::all();
        $jenis_keluar = jenis_keluar::all();
        $stok_obat = stok_obat::all();
        return view('puskesmas.masuk_puskesmas.index',compact('obat_keluar','now','detail_obat_keluar','puskesmas','jenis_keluar','stok_obat','tanggal','count'));

    }

    public function masuk_filter(request $req)
    {
        $now = Carbon::parse($req->tanggal_input)->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $user = auth()->user()->id_pus;
        $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $puskesmas = puskesmas::all();
        $jenis_keluar = jenis_keluar::all();
        $stok_obat = stok_obat::all();
        return view('puskesmas.masuk_puskesmas.index',compact('obat_keluar','now','detail_obat_keluar','puskesmas','jenis_keluar','stok_obat','tanggal','count'));

    }
}
