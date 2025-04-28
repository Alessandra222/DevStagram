<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'user_id',
        //'post_id' no se necesita ya q de la relacion lo va detectar

    ];
}
