<?php

namespace App\Http\Controllers;

use App\Models\lplpo_puskesmas;
use App\Models\KeluarPuskesmas;
use Illuminate\Http\Request;
use App\Models\obat;
use App\Models\stok_obat;
use App\Models\detail_obat_keluar;
use App\Models\obat_keluar;
use App\Models\puskesmas;
use App\Models\jenis_keluar;
use App\Exports\LplpoExport;

use App\Exports\BukuIndukExport;
use App\Exports\PerencanaanExport;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

class LplpoPuskesmasController extends Controller
{
    public function expired(){
        $now = Carbon::now()->format('Y-m-d');
        $user = auth()->user()->puskesmas->id;
        $obat_keluar = obat_keluar::where('id_puskesmas','=',$user)->get();
        $tanggal = detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'id_obat_keluar')->where('id_puskesmas','=',$user)->whereDate('expired','<=',$now)->where('sisa_stok','>',0)->get();

        $count = $tanggal->count();
        // dd($now,$exp,$count);
        return compact('tanggal','count');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user()->id_pus;
        $now = Carbon::now()->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');
        $month_kemaren = $month - 1;
        $mmont = stok_obat::whereMonth('created_at','<=',$month_kemaren)->get();
        // dd($year);
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $awal = lplpo_puskesmas::whereMonth('created_at','=',$month_kemaren)->where('id_puskesmas',$user)->get();
        $puskesmas = puskesmas::where('id','=',$user)->first();
        $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $keluar_puskesmas = KeluarPuskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $persediaan_awal=obat_keluar::whereMonth('created_at','=',$mmont)->where('id_puskesmas',$user)->get();
        $lplpo_puskesmas = lplpo_puskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
// dd($detail_obat_keluar,$keluar_puskesmas,$persediaan_awal,$obat_keluar);
        $obat = obat::all();
        $lplp = lplpo_puskesmas::whereMonth('created_at','=',$month_kemaren)->where('id_puskesmas',$user)->get();

        return view('puskesmas.lplpo_puskesmas.index',compact('lplp','awal','lplpo_puskesmas','keluar_puskesmas','persediaan_awal','mmont','now','detail_obat_keluar','obat_keluar','obat','tanggal','count'));

    }
    public function confirm($id_obat,$id_pus,$stok_awal,$penerimaan_awal,$pemakaian_awal,$sisa,$persediaan,$now){
        $now = Carbon::parse($now)->toDateTime();
        // dd($now);
        $user = auth()->user()->id_pus;
        lplpo_puskesmas::create([
            'id_puskesmas' => $id_pus,
            'id_obat' => $id_obat,
            'awal' => $stok_awal,
            'penerimaan' => $penerimaan_awal,
            'stok_puskesmas' => $persediaan,
            'sisa_stok' => $sisa,
            'pemakaian' => $pemakaian_awal,
            'permintaan'=> 0,
            'created_at' => $now,
        ])->save();

        return redirect()->route('lplpo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\lplpo_puskesmas  $lplpo_puskesmas
     * @return \Illuminate\Http\Response
     */
    public function show(lplpo_puskesmas $lplpo_puskesmas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\lplpo_puskesmas  $lplpo_puskesmas
     * @return \Illuminate\Http\Response
     */
    public function edit(request $req,$id)
    {
        // $lplpo =lplpo_puskesmas::find($id);
        // dd($lplpo,$req->permintaan,$req->id_lplpo);
        lplpo_puskesmas::where('id',$req->id_lplpo)->update([
            'awal' => $req->awal,
            'permintaan' => $req->permintaan
        ]);

        return redirect()->route('lplpo.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\lplpo_puskesmas  $lplpo_puskesmas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, lplpo_puskesmas $lplpo_puskesmas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lplpo_puskesmas  $lplpo_puskesmas
     * @return \Illuminate\Http\Response
     */
    public function destroy(lplpo_puskesmas $lplpo_puskesmas)
    {
        //
    }
    public function lplpo_filter(request $req){
        // dd($req);
        $user = auth()->user()->id_pus;
        $now = Carbon::parse($req->tanggal_input)->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');
        $month_kemaren = $month - 1;
        $mmont = stok_obat::whereMonth('created_at','<=',$month_kemaren)->get();
        // dd($mmont);
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $awal = lplpo_puskesmas::whereMonth('created_at','=',$month_kemaren)->where('id_puskesmas',$user)->get();
        $puskesmas = puskesmas::where('id','=',$user)->first();
        $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $keluar_puskesmas = KeluarPuskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $persediaan_awal=obat_keluar::whereMonth('created_at','=',$mmont)->where('id_puskesmas',$user)->get();
        $lplpo_puskesmas = lplpo_puskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
// dd($detail_obat_keluar,$keluar_puskesmas,$persediaan_awal,$obat_keluar);
        $obat = obat::all();
        $lplp = lplpo_puskesmas::whereMonth('created_at','=',$month_kemaren)->where('id_puskesmas',$user)->get();

// dd($pemakaian_awal,$mmont);
        return view('puskesmas.lplpo_puskesmas.index',compact('lplp','awal','lplpo_puskesmas','keluar_puskesmas','persediaan_awal','mmont','now','detail_obat_keluar','obat_keluar','obat','tanggal','count'));

    }

    public function admin(){
        $puskesmas_all = puskesmas::all();
        $user = 8;
        $now = Carbon::now()->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');
        $month_kemaren = $month - 1;
        $mmont = stok_obat::whereMonth('created_at','<=',$month_kemaren)->get();
        // dd($year);
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $awal = lplpo_puskesmas::whereMonth('created_at','=',$month_kemaren)->where('id_puskesmas',$user)->get();

        $puskesmas = puskesmas::where('id','=',$user)->first();
        $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $keluar_puskesmas = KeluarPuskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $persediaan_awal=obat_keluar::whereMonth('created_at','=',$mmont)->where('id_puskesmas',$user)->get();
        $lplpo_puskesmas = lplpo_puskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
// dd($detail_obat_keluar,$keluar_puskesmas,$persediaan_awal,$obat_keluar);
        $lplp = lplpo_puskesmas::whereMonth('created_at','=',$month_kemaren)->where('id_puskesmas',$user)->get();

        $obat = obat::all();


        return view('admin.laporan.showlplpo',compact('lplp','awal','user','puskesmas_all','lplpo_puskesmas','keluar_puskesmas','persediaan_awal','mmont','now','detail_obat_keluar','obat_keluar','obat','tanggal','count','puskesmas'));

    }
    public function admin_filter(request $req){
        $puskesmas_all = puskesmas::all();
        $user = $req->id_puskesmas;
        $now = Carbon::parse($req->tanggal_input)->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');
        $month_kemaren = $month - 1;
        $mmont = stok_obat::whereMonth('created_at','<=',$month_kemaren)->get();
        // dd($year);
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $awal = lplpo_puskesmas::whereMonth('created_at','=',$month_kemaren)->where('id_puskesmas',$user)->get();

        $puskesmas = puskesmas::where('id','=',$user)->first();
        $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $keluar_puskesmas = KeluarPuskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $persediaan_awal=obat_keluar::whereMonth('created_at','=',$mmont)->where('id_puskesmas',$user)->get();
        $lplpo_puskesmas = lplpo_puskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
// dd($detail_obat_keluar,$keluar_puskesmas,$persediaan_awal,$obat_keluar);
        $lplp = lplpo_puskesmas::whereMonth('created_at','=',$month_kemaren)->where('id_puskesmas',$user)->get();
        $obat = obat::all();
        // dd($persediaan_awal,$mmont,$lplp);
        return view('admin.laporan.showlplpo',compact('lplp','awal','user','puskesmas_all','lplpo_puskesmas','keluar_puskesmas','persediaan_awal','mmont','now','detail_obat_keluar','obat_keluar','obat','tanggal','count','puskesmas'));

    }
    public function exportlplpo($now,$user)
    {
        return Excel::download(new LplpoExport($now,$user), 'LPLPO.xlsx');
    }
    public function exportperencanaan($now)
    {
        return Excel::download(new PerencanaanExport($now), 'Perencaan.xlsx');
    }
    public function exportbuku($now)
    {
        return Excel::download(new BukuIndukExport($now), '2022.xlsx');
    }
}
