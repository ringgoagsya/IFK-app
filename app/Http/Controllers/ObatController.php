<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\obat;
use App\Models\stok_obat;
use Carbon\Carbon;

class ObatController extends Controller
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
    public function index()
    {
        $now = Carbon::now()->format('Y-m-d');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $obat = obat::all();

        $stok_obat = stok_obat::all();
        return view('admin.obat.index',compact('now','stok_obat','obat','tanggal','count'));
    }

    public function store(request $req){
        $req->validate([
            'nama_obat' => 'required',
            'satuan' => 'required',

        ]);
        $now = Carbon::now()->format('Y-m-d');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $obat=obat::create([
            'nama_obat' => $req->nama_obat,
            'satuan' => $req->satuan,
            'satuan_puskesmas' => $req->satuan_puskesmas
            ]);
        $obat=obat::all();

        $stok_obat = stok_obat::all();
        return redirect()->route('obat.index');
        if($obat){
            return view('admin.obat.index',compact('now','stok_obat','obat','tanggal','count'))->with('pesan','Berhasil tambah obat');
         }else {
            return view('admin.obat.index')->with('pesan','Gagal tambah obat');
        }
    }

    public function edit(request $req, $id){

        $now = Carbon::now()->format('Y-m-d');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        obat::where('id', $id)->update([
            'nama_obat' => $req->nama_obat,
            'satuan'=> $req->satuan,
            'satuan_puskesmas' => $req->satuan_puskesmas
        ]);

        $stok_obat = stok_obat::all();
        $obat = obat::all();
        return redirect()->route('obat.index');
        return view('admin.obat.index',compact('now','stok_obat','obat','tanggal','count'))->with('pesan','Berhasil Mengubah');
    }

    public function destroy(request $req, $id){

        $now = Carbon::now()->format('Y-m-d');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        obat::where('id', $id)->delete();

        $obat = obat::all();
        $stok_obat = stok_obat::all();
        return redirect()->route('obat.index');
        if($obat){
        return view('admin.obat.index',compact('now','stok_obat','obat','tanggal','count'))->with('pesan','Berhasil Menghapus Domain');
        }
    }
}
