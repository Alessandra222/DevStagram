<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PostController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }


    public function index(User $user) //Traer los post asociados al usario que se visita
    //Carga una vista específica y pasa las variables que esa vista va a necesitar para mostrar contenido dinámico.
    {
        $posts = Post::where('user_id', $user->id)->paginate(20);

        //Enviando los datos a la vista
        return view('dashboard',[
            'user'=> $user,
            'posts' => $posts
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

        // $request->user()->posts()->create([
        //     'titulo'=> $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen'=> $request->imagen,
        //     'user_id'=>auth()->user()->id
        // ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post){ //Muestra solamente un recurso
        return view('posts.show',[
            'post' => $post,
            'user' => $user

        ]);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
