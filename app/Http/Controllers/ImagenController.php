<?php
namespace App\Http\Controllers;
 
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;         
use Intervention\Image\Drivers\Gd\Driver;    
 
class ImagenController extends Controller
{
    //
    public function store(Request $request) {
        $imagen = $request->file('file');
 
        $nombreImagen = Str::uuid() . "." . $imagen->extension();
 
        $manager = new ImageManager(new Driver()); // Instancia el manager
        $imagenServidor = $manager->read($imagen); // Lee la imagen
        $imagenServidor->resize(1000, 1000);       // Le hace el resize 
 
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        $imagenServidor->save($imagenPath);
 
        return response()->json(['imagen' => $nombreImagen]);
    }
}
