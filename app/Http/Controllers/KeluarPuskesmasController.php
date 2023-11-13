<?php

namespace App\Http\Controllers;

use App\Models\KeluarPuskesmas;
use Illuminate\Http\Request;
use App\Models\obat;
use App\Models\stok_obat;
use App\Models\detail_obat_keluar;
use App\Models\obat_keluar;
use App\Models\puskesmas;

use App\Models\lplpo_puskesmas;
use App\Models\jenis_keluar;

use Carbon\Carbon;

class KeluarPuskesmasController extends Controller
{


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
    public function store(Request $req)
    {
        $user = auth()->user()->id_pus;
        $now = Carbon::now()->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        // dd($req->all());
        if ($req->id_obat1) {
            $detail_obat_keluar = detail_obat_keluar::find($req->id_obat1);
            if ($req->jumlah_ambil1[0] != 0 || $req->jumlah_ambil1[0] != null && is_numeric($req->jumlah_ambil1[0])  ) {
                $ambil = $req->jumlah_ambil1[0];
            }
            else{
                $ambil = $req->jumlah_ambil1[1];
            }
            // dd($ambil,$req->jumlah_ambil1);
            $update_stok = $detail_obat_keluar->sisa_stok - $ambil;

            detail_obat_keluar::where('id',$req->id_obat1)->update([
                'sisa_stok' => $update_stok,
            ]);
            $keluar_puskemas=KeluarPuskesmas::create([
                'id_detail_obat_keluar' => $req->id_obat1,
                'id_puskesmas' => $user,
                'jumlah'=> $ambil,
                'keterangan'=> $req->keterangan
            ])->save();
        }

        if ($req->id_obat2) {
            $detail_obat_keluar = detail_obat_keluar::find($req->id_obat2);
            if ($req->jumlah_ambil2[0]) {
                $ambil = $req->jumlah_ambil2[0];
            }
            else{
                $ambil = $req->jumlah_ambil2[1];
            }
            $update_stok = $detail_obat_keluar->sisa_stok - $ambil;
            detail_obat_keluar::where('id',$req->id_obat2)->update([
                'sisa_stok' => $update_stok,
            ]);
            $keluar_puskemas=KeluarPuskesmas::create([
                'id_detail_obat_keluar' => $req->id_obat2,
                'id_puskesmas' => $user,
                'jumlah'=> $ambil,
                'keterangan'=> $req->keterangan
            ])->save();
        }
        if ($req->id_obat3) {
            $detail_obat_keluar = detail_obat_keluar::find($req->id_obat3);
            if ($req->jumlah_ambil3[0]) {
                $ambil = $req->jumlah_ambil3[0];
            }
            else{
                $ambil = $req->jumlah_ambil3[1];
            }
            $update_stok = $detail_obat_keluar->sisa_stok - $ambil;
            detail_obat_keluar::where('id',$req->id_obat3)->update([
                'sisa_stok' => $update_stok,
            ]);
            $keluar_puskemas=KeluarPuskesmas::create([
                'id_detail_obat_keluar' => $req->id_obat3,
                'id_puskesmas' => $user,
                'jumlah'=> $ambil,
                'keterangan'=> $req->keterangan
            ])->save();
        }
        if ($req->id_obat4) {
            $detail_obat_keluar = detail_obat_keluar::find($req->id_obat4);
            if ($req->jumlah_ambil4[0] != 0 || $req->jumlah_ambil4[0] != null && is_numeric($req->jumlah_ambil4[0])  ) {
                $ambil = $req->jumlah_ambil4[0];
            }
            else{
                $ambil = $req->jumlah_ambil4[1];
            }
            // dd($ambil,$req->jumlah_ambil1);
            $update_stok = $detail_obat_keluar->sisa_stok - $ambil;

            detail_obat_keluar::where('id',$req->id_obat4)->update([
                'sisa_stok' => $update_stok,
            ]);
            $keluar_puskemas=KeluarPuskesmas::create([
                'id_detail_obat_keluar' => $req->id_obat4,
                'id_puskesmas' => $user,
                'jumlah'=> $ambil,
                'keterangan'=> $req->keterangan
            ])->save();
        }
        if ($req->id_obat5) {
            $detail_obat_keluar = detail_obat_keluar::find($req->id_obat5);
            if ($req->jumlah_ambil5[0] != 0 || $req->jumlah_ambil5[0] != null && is_numeric($req->jumlah_ambil5[0])  ) {
                $ambil = $req->jumlah_ambil5[0];
            }
            else{
                $ambil = $req->jumlah_ambil5[1];
            }
            // dd($ambil,$req->jumlah_ambil1);
            $update_stok = $detail_obat_keluar->sisa_stok - $ambil;

            detail_obat_keluar::where('id',$req->id_obat5)->update([
                'sisa_stok' => $update_stok,
            ]);
            $keluar_puskemas=KeluarPuskesmas::create([
                'id_detail_obat_keluar' => $req->id_obat5,
                'id_puskesmas' => $user,
                'jumlah'=> $ambil,
                'keterangan'=> $req->keterangan
            ])->save();
        }
        // dd($req->keterangan);
        // $req->validate([
        //     'jumlah' => 'required',
        //     'keterangan' => 'required',
        //     'id_obat_keluar' => 'required'
        // ]);

        if($req->jumlah != 0 ||$req->jumlah != null ){
        $detail_obat_keluar = detail_obat_keluar::find($req->id_obat_keluar);
        $update_stok = $detail_obat_keluar->sisa_stok - $req->jumlah;
        // dd($req->id_obat_keluar,$detail_obat_keluar->sisa_stok,$req->jumlah,$update_stok);
        detail_obat_keluar::where('id',$req->id_obat_keluar)->update([
            'sisa_stok' => $update_stok,
        ]);

        $keluar_puskemas=KeluarPuskesmas::create([
            'id_detail_obat_keluar' => $req->id_obat_keluar,
            'id_puskesmas' => $user,
            'jumlah'=> $req->jumlah,
            'keterangan'=> $req->keterangan
        ])->save();
        }
        $puskesmas = puskesmas::where('id','=',$user)->first();
        $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $keluar_puskesmas = KeluarPuskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
// dd($detail_obat_keluar,$keluar_puskesmas);
        $jenis_keluar = jenis_keluar::all();
        $obat = obat::all();

        $obat_keluar_tambah = obat_keluar::where('id_puskesmas',$user)->get();
        $detail_obat_keluar_tambah = detail_obat_keluar::all();
        return redirect()->route('puskesmas.keluar');
        if($keluar_puskemas){
            return view('puskesmas.keluar_puskesmas.index',compact('detail_obat_keluar_tambah','obat_keluar_tambah','obat_keluar','now','detail_obat_keluar','keluar_puskesmas','puskesmas','obat','jenis_keluar','tanggal','count'))->with('pesan','Berhasil tambah obat_keluar');
         }else {
            return view('puskesmas.keluar_puskesmas.index')->with('pesan','Gagal tambah obat_keluar');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KeluarPuskesmas  $keluarPuskesmas
     * @return \Illuminate\Http\Response
     */
    public function show(KeluarPuskesmas $keluarPuskesmas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KeluarPuskesmas  $keluarPuskesmas
     * @return \Illuminate\Http\Response
     */
    public function edit(KeluarPuskesmas $keluarPuskesmas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KeluarPuskesmas  $keluarPuskesmas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
          // dd($req->keterangan);
          $req->validate([
            'jumlah' => 'required',
            'keterangan' => 'required',
            'id_obat_keluar' => 'required'
        ]);
          $user = auth()->user()->id_pus;
          $now = Carbon::now()->format('Y-m-d');
          $day = Carbon::parse($now)->format('d');
          $month = Carbon::parse($now)->format('m');
          $year = Carbon::parse($now)->format('Y');
          $expired = $this::expired();
          $tanggal = $expired['tanggal'];
          $count = $expired['count'];


          $keluar_puskesmas = KeluarPuskesmas::where('id','=',$id)->first();
        //   dd($id,$keluar_puskesmas->jumlah);

          $detail_obat_keluar = detail_obat_keluar::find($req->id_obat_keluar);
          $update_stok = ($detail_obat_keluar->sisa_stok + $keluar_puskesmas->jumlah) - $req->jumlah;
        //   dd($detail_obat_keluar->sisa_stok,$keluar_puskesmas->jumlah,$req->jumlah,$update_stok);
          detail_obat_keluar::where('id',$req->id_obat_keluar)->update([
              'sisa_stok' => $update_stok,
          ]);

          $keluar_puskemas=KeluarPuskesmas::where('id',$id)->update([
              'id_detail_obat_keluar' => $req->id_obat_keluar,
              'jumlah'=> $req->jumlah,
              'keterangan'=> $req->keterangan
          ]);

          $puskesmas = puskesmas::where('id','=',$user)->first();
          $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
          $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
          $keluar_puskesmas = KeluarPuskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
  // dd($detail_obat_keluar,$keluar_puskesmas);
          $jenis_keluar = jenis_keluar::all();
          $obat = obat::all();
          return redirect()->route('puskesmas.keluar');

          if($keluar_puskemas){
              return view('puskesmas.keluar_puskesmas.index',compact('obat_keluar','obat','now','detail_obat_keluar','keluar_puskesmas','puskesmas','obat','jenis_keluar','tanggal','count'))->with('pesan','Berhasil tambah obat_keluar');
           }else {
              return view('puskesmas.keluar_puskesmas.index')->with('pesan','Gagal tambah obat_keluar');
          }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KeluarPuskesmas  $keluarPuskesmas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user()->id_pus;
        $now = Carbon::now()->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];


        $keluar_puskesmas = KeluarPuskesmas::where('id','=',$id)->first();
        // dd($id,$keluar_puskesmas->id_detail_obat_keluar);

        $detail_obat_keluar = detail_obat_keluar::find($keluar_puskesmas->id_detail_obat_keluar);
        // dd($detail_obat_keluar);
        $update_stok = ($detail_obat_keluar->sisa_stok + $keluar_puskesmas->jumlah);
        // dd($detail_obat_keluar->sisa_stok,$keluar_puskesmas->jumlah,$update_stok);
        detail_obat_keluar::where('id',$keluar_puskesmas->id_detail_obat_keluar)->update([
            'sisa_stok' => $update_stok,
        ]);

        $keluar_puskemas=KeluarPuskesmas::where('id',$id)->delete();

        $puskesmas = puskesmas::where('id','=',$user)->first();
        $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $keluar_puskesmas = KeluarPuskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
// dd($detail_obat_keluar,$keluar_puskesmas);
        $jenis_keluar = jenis_keluar::all();
        $obat = obat::all();

        return redirect()->route('puskesmas.keluar');

    }

    public function expired(){
        $now = Carbon::now()->format('Y-m-d');
        $stok_obat = stok_obat::all();
        foreach($stok_obat as $stok){
            $exp = $stok->expired;
        }

        $user = auth()->user()->puskesmas->id;
        $tanggal = stok_obat::whereDate('expired','<=',$now)->where('sisa_stok','>',0)->get();

        $tanggal = detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'id_obat_keluar')->where('id_puskesmas','=',$user)->whereDate('expired','<=',$now)->where('sisa_stok','>',0)->get();
        $count = $tanggal->count();
        // dd($now,$exp,$count);
        return compact('tanggal','count');
    }
    public function filter(request $req){

        $user = auth()->user()->id_pus;
        $now = Carbon::parse($req->tanggal_input)->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');
        $obat_keluar_tambah = obat_keluar::where('id_puskesmas',$user)->get();
        $detail_obat_keluar_tambah = detail_obat_keluar::all();
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $puskesmas = puskesmas::where('id','=',$user)->first();
        $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $keluar_puskesmas = KeluarPuskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
// dd($detail_obat_keluar,$keluar_puskesmas);
        $jenis_keluar = jenis_keluar::all();
        $stok_obat = stok_obat::all();
        $obat = obat::all();
        $keluar_obat= detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'detail_obat_keluars.id_obat_keluar')->where('obat_keluars.id_puskesmas',$user)->join('obats', 'obats.id', '=', 'detail_obat_keluars.id_obat')->orderBy("detail_obat_keluars.sisa_stok","DESC")->take(5)->get();


        return view('puskesmas.keluar_puskesmas.index',compact('keluar_obat','detail_obat_keluar_tambah','obat_keluar_tambah','obat_keluar','obat','keluar_puskesmas','now','detail_obat_keluar','puskesmas','jenis_keluar','stok_obat','tanggal','count'));

    }
    public function index(){
        $user = auth()->user()->id_pus;
        $now = Carbon::now()->format('Y-m-d');
        $day = Carbon::parse($now)->format('d');
        $month = Carbon::parse($now)->format('m');
        $year = Carbon::parse($now)->format('Y');
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $obat_keluar_tambah = obat_keluar::where('id_puskesmas',$user)->get();
        $detail_obat_keluar_tambah = detail_obat_keluar::all();
        $puskesmas = puskesmas::where('id','=',$user)->first();
        $obat_keluar = obat_keluar::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $detail_obat_keluar = detail_obat_keluar::whereMonth('created_at','=',$month)->get();
        $keluar_puskesmas = KeluarPuskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
// dd($detail_obat_keluar,$keluar_puskesmas);
        $lplpo = lplpo_puskesmas::whereMonth('created_at','=',$month)->where('id_puskesmas',$user)->get();
        $keluar_obat= detail_obat_keluar::join('obat_keluars', 'obat_keluars.id', '=', 'detail_obat_keluars.id_obat_keluar')->where('obat_keluars.id_puskesmas',$user)->join('obats', 'obats.id', '=', 'detail_obat_keluars.id_obat')->orderBy("detail_obat_keluars.sisa_stok","DESC")->take(5)->get();
        // dd($keluar_obat);
        $jenis_keluar = jenis_keluar::all();
        $stok_obat = stok_obat::all();
        $obat = obat::all();
        return view('puskesmas.keluar_puskesmas.index',compact('keluar_obat','detail_obat_keluar_tambah','obat_keluar_tambah','obat_keluar','obat','keluar_puskesmas','now','detail_obat_keluar','puskesmas','jenis_keluar','stok_obat','tanggal','count'));
    }

}
