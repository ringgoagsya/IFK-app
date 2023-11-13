<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluarPuskesmas extends Model
{
    use HasFactory;
    protected $fillable = ['id_puskesmas','id_detail_obat_keluar','jumlah','keterangan'];

    public function detail_obat_keluar(){
        return $this->hasMany(detail_obat_keluar::class, 'id', 'id_detail_obat_keluar');
    }
}
