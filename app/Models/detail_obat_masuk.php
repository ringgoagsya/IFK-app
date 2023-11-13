<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_obat_masuk extends Model
{
    use HasFactory;
    protected $fillable = ['id_obat_masuk','id_obat','jumlah','expired'];

    public function obat_masuk()
    {
        return $this->belongsTo(obat_masuk::class, 'id_obat_masuk', 'id');
    }

    public function obat()
    {
        return $this->belongsTo(obat::class, 'id_obat', 'id');
    }
}
