<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {

        dd($user->id);
    
        return view('dashboard',[
            'user'=> $user
        ]);
    }

    public function create() // Permite tener el formulario de tipo get para visualizar la vista
    {
        return view('posts.create');

    }

    public function store(Request $request) //Valida y guarda en la BD
    {
        $validate= $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);


        Post::create([
            'titulo'=> $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen'=> $request->imagen,
            'user_id'=>auth()->user()->id
        ]);

        //Otra forma de insertar datos en la BD
        // $post = new Post;
        // $post->titulo=$request->titulo;
        // $post->descripcion=$request->descripcion;
        // $post->imagen=$request->imagen;
        // $post->user_id= auth()->user()->id;

        $request->user()->posts()->create([
            'titulo'=> $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen'=> $request->imagen,
            'user_id'=>auth()->user()->id
        ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
