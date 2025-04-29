<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user)
    {
        //request tiene el usuario logueado
        //user tiene al usuario que estamos visitando
        //followers() -> permite acceder al método
        //followers-> a la info
        $user->followers()->attach(auth()->user()->id, ['created_at'=> Carbon::now(), 'updated_at'=> Carbon::now()]);//attach es pa N:M con la misma tabla

        return back();
    }

    public function destroy(User $user)
    {
        $user->followers()->detach(auth()->user()->id);
        return back();
    }
}
