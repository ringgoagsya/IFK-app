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

class DetailObatKeluarController extends Controller
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


    public function update(request $req,$id){

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
        $tanggal_exp = (new Carbon($req->expired))->format('Y-m-d');

        $det_mas = detail_obat_keluar::find($id);
        //Update stok di table obat
        $obat_now = obat::find($det_mas->id_obat);
        // dd($obat_now->total_stok, $det_mas->jumlah, $req->jumlah);
        $stok_update = ($obat_now->total_stok + $det_mas->jumlah )- $req->jumlah;
        // dd($stok_update);
        obat::where('id', $det_mas->id_obat)
            ->update(['total_stok' => $stok_update]);
        // dd($id_obat_keluar);

        $stok_obat_now = stok_obat::find($det_mas->id_stok);
        $stok_obat_update = ($stok_obat_now->sisa_stok + $det_mas->jumlah)- $req->jumlah;
        // dd($stok_obat_update);
        //Menambah data di tabel stok_obat
        stok_obat::where('id',$det_mas->id_stok)-> update([
            'sisa_stok' => $stok_obat_update,
        ]);

        $sisa_stok_puskesmas = $det_mas->sisa_stok - ($det_mas->jumlah - $req->jumlah);
        detail_obat_keluar::where('id',$det_mas->id)->update([
            'id_obat' => $stok_obat_now->id_obat,
            'id_stok' =>$req->id_obat,
            'jumlah' => $req->jumlah,
            'sisa_stok' => $sisa_stok_puskesmas
        ]);

        $obat_keluar = obat_keluar::where('id',$det_mas->id_obat_keluar)->first();
        obat_keluar::where('id',$id)->update([
            'id_puskesmas' => $req->id_puskesmas,
            'id_jenis_keluar' => $req->id_jenis_keluar
        ]);


        $detail_obat_keluar = detail_obat_keluar::all();
        $obat = obat::all();
        $stok_obat = stok_obat::all();
        $puskesmas = puskesmas::all();
        $jenis_keluar = jenis_keluar::all();


        return redirect()->route('obat-keluar.index');
        if($detail_obat_keluar){
            return view('admin.obat_keluar.index',compact('now','stok_obat','puskesmas','jenis_keluar','tanggal_exp','detail_obat_keluar','obat','tanggal','count'))->with('pesan','Berhasil tambah obat_keluar');
         }else {
            return view('admin.obat_keluar.index')->with('pesan','Gagal tambah obat_keluar');
        }
    }

    public function destroy($keluar){

        $now = Carbon::now()->format('Y-m-d');
        // dd($keluar);
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        // dd($id);
        $det_mas = detail_obat_keluar::find('id',$keluar);
        // dd($det_mas);
        $obat_keluar = obat_keluar::find('id',$det_mas->id_obat_keluar);


        $stok_now = stok_obat::find('id',$det_mas->id_stok);
        //Update stok di table obat
        $obat_now = obat::find($det_mas->id_obat);
        $stok_update = ($obat_now->total_stok + $det_mas->jumlah );
        // dd($stok_update);
        obat::where('id', $det_mas->id_obat)
            ->update(['total_stok' => $stok_update]);
        // dd($id_obat_keluar);

        $sisa_update = ($stok_now->sisa_stok + $det_mas->jumlah );
        stok_obat::where('id',$det_mas->id_stok)->update(['sisa_stok' =>$sisa_update]);

        detail_obat_keluar::where('id',$keluar)->delete();
        obat_keluar::where('id',$obat_keluar->id)->delete();

        $detail_obat_keluar = detail_obat_keluar::all();
        $obat = obat::all();

        $jenis_keluar = jenis_keluar::all();
        $stok_obat = stok_obat::all();

        $puskesmas = puskesmas::all();

        return redirect()->route('obat-keluar.index');
        if($detail_obat_keluar){
            return view('admin.obat_keluar.index',compact('now','puskesmas','jenis_keluar','stok_obat','detail_obat_keluar','obat','tanggal','count'))->with('pesan','Berhasil tambah obat_keluar');
         }else {
            return view('admin.obat_keluar.index')->with('pesan','Gagal tambah obat_keluar');
        }
    }
}
