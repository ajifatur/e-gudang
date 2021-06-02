<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'barang';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_barang';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_kantor', 'nama_barang', 'harga_jual', 'hpp', 'stok_awal', 'barang_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
