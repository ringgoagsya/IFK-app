<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class obat_keluar extends Model
{
    use HasFactory;
    protected $fillable = ['id_puskesmas','id_jenis_keluar'];

    public function detail_obat_keluar()
    {
        return $this->hasMany(detail_obat_keluar::class, 'id_obat_keluar', 'id');
    }

    public function puskesmas()
    {
        return $this->belongsTo(puskesmas::class, 'id_puskesmas', 'id');
    }

    public function jenis_keluar()
    {
        return $this->belongsTo(jenis_keluar::class, 'id_jenis_keluar', 'id');
    }
}
