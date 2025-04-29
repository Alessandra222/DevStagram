<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;  

class PerfilController extends Controller
{
    //todas las rutas manejadas por este controlador requieran que el usuario esté logueado.
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('perfil.index');

    }

    public function store(Request $request)
    {
        $request->request->add(['username' => Str::slug($request->username)
        ]);

        $validated = $request->validate([
            'username' => ['required',Rule::unique('users', 'username')->ignore(auth()->user()),'min:3','max:20', 'not_in:twitter,editar-perfil'],
            'email' =>['required',Rule::unique('users','email')->ignore(auth()->user()),'email','max:60'],
        ]);

        $usuario=User::find(auth()->user()->id); 
        if ($request->filled('current_password')) {

            if (!Hash::check($request->current_password, $usuario->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
            }
            
            $validated = $request->validate([
                'password' => 'required|confirmed|min:6'
            ]);
    
            // Si todo está bien, actualizamos la contraseña
            $usuario->password =$request->password;
        }

        if($request->imagen)
        {
            $imagen = $request->file('imagen');
 
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
            $manager = new ImageManager(new Driver()); // Instancia el manager
            $imagenServidor = $manager->read($imagen); // Lee la imagen
            $imagenServidor->resize(1000, 1000);       // Le hace el resize 
    
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);

        }

        //Guardar Cambio
        $usuario->username=$request->username;
        $usuario->email=$request->email;
        $usuario->imagen=$nombreImagen ?? auth()->user()->imagen ?? '';
        $usuario->save();

        //Redireccionar
        return redirect()->route('posts.index', $usuario->username);
        
        
    }
}
