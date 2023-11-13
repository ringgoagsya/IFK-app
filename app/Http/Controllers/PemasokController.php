<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pemasok;
use App\Models\stok_obat;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class PemasokController extends Controller
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
    public function index(){
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $pemasok = pemasok::all();
        return view('admin.pemasok.index',compact('pemasok','tanggal','count'));
    }
    public function store(request $req){

        $req->validate([
            'nama_pemasok' => 'required',
            'lokasi' => 'required',
        ]);

        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $pemasok=pemasok::create([
            'nama_pemasok' => $req->nama_pemasok,
            'lokasi' => $req->lokasi
            ]);
        $pemasok=pemasok::all();

        return redirect()->route('pemasok.index');
        if($pemasok){
            return view('admin.pemasok.index',compact('pemasok','tanggal','count'))->with('pesan','Berhasil tambah pemasok');
         }else {
            return view('admin.pemasok.index')->with('pesan','Gagal tambah pemasok');
        }
    }

    public function edit(request $req, $id){
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        pemasok::where('id', $id)->update([
            'nama_pemasok' => $req->nama_pemasok,
            'lokasi'=> $req->lokasi]);

        $pemasok = pemasok::all();
        return redirect()->route('pemasok.index');
        return view('admin.pemasok.index',compact('pemasok','tanggal','count'))->with('pesan','Berhasil Mengubah');
    }

    public function destroy(request $req, $id){
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $pemasok = pemasok::where('id', $id)->delete();

        return redirect()->route('pemasok.index');

    }
}
