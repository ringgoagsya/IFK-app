<?php

namespace App\Exports;

use App\Models\lplpo_puskesmas;
use App\Models\KeluarPuskesmas;
use Illuminate\Http\Request;
use App\Models\obat;
use App\Models\stok_obat;
use App\Models\detail_obat_keluar;
use App\Models\obat_keluar;
use App\Models\puskesmas;
use App\Models\jenis_keluar;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class LplpoExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($now,$user)
    {
        $this->now = $now;
        $this->user = $user;
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
    // public function styles(Worksheet $sheet)
    // {

    //     $sheet->setAutoSize(true);
    //     // $sheet->getStyle('B2')->getFont()->setBold(true);
    // }
    public function view():View
    {

        $puskesmas_all = puskesmas::all();
        $user = $this->user ;
        $now = Carbon::parse($this->now)->format('Y-m-d');
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

        return view('excel.lplpoexcel',compact('awal','lplpo_puskesmas','keluar_puskesmas','persediaan_awal','mmont','now','detail_obat_keluar','obat_keluar','obat','tanggal','count'));

    }
}
