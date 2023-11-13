<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenis_keluar extends Model
{
    use HasFactory;

    public function obat_keluars()
    {
        return $this->hasMany(obat_keluar::class, 'id_jenis_keluar', 'id');
    }
}
