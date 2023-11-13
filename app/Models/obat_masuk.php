<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class obat_masuk extends Model
{
    use HasFactory;
    protected $fillable = ['id_pemasok','jenis_surat_masuk','no_batch'];


    public function detail_obat_masuk()
    {
        return $this->hasMany(detail_obat_masuk::class, 'id_obat_masuk', 'id');
    }

    public function pemasok()
    {
        return $this->belongsTo(pemasok::class, 'id_pemasok', 'id');
    }

}
