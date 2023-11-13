<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemasok extends Model
{
    use HasFactory;
    protected $fillable = ['nama_pemasok','lokasi'];
    /**
     * Get all of the obat_masuks for the pemasok
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function obat_masuk()
    {
        return $this->hasMany(obat_masuk::class, 'id_pemasok', 'id');
    }
}
