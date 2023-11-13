<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_obat_keluar extends Model
{
    use HasFactory;
    protected $fillable = ['id_obat','id_obat_keluar','jumlah','expired','id_stok','sisa_stok'];

    public function obat_keluar()
    {
        return $this->belongsTo(obat_keluar::class, 'id_obat_keluar', 'id');
    }

    public function obat()
    {
        return $this->belongsTo(obat::class, 'id_obat', 'id');
    }

    public function Keluar_Puskesmas()
    {
        return $this->hasMany(Keluar_Puskesmas::class, 'id_detail_obat_keluar', 'id');
    }
}
