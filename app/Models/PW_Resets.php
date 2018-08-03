<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PW_Resets extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pw_reset_token';
    protected $primaryKey = null;
    public $timestamps = false;
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'token', 'created_at', 'expired_at',
    ];
}
