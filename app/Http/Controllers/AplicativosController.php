<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorias_Aplicativos;
use App\Aplicativos;
use App\Aplicativos_r;
use Session;
class AplicativosController extends Controller
{
    public function index(){
       $categorias= Categorias_Aplicativos::orderby('id','asc')->get();
        // dd($categorias);
        return view('aplicativos.index')->with(
            compact('categorias')
        );
    }
    public function editar($id){
        $aplicativo   = Aplicativos::find($id);
       $categorias= Categorias_Aplicativos::orderby('id','asc')->get();
        $aplicativo->opciones = $aplicativo->opciones()->get();
         return view('aplicativos.editar')->with(
             compact('aplicativo','categorias')
         );
     }

     public function actualizar(Request $request){
        // dd($request->all());
        $aplicativo = Aplicativos::find($request->id);
        $aplicativo->update([
            'titulo'=>$request->titulo,
            'novedades'=>$request->novedades,
            'descripcion'=>$request->descripcion,
            'nota'=>$request->nota,
            'categoria_id'=>$request->categoria_id
        ]);
        // dd($aplicativo);
        Aplicativos_r::where('aplicativos_id',$request->id)->delete();
            $opciones =json_decode($request->opciones);
            if($opciones != null ){
                foreach ($opciones as $key => $opcion) {
                    if($opcion !=null){

                        Aplicativos_r::create([
                            'aplicativos_id'=>$aplicativo->id,
                            'posicion'=>$opcion->posicion,
                            'titulo'=>$opcion->titulo,
                            'version'=>$opcion->version,
                            'link'=>$opcion->link,
                            ]);
                        }
                }
            }
            Session::put('alert-message', ['message' => 'Se ha actualizado el aplicativo correctamente', 'alert-class' => 'bg-success text-white', 'alert-type' => 'alert-fixed']);
            return redirect()->route('aplicativos');
     }
    public function nuevo_index(Request $request){
        // dd($request->all());
        $aplicativo = Aplicativos::create([
            'titulo'=>$request->titulo,
            'novedades'=>$request->novedades,
            'descripcion'=>$request->descripcion,
            'nota'=>$request->nota,
            'categoria_id'=>$request->categoria_id
        ]);
            $opciones =json_decode($request->opciones);
            if($opciones != null ){
                foreach ($opciones as $key => $opcion) {
                    Aplicativos_r::create([
                        'aplicativos_id'=>$aplicativo->id,
                        'posicion'=>$opcion->posicion,
                        'titulo'=>$opcion->titulo,
                        'version'=>$opcion->version,
                        'link'=>$opcion->link,
                        ]);
                }
            }
            Session::put('alert-message', ['message' => 'Se ha generado el aplicativo correctamente', 'alert-class' => 'bg-success text-white', 'alert-type' => 'alert-fixed']);
            return redirect()->route('aplicativos');

     }
    public function create(Request $r){

        Categorias_Aplicativos::create(['titulo'=>$r->titulo]);
        return redirect()->route('aplicativos');
    }
    public function delete($id){
        $aplicativo   = Aplicativos::find($id);
        $opciones = $aplicativo->opciones()->get();
        foreach($opciones as $opcion){
            $opcion->delete();
        }
        $aplicativo->delete();
        Session::put('alert-message', ['message' => 'Se ha borrado el aplicativo correctamente', 'alert-class' => 'bg-success text-white', 'alert-type' => 'alert-fixed']);
        return redirect()->route('aplicativos');
    }
    public function update($id,Request $r){
        Categorias_Aplicativos::find($id)->update(['titulo'=>$r->titulo]);
        Session::put('alert-message', ['message' => 'Se ha actualizado correctamente la categoria', 'alert-class' => 'bg-success text-white', 'alert-type' => 'alert-fixed']);
        return redirect()->route('aplicativos');
    }
}
