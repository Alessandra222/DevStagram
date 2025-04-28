<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'comentario'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
