<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lplpo_puskesmas extends Model
{
    use HasFactory;
    protected $fillable = ['id_puskesmas','id_obat','permintaan','awal','penerimaan','stok_puskesmas','pemakaian','permintaan','sisa_stok','created_at'];

    public function puskesmas()
    {
        return $this->belongsTo(puskesmas::class, 'id_puskesmas', 'id');
    }

    public function obat()
    {
        return $this->belongsTo(obat::class, 'id_obat', 'id');
    }
}
