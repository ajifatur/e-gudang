<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stok';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_stok';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_barang', 'stok_awal', 'pembelian', 'terjual', 'sisa', 'selisih', 'stok_akhir', 'bulan', 'tahun', 'stok_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
