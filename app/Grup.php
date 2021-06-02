<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'grup';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_grup';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_grup', 'grup_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
