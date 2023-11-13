<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Http\Request;
use App\Models\obat;
use App\Models\stok_obat;
use App\Models\detail_obat_keluar;
use App\Models\obat_keluar;
use App\Models\puskesmas;

use App\Models\jenis_keluar;

use Carbon\Carbon;
class PerencanaanExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($now)
    {
        $this->now = $now;
    }
    public function expired(){
        $now = Carbon::now()->format('Y-m-d');
        $stok_obat = stok_obat::all();
        foreach($stok_obat as $stok){
            $exp = $stok->expired;
        }

        $tanggal = stok_obat::whereDate('expired','<=',$now)->get();
        $count = stok_obat::whereDate('expired','<=',$now)->count();
        // dd($now,$exp,$count);
        return compact('tanggal','count');
    }
    public function view():View
    {

        // $user = $this->user;
        $now = Carbon::parse($this->now)->format('Y-m-d');
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
        $stok = stok_obat::all();

        return view('excel.perencanaan',compact('stok','now','detail_obat_keluar','stok_obat','tanggal','count'));

    }
}
