<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class obat extends Model
{
    use HasFactory;

    protected $fillable = ['nama_obat','satuan','satuan_puskesmas'];
    public function stok_obat()
    {
        return $this->hasMany(stok_obat::class, 'id_obat', 'id');
    }

    public function detail_obat_masuk()
    {
        return $this->hasMany(detail_obat_masuk::class, 'id_obat', 'id');
    }

    public function detail_obat_keluar()
    {
        return $this->hasMany(detail_obat_keluar::class, 'id_obat', 'id');
    }

    public function lplpo_puskesmas()
    {
        return $this->hasMany(lplpo_puskesmas::class, 'id_obat', 'id');
    }
}
