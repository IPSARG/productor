<?php

namespace App\Http\Controllers;

use DB;
use App\Norm;
use App\NumNode;
use App\NormType;
use App\NumIndex;
use App\Parameter;
use App\RelNumNode;
use App\DocumentType;
use App\Jurisdiction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class NormTypeController extends Controller
{
    public function postNormType(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'desc_tipo_norma' => 'nullable|string',
            'id_tipo_norma' => 'required|string',
            'idjurisdiccion' => 'nullable|integer',
            'idtipodocumento' => 'nullable|integer',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $normType = new NormType();
        $normType->desc_tipo_norma = $request->desc_tipo_norma;
        $normType->id_tipo_norma = $request->id_tipo_norma;
        $normType->idjurisdiccion = $request->idjurisdiccion;
        $normType->idtipodocumento = $request->idtipodocumento;

        if($normType->save())
        {
            // save new norm type en nodonum y asigno código (tabla parametros)
            // Agarro param + 1
            $parameter = new Parameter();
            $param = $parameter->incrNodeCode('codigo_num');
            $param = $parameter->getNodeCode('codigo_num');
            // save to nodonum
            $numNode = new NumNode();
            $numNode->cod_nodo = 'A' . $param;
            $numNode->desc_nodo = $normType->desc_tipo_norma;
            if($numNode->save())
            {
                // save to indnum
                $numIndex = new NumIndex();
                $numIndex->cod_padre = 'A' . $param;
                $numIndex->cod_hijo = NULL;
                $numIndex->save();

                return redirect()->back()->with('alert-message', ['message' => 'Tipo de norma cargado con éxito', 'alert-class' => 'bg-success text-white', 'alert-type' => 'alert-fixed']);
            }else{
                return redirect()->back()->with('alert-message', ['message' => 'El Tipo de norma no se pudo cargar correctamente (nodonum)', 'alert-class' => 'bg-danger text-white', 'alert-type' => 'alert-fixed']);
            }
        }else{
            return redirect()->back()->with('alert-message', ['message' => 'El Tipo de norma no se pudo cargar correctamente (tipo_norma)', 'alert-class' => 'bg-danger text-white', 'alert-type' => 'alert-fixed']);
        }
    }

    public function searchNormType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'desc_tipo_norma' => 'nullable',
            'id_tipo_norma' => 'nullable',
            'idjurisdiccion' => 'required_without_all:desc_tipo_norma,id_tipo_norma,idtipodocumento',
            'idtipodocumento' => 'nullable'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $normTypes = NormType::join('tipodocumento', 'tipo_norma.idtipodocumento', '=', 'tipodocumento.idtipodocumento')
        ->join('jurisdicciones', 'tipo_norma.idjurisdiccion', '=', 'jurisdicciones.idjurisdiccion')
        ->where(function($query) use ($request){
            if(!is_null($request->desc_tipo_norma)){
                $query->where('tipo_norma.desc_tipo_norma', 'like', $request->desc_tipo_norma);
            }
            if(!is_null($request->id_tipo_norma)){
                $query->where('tipo_norma.id_tipo_norma', 'like', $request->id_tipo_norma);
            }
            if(!is_null($request->idjurisdiccion)){
                $query->where('tipo_norma.idjurisdiccion', $request->idjurisdiccion);
            }
            if(!is_null($request->idtipodocumento)){
                $query->where('tipo_norma.idtipodocumento', $request->idtipodocumento);
            }
        })->select('tipo_norma.*', 'tipodocumento.tipodocumento as td_name', 'jurisdicciones.siglabuscgral as j_acr')
        ->orderBy('tipo_norma.desc_tipo_norma', 'asc')
        ->get();

        return view('numeric.results.norm_types')->with(compact('normTypes'));
    }

    public function getPutNormType(Request $request, $id_tipo_norma)
    {
        $normType = NormType::where('id_tipo_norma', $id_tipo_norma)->first();
        $jurisdictions = Jurisdiction::orderBy('orden', 'asc')->get();
        $tipodocs = DocumentType::orderBy('orden', 'asc')->get();

        return view('numeric.edit_norm_type')->with(compact('normType', 'jurisdictions', 'tipodocs'));
    }

    public function putNormType(Request $request, $id_tipo_norma)
    {
        
        $validator = Validator::make($request->all(), [
            'desc_tipo_norma' => 'nullable|string',
            'id_tipo_norma' => 'required|string',
            'idjurisdiccion' => 'nullable|integer',
            'idtipodocumento' => 'nullable|integer',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $normType = new NormType();
        $normType = $normType->getNormType($id_tipo_norma);

        $normType->update([
            'desc_tipo_norma' => $request->desc_tipo_norma,
            'id_tipo_norma' => $request->id_tipo_norma,
            'idjurisdiccion' => $request->idjurisdiccion,
            'idtipodocumento' => $request->idtipodocumento
        ]);

        return redirect()->route('get.put.norm.type', ['id_tipo_norma' => $request->id_tipo_norma])->with('alert-message', ['message' => 'Norma modificada con éxito', 'alert-class' => 'bg-success text-white', 'alert-type' => 'alert-fixed']);
    }

    public function deleteNormType(Request $request, $id_tipo_norma)
    {
        // delete in numnode && indnum
        $normType = new NormType();
        $normType = $normType->getNormType($id_tipo_norma);

        $numNode = NumNode::where('desc_nodo', $normType->desc_tipo_norma)->first();
        $numIndexs = NumIndex::where('cod_padre', $numNode->cod_nodo)->get();
        foreach ($numIndexs as $numIndex)
        {
            $numIndex->delete();
        }
        $numNode->delete();

        // delete norms in normas & rel_nodo_num
        $norms = Norm::where('id_tipo_norma', $id_tipo_norma)->get();
        foreach ($norms as $norm)
        {
            // delete files if not null
            if(!is_null($norm->carpeta_texto))
            {
                $fileName = basename($norm->texto_norma);
                $fileLocation = $norm->carpeta_texto;
                $filesInEx = File::files($fileLocation);
                foreach ($filesInEx as $file) {
                    if ($fileName == basename($file)) {
                        File::delete($file);
                    }
                }
            }
            $norm->delete();
        }
        $relNumNodes = RelNumNode::where('id_tipo_norma', $id_tipo_norma)->get();
        foreach ($relNumNodes as $relNumNode)
        {
            $relNumNode->delete();
        }

        $normType->delete();

        return redirect()->back()->with('alert-message', ['message' => 'Tipo norma, normas relacionadas y archivos eliminado con éxito', 'alert-class' => 'bg-orange text-white', 'alert-type' => 'alert-fixed']);
    }
}
