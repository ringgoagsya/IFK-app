<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\obat;
use App\Models\stok_obat;
use App\Models\detail_obat_keluar;
use App\Models\obat_keluar;
use App\Models\puskesmas;

use App\Models\jenis_keluar;

use Carbon\Carbon;

class ObatKeluarController extends Controller
{

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
    public function filter(request $req){
        $now = Carbon::parse($req->tanggal_input)->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');

        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $puskesmas = puskesmas::all();
        $jenis_keluar = jenis_keluar::all();
        $stok_obat = stok_obat::all();
        return view('admin.obat_keluar.index',compact('now','detail_obat_keluar','puskesmas','jenis_keluar','stok_obat','tanggal','count'));

    }
    public function index(){
        $now = Carbon::now()->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $puskesmas = puskesmas::all();
        $jenis_keluar = jenis_keluar::all();
        $stok_obat = stok_obat::all();
        return view('admin.obat_keluar.index',compact('now','detail_obat_keluar','puskesmas','jenis_keluar','stok_obat','tanggal','count'));
    }

    public function laporan(){
        $now = Carbon::now()->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');
        // dd($year);
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $stok_obat = obat::all();
        $obat_keluar = obat_keluar::whereYear('created_at','=',$year)->get();
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$year)->get();

        return view('admin.laporan.index',compact('now','detail_obat_keluar','stok_obat','tanggal','count'));
    }
    public function laporanfilter(){
        $now = Carbon::parse($req->tanggal_input)->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');

        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $stok_obat = obat::all();
        $obat_keluar = obat_keluar::whereYear('created_at','=',$year)->get();
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$year)->get();

        return view('admin.laporan.index',compact('now','detail_obat_keluar','stok_obat','tanggal','count'));
    }

    public function store(request $req){
        $req->validate([
            'jumlah' => 'required',
            'id_obat' => 'required',
            'id_puskesmas' => 'required',
            'id_jenis_keluar' => 'required'
        ]);

        $now = Carbon::now()->format('Y-m-d');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $stok_obat = stok_obat::find($req->id_obat);
        $obat_now = obat::find($stok_obat->id_obat);
        $obat_keluar=obat_keluar::create([
            'id_puskesmas' => $req->id_puskesmas,
            'id_jenis_keluar' => $req->id_jenis_keluar,
        ])->save();
        $id_obat_keluar = obat_keluar::all()->last();

        $detail_obat_keluar = detail_obat_keluar::create([
            'id_obat_keluar' => $id_obat_keluar->id,
            'id_stok' => $req->id_obat,
            'id_obat' => $stok_obat->id_obat,
            'jumlah' => $req->jumlah,
            'sisa_stok' => $req->jumlah,
            'expired' => $stok_obat->expired
        ])->save();

        //Pengurangan Stok di table stok_obat
        $sisa_stok_obat = $stok_obat->sisa_stok - $req->jumlah;
        $stok_obat= stok_obat::where('id',$req->id_obat)-> update(['sisa_stok' => $sisa_stok_obat]);


        //Pengurangan Stok di table obat
        $stok_update = $obat_now->total_stok - $req->jumlah;
        $stok_obat = obat::where('id', $obat_now->id)
              ->update(['total_stok' => $stok_update]);

        $detail_obat_keluar = detail_obat_keluar::all();
        $puskesmas = puskesmas::all();
        $jenis_keluar = jenis_keluar::all();
        $stok_obat = stok_obat::all();

        return redirect()->route('obat-keluar.index');
        if($stok_obat){
            return view('admin.obat_keluar.index',compact('now','detail_obat_keluar','obat_keluar','puskesmas','stok_obat','jenis_keluar','tanggal','count'))->with('pesan','Berhasil tambah obat_keluar');
         }else {
            return view('admin.obat_keluar.index')->with('pesan','Gagal tambah obat_keluar');
        }
    }

    public function update(request $req,$id){

        $now = Carbon::now()->format('Y-m-d');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $tanggal_exp = (new Carbon($req->expired))->format('Y-m-d');

        // dd($id);

        $obat_keluar = obat_keluar::where('id',$id)->first();
        obat_keluar::where('id',$id)->update([
            'id_puskesmas' => $req->id_puskesmas,
            'id_jenis_keluar' => $req->id_jenis_keluar
        ]);

        $det_mas = detail_obat_keluar::where('id_obat_keluar',$id)->first();
        //Update stok di table obat
        $obat_now = obat::find($det_mas->id_obat);
        $stok_update = ($obat_now->total_stok + $det_mas->jumlah )+ $req->jumlah;
        // dd($stok_update);
        obat::where('id', $det_mas->id_obat)
            ->update(['total_stok' => $stok_update]);
        // dd($id_obat_keluar);


        $stok_obat_now = stok_obat::where('id_obat',$det_mas->id_obat)->where('created_at',$det_mas->created_at)->first();
        $stok_obat_update = ($stok_obat_now->sisa_stok + $det_mas->jumlah)+ $req->jumlah;
        // dd($stok_obat_update);
        //Menambah data di tabel stok_obat
        stok_obat::where('id_obat',$det_mas->id_obat)->where('created_at',$det_mas->created_at)-> update([
            'sisa_stok' => $stok_obat_update,
        ]);

        detail_obat_keluar::where('id',$obat_keluar->id)->update([
            'id_obat' => $req->id_obat,
            'jumlah' => $req->jumlah,
            'sisa_stok' => $req->jumlah,
            'expired' => $tanggal_exp
        ]);


        $detail_obat_keluar = detail_obat_keluar::all();

        $jenis_keluar = jenis_keluar::all();
        $pemasok_all = pemasok::all();
        $obat = obat::all();


        return redirect()->route('obat-keluar.index');
        if($detail_obat_keluar){
            return view('admin.obat_keluar.index',compact('now','jenis_keluar','tanggal_exp','detail_obat_keluar','pemasok_all','obat','tanggal','count'))->with('pesan','Berhasil tambah obat_keluar');
         }else {
            return view('admin.obat_keluar.index')->with('pesan','Gagal tambah obat_keluar');
        }
    }
}
