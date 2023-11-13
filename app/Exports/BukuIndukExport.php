<?php

namespace App\Exports;

namespace App\Exports;

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
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class BukuIndukExport implements FromView,ShouldAutoSize
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
    public function view() :View
    {

        // $user = $this->user;
        $now = Carbon::parse($this->now)->format('Y-m-d');
        $day = Carbon::parse($this->now)->format('d');
        $month = Carbon::parse($this->now)->format('m');
        $year = Carbon::parse($this->now)->format('Y');

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
            return view('excel.bukustokinduk',compact('total_masuk','total_keluar','month','now','obat','puskesmas','detail_obat_keluar','detail_obat_masuk','count_puskesmas','obat_masuk','obat_keluar','count_obat','puskes','tanggal','count','mmont'));
        }
}
