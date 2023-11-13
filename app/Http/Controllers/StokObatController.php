<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\stok_obat;
use App\Models\obat;
use App\Models\puskesmas;
use App\Models\obat_keluar;
use App\Models\obat_masuk;
use App\Models\detail_obat_keluar;
use App\Models\detail_obat_masuk;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BukuIndukExport;


use Carbon\Carbon;

class StokObatController extends Controller
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
        $obat = obat::all();
        $stok_obat = stok_obat::all();

        $now = Carbon::now()->format('Y-m-d');
        return view('admin.stok_obat.index',compact('now','stok_obat','obat','tanggal','count'));
    }

    public function indexinduk(){


        $now = Carbon::now()->format('Y-m-d');
        $day = Carbon::now()->format('d');
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        $month_kemaren = $month - 1;

        $dday = stok_obat::whereDate('created_at', '=',$day)->get();
        $mmont = stok_obat::whereMonth('created_at','<=',$month_kemaren)->get();
        $yyear = stok_obat::whereYear('created_at','=',$year)->get();

        // dd($mmont);
        $obat = obat::all();
        $persediaan_awal = stok_obat::whereMonth('created_at','<',$month)->get();
        $total_keluar = detail_obat_keluar::whereMonth('created_at','<',$month)->get();
        $total_masuk = detail_obat_masuk::whereMonth('created_at','<',$month)->get();
        // $hitung_keluar = 0;
        // $hitung_masuk = 0;
        // foreach ($obat as $obeng) {

        //     foreach ($total_keluar as $tk) {
        //         if ($obeng->id == $tk->id_obat) {
        //             $hitung_keluar = $hitung_keluar + $tk->jumlah;
        //         }
        //     }
        //     foreach ($total_masuk as $tm) {
        //         if ($obeng->id == $tm->id_obat) {
        //             $hitung_masuk = $hitung_masuk + $tm->jumlah;
        //         }
        //     }
        // }
        // dd($total_masuk,$month,$persediaan_awal,$total_keluar,$hitung_masuk,$hitung_keluar);
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        // $stok_obat = stok_obat::whereMonth('created_at','<=',$month)->get();
        $detail_obat_keluar =  detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $detail_obat_masuk = detail_obat_masuk::whereMonth('created_at','=',$month)->get();
        $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->get();
        $obat_masuk = obat_masuk::whereMonth('created_at','=',$month)->get();
        $count_puskesmas = puskesmas::count();
        $count_obat = obat::count();

        $puskesmas = puskesmas::all();
        $puskes = puskesmas::all();
        return view('admin.bukustokinduk.index',compact('total_masuk','total_keluar','month','now','obat','puskesmas','detail_obat_keluar','detail_obat_masuk','count_puskesmas','obat_masuk','obat_keluar','count_obat','puskes','tanggal','count','mmont'));
    }
    public function export(){
        return Excel::download(new BukuIndukExport,'stok-induk.xlsx');
    }

    public function store(request $req){
        $req->validate([
            'id_obat' => 'required',
            'jumlah' => 'required',
        ]);
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $obat = obat::all();
        // dd($req);
        $stok_obat=stok_obat::create([
            'id_obat' => $req->id_obat,
            'jumlah' => $req->jumlah
            ]);
        $stok_obat=stok_obat::all();

        if($stok_obat){
            return view('admin.stok_obat.index',compact('stok_obat','obat','tanggal','count'))->with('pesan','Berhasil tambah stok obat');
         }else {
            return view('admin.stok_obat.index')->with('pesan','Gagal tambah obat');
        }
    }

    public function indexfilter(request $req){


        $now = Carbon::parse($req->tanggal_input)->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');

        $month_kemaren = $month - 1;

        $dday = stok_obat::whereDate('created_at', '=',$day)->get();
        $mmont = stok_obat::whereMonth('created_at','<=',$month_kemaren)->get();
        $yyear = stok_obat::whereYear('created_at','=',$year)->get();

        // dd($mmont);
        $obat = obat::all();
        $persediaan_awal = stok_obat::whereMonth('created_at','<',$month)->get();
        $total_keluar = detail_obat_keluar::whereMonth('created_at','<',$month)->get();
        $total_masuk = detail_obat_masuk::whereMonth('created_at','<',$month)->get();
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        // $stok_obat = stok_obat::whereMonth('created_at','<=',$month)->get();
        $detail_obat_keluar =  detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $detail_obat_masuk = detail_obat_masuk::whereMonth('created_at','=',$month)->get();
        $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->get();
        $obat_masuk = obat_masuk::whereMonth('created_at','=',$month)->get();
        $count_puskesmas = puskesmas::count();
        $count_obat = obat::count();

        $puskesmas = puskesmas::all();
        $puskes = puskesmas::all();

        return view('admin.bukustokinduk.index',compact('total_masuk','total_keluar','month','now','obat','puskesmas','detail_obat_keluar','detail_obat_masuk','count_puskesmas','obat_masuk','obat_keluar','count_obat','puskes','tanggal','count','mmont'));
    }



}

