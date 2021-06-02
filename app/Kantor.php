<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kantor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kantor';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_kantor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_grup', 'nama_kantor', 'kantor_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
