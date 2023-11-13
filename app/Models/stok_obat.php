<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stok_obat extends Model
{

    protected $fillable = ['id_obat','sisa_stok','expired'];
    public function obat()
    {
        return $this->belongsTo(obat::class, 'id_obat', 'id');
    }
}
