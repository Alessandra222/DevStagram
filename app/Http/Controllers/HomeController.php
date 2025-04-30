<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function __invoke() //Controlador que solo tiene un método
    {
       //obtener a quienes seguimos
       //pluck solo nos trae ciertos campos
       $ids =auth()->user()->followings->pluck('id')->toArray();
       //primero ordena y luego pagina
       $posts= Post::whereIn('user_id',$ids)->latest()->paginate(20);

       return view('home' , [ //pasarle la info a la vista
            'posts' => $posts
       ]); 

    }
}
