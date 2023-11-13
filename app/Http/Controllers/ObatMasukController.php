<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\pemasok;
use App\Models\detail_obat_masuk;
use App\Models\obat;
use App\Models\obat_masuk;
use App\Models\stok_obat;

class ObatMasukController extends Controller
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
        $detail_obat_masuk = detail_obat_masuk::whereMonth('created_at','=',$month)->get();
        $pemasok_all = pemasok::all();
        $obat = obat::all();

        return view('admin.obat_masuk.index',compact('now','detail_obat_masuk','pemasok_all','obat','tanggal','count'));

    }
    public function index(){

        $now = Carbon::now()->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');

        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $detail_obat_masuk = detail_obat_masuk::whereMonth('created_at','=',$month)->get();
        $pemasok_all = pemasok::all();
        $obat = obat::all();

        return view('admin.obat_masuk.index',compact('now','detail_obat_masuk','pemasok_all','obat','tanggal','count'));
    }
    public function store(request $req){
        $req->validate([
            'id_obat' => 'required',
            'jumlah' => 'required',
            'expired' => 'required',
            'id_pemasok' => 'required',
            'jenis_surat_masuk' => 'required'
        ]);
        $now = Carbon::now()->format('Y-m-d');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $tanggal_exp = (new Carbon($req->expired))->format('Y-m-d');
        $pemasok_all = pemasok::all();
        $obat = obat::all();
        $obat_masuk=obat_masuk::create([
            'id_pemasok' => $req->id_pemasok,
            'jenis_surat_masuk' => $req->jenis_surat_masuk,
            'no_batch' => $req->no_batch
        ])->save();
        $id_obat_masuk = obat_masuk::all()->last();

        // dd($id_obat_masuk);
        $detail_obat_masuk = detail_obat_masuk::create([
            'id_obat_masuk' => $id_obat_masuk->id,
            'id_obat' => $req->id_obat,
            'jumlah' => $req->jumlah,
            'expired' => $tanggal_exp
        ])->save();

        //Menambah data di tabel stok_obat
        $stok_obat= stok_obat::create([
            'id_obat' => $req->id_obat,
            'sisa_stok' => $req->jumlah,
            'expired' => $tanggal_exp
        ])->save();
        //Update stok di table obat
        $obat_now = obat::find($req->id_obat);
        $stok_update = $obat_now->total_stok + $req->jumlah;
        $stok_obat = obat::where('id', $req->id_obat)
              ->update(['total_stok' => $stok_update]);

        $detail_obat_masuk = detail_obat_masuk::all();

        return redirect()->route('obat-masuk.index');
        if($stok_obat){
            return view('admin.obat_masuk.index',compact('now','tanggal_exp','detail_obat_masuk','pemasok_all','obat','tanggal','count'))->with('pesan','Berhasil tambah obat_masuk');
         }else {
            return view('admin.obat_masuk.index')->with('pesan','Gagal tambah obat_masuk');
        }
    }

    public function update(request $req,$id){
        $req->validate([
            'id_obat' => 'required',
            'jumlah' => 'required',
            'expired' => 'required',
            'id_pemasok' => 'required',
            'jenis_surat_masuk' => 'required'
        ]);
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $tanggal_exp = (new Carbon($req->expired))->format('Y-m-d');

        // dd($id);

        $obat_masuk = obat_masuk::where('id',$id)->first();
        obat_masuk::where('id',$id)->update([
            'id_pemasok' => $req->id_pemasok,
            'jenis_surat_masuk' => $req->jenis_surat_masuk,
            'no_batch' => $req->no_batch
        ]);

        $det_mas = detail_obat_masuk::where('id_obat_masuk',$id)->first();
        //Update stok di table obat
        $obat_now = obat::find($req->id_obat);
        $stok_update = ($obat_now->total_stok - $det_mas->jumlah )+ $req->jumlah;
        // dd($stok_update);
        obat::where('id', $det_mas->id_obat)
            ->update(['total_stok' => $stok_update]);
        // dd($id_obat_masuk);


        $stok_obat_now = stok_obat::where('id_obat',$det_mas->id_obat)->where('created_at',$det_mas->created_at)->first();
        $stok_obat_update = ($stok_obat_now->sisa_stok - $det_mas->jumlah)+ $req->jumlah;
        // dd($stok_obat_update);
        //Menambah data di tabel stok_obat
        stok_obat::where('id_obat',$det_mas->id_obat)->where('created_at',$det_mas->created_at)-> update([
            'sisa_stok' => $stok_obat_update,
            'expired' => $tanggal_exp
        ]);

        detail_obat_masuk::where('id',$obat_masuk->id)->update([
            'id_obat' => $req->id_obat,
            'jumlah' => $req->jumlah,
            'expired' => $tanggal_exp
        ]);


        $detail_obat_masuk = detail_obat_masuk::all();
        $pemasok_all = pemasok::all();
        $obat = obat::all();

        return redirect()->route('obat-masuk.index');
        if($detail_obat_masuk){
            return view('admin.obat_masuk.index',compact('tanggal_exp','detail_obat_masuk','pemasok_all','obat','tanggal','count'))->with('pesan','Berhasil tambah obat_masuk');
         }else {
            return view('admin.obat_masuk.index')->with('pesan','Gagal tambah obat_masuk');
        }
    }

    public function destroy($masuk){

        $now = Carbon::now()->format('Y-m-d');
        // dd($masuk);
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        // dd($id);

        $obat_masuk = obat_masuk::where('id',$masuk)->first();

        $det_mas = detail_obat_masuk::where('id_obat_masuk',$masuk)->first();
        $stok_mas = stok_obat::where('id_obat',$det_mas->id_obat)->where('created_at',$det_mas->created_at)->first();
        //Update stok di table obat
        $obat_now = obat::find($det_mas->id_obat);
        $stok_update = ($obat_now->total_stok - $stok_mas->sisa_stok );
        // dd($stok_update);
        obat::where('id', $det_mas->id_obat)
            ->update(['total_stok' => $stok_update]);
        // dd($id_obat_masuk);

        stok_obat::where('id_obat',$det_mas->id_obat)->where('created_at',$det_mas->created_at)->delete();
        detail_obat_masuk::where('id',$obat_masuk->id)->delete();
        obat_masuk::where('id',$masuk)->delete();
        // obat_keluar::where('id_stok',$stok_mas->id)->delete();

        $detail_obat_masuk = detail_obat_masuk::all();
        $pemasok_all = pemasok::all();
        $obat = obat::all();

        return redirect()->route('obat-masuk.index');
        if($detail_obat_masuk){
            return view('admin.obat_masuk.index',compact('now','detail_obat_masuk','pemasok_all','obat','tanggal','count'))->with('pesan','Berhasil tambah obat_masuk');
         }else {
            return view('admin.obat_masuk.index')->with('pesan','Gagal tambah obat_masuk');
        }
    }
}
