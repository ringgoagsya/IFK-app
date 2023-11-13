<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class puskesmas extends Model
{
    use HasFactory;
    protected $fillable = [
        'kepala_puskesmas',
        'nip_kapus',
        'pengelola',
        'nip_pengelola',
        'nama_puskesmas',
        'slug',
        'alamat',
        'no_telp',
    ];
    /**
     * Get all of the puskesmass for the puskesmas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function obat_keluar()
    {
        return $this->hasMany(obat_keluar::class, 'id_puskesmas', 'id');
    }

    public function lplpo_puskesmas()
    {
        return $this->hasMany(lplpo_puskesmas::class, 'id_puskesmas', 'id');
    }
    public function User()
    {
        return $this->hasOne(User::class, 'id_pus', 'id');
    }
}
