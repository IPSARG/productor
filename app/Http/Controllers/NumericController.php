<?php

namespace App\Http\Controllers;

use DB;
use File;
use App\Norm;
use App\Theme;
use Validator;
use App\NumNode;
use App\SitNorm;
use App\NormType;
use Carbon\Carbon;
use App\RelNumNode;
use App\DocumentType;
use App\Jurisdiction;
use Illuminate\Http\Request;

class NumericController extends Controller
{

    public function TESTING(Request $re){
        dd($re->all());
    }
    public function index()
    {

        $normType = new NormType();
        $normTypes = $normType->getAll();

        $tema = new Theme();
        $temas = $tema->getAll();

        $jurisdiction = new Jurisdiction();
        $jurisdictions = $jurisdiction->getAll();

        $tipodoc = new DocumentType();
        $tipodocs = $tipodoc->getAll();

        $norm = new Norm();
        $norms = $norm->getTodayNorms();

        $sitNorm = new SitNorm();
        $sitNorms = $sitNorm->getNorms();

        return view('numeric.index')->with(compact('sitNorms', 'norms', 'normTypes', 'temas', 'jurisdictions', 'tipodocs'));
    }

    public function postNorm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_norma' => 'required|string',
            'id_tipo_norma' => 'required|string',
            'desc_norma' => 'nullable|string',
            'fec_norma' => 'nullable|date',
            'fec_carga' => 'nullable|date',
            'idtema' => 'nullable|integer',
            'texto_norma' => 'required|file',
            'norm_folder' => 'required|string',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $documentType = NormType::where('id_tipo_norma', $request->id_tipo_norma)
        ->select('idtipodocumento', 'idjurisdiccion')
        ->first();


        $norm = new Norm();
        $norm->id_norma = $request->id_norma;
        $norm->id_tipo_norma = $request->id_tipo_norma;
        $norm->desc_norma = $request->desc_norma;
        $norm->fec_norma = $request->fec_norma;
        $norm->fec_carga = $request->fec_carga;
        $norm->fec_prod = Carbon::now();
        $norm->prod_active = 1;
        $norm->idtema = $request->idtema;
        $norm->idjurisdiccion = $documentType->idjurisdiccion;
        $norm->idtipodocumento = $documentType->idtipodocumento;

        if(!is_null($request->norm_folder))
        {
            if($request->file('texto_norma')->isValid())
            {
                $originalName = $request->file('texto_norma')->getClientOriginalName();
                $location = $request->norm_folder;
                $norm->texto_norma = $originalName;
                $norm->carpeta_texto = $location;
                $request->file('texto_norma')->move($location, $originalName);
            }
        }

        if($norm->save())
        {
            // SAVE IN rel_nodo_num
            $relNumNode = new RelNumNode();
            $relNumNode->id_norma = $norm->id_norma;
            $relNumNode->id_tipo_norma = $norm->id_tipo_norma;

            // GET dedc_tipo_norma BY id_tipo_norma && GET cod_nodo BY desc_tipo_norma
            $normType = new NormType();
            $normTypeDesc = $normType->getNormType($norm->id_tipo_norma);
            $numNode = new NumNode();
            $numNode = $numNode->getCodNodeByDesc($normTypeDesc->desc_tipo_norma);

            $relNumNode->cod_nodo = $numNode->cod_nodo;
            if($relNumNode->save())
            {
                return redirect()->back()->with('alert-message', ['message' => 'Norma cargada con éxito', 'alert-class' => 'bg-success text-white', 'alert-type' => 'alert-fixed']);
            };
        }else{
            return redirect()->back()->with('alert-message', ['message' => 'La Norma no se pudo cargar correctamente', 'alert-class' => 'bg-danger text-white', 'alert-type' => 'alert-fixed']);
        }
    }

    public function getPutNorm(Request $request, $id_norma, $id_tipo_norma)
    {
        $normType = new NormType();
        $normTypes = $normType->getAll();

        $tema = new Theme();
        $temas = $tema->getAll();

        $norm = new Norm;
        $norm = $norm->getNorm($id_norma, $id_tipo_norma);

        return view('numeric.edit_norm')->with(compact('norm', 'normTypes', 'temas'));
    }

    public function putNorm(Request $request, $id_norma, $id_tipo_norma)
    {
        $norm = new Norm;
        $norm = $norm->getNorm($id_norma, $id_tipo_norma);

        $validator = Validator::make($request->all(), [
            'id_norma' => 'required|string',
            'id_tipo_norma' => 'required|string',
            'desc_norma' => 'nullable|string',
            'fec_norma' => 'nullable|date',
            'fec_carga' => 'nullable|date',
            'idtema' => 'nullable|integer',
            'texto_norma' => 'nullable|file',
            'norm_folder' => 'required_with:texto_norma'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $documentType = NormType::where('id_tipo_norma', $request->id_tipo_norma)
        ->select('idtipodocumento', 'idjurisdiccion')
        ->first();

        if(!is_null($request->file('texto_norma')))
        {
            if($request->file('texto_norma')->isValid())
            {
                $originalName = $request->file('texto_norma')->getClientOriginalName();
                // El nombre tiene que ser el mismo
                if($originalName == $norm->texto_norma)
                {
                    // si cambian carpeta borro el file anterior
                    if($norm->carpeta_texto !== $request->norm_folder)
                    {
                        $fileName = basename($norm->texto_norma);
                        $fileLocation = !is_null($norm->carpeta_texto) ? $norm->carpeta_texto : $request->norm_folder;
                        $filesInEx = File::files($fileLocation);
                        foreach ($filesInEx as $file) {
                            if ($fileName == basename($file)) {
                                File::delete($file);
                            }
                        }
                    }

                    $location = $request->norm_folder;
                    $norm->update([
                        'texto_norma' => $originalName,
                        'carpeta_texto' => $location
                    ]);
                    $request->file('texto_norma')->move($location, $originalName);
                }else{
                    return redirect()->route('get.put.norm', ['id_norma' => $request->id_norma, 'id_tipo_norma' => $request->id_tipo_norma])->with('alert-message', ['message' => 'Los nombres de archivo no coinciden', 'alert-class' => 'bg-danger text-white', 'alert-type' => 'alert-fixed']);
                }
            }
        }

        // for updating only location
        if(is_null($request->file('texto_norma')) && !is_null($request->file('carpeta_texto')))
        {
            $norm->update(['carpeta_texto' => $request->carpeta_texto]);
        };

        $norm->update([
            'id_norma' => $request->id_norma,
            'id_tipo_norma' => $request->id_tipo_norma,
            'desc_norma' => $request->desc_norma,
            'fec_norma' => $request->fec_norma,
            'fec_carga' => $request->fec_carga,
            'idtema' => $request->idtema,
            'idjurisdiccion' => $documentType->idjurisdiccion,
            'idtipodocumento' => $documentType->idtipodocumento
        ]);

        return redirect()->route('get.put.norm', ['id_norma' => $request->id_norma, 'id_tipo_norma' => $request->id_tipo_norma])->with('alert-message', ['message' => 'Norma modificada con éxito', 'alert-class' => 'bg-success text-white', 'alert-type' => 'alert-fixed']);
    }

    public function deactiveNorm(Request $request, $id_norma, $id_tipo_norma)
    {
        $norm = new Norm;
        $norm = $norm->getNorm($id_norma, $id_tipo_norma);

        $norm->update([
            'prod_active' => 0,
        ]);

        return redirect()->back();
    }

    public function deleteNorm(Request $request)
    {
        $norm = new Norm;
        $norm = $norm->getNorm($request->id_norma, $request->id_tipo_norma);

        // Delete from rel_nodo_num
        $relNumNode = new RelNumNode();
        $relNumNode = $relNumNode->getNorm($request->id_norma, $request->id_tipo_norma);
        $relNumNode->delete();

        // delete archive and norm (if not null texto_norma)
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
            $norm->delete();

            return redirect()->back()->with('alert-message', ['message' => 'Norma y archivo eliminados con éxito', 'alert-class' => 'bg-orange text-white', 'alert-type' => 'alert-fixed']);
        }

        $norm->delete();

        return redirect()->back()->with('alert-message', ['message' => 'Norma eliminada con éxito. No se pudo eliminar el archivo', 'alert-class' => 'bg-orange text-white', 'alert-type' => 'alert-fixed']);
    }

    public function deleteNormArchive($texto_norma)
    {
        $norm = new Norm;
        $norm = $norm->getNormByArchive($texto_norma);

        $fileName = basename($norm->texto_norma);
        $fileLocation = $norm->carpeta_texto;
        if(!is_null($fileLocation))
        {
            $filesInEx = File::files($fileLocation);
            foreach ($filesInEx as $file) {
                if ($fileName == basename($file)) {
                    File::delete($file);
                }
            }

            $norm->update(['carpeta_texto' => null]);

            return redirect()->back()->with('alert-message', ['message' => 'Archivo físico y ruta eliminados con éxito', 'alert-class' => 'bg-orange text-white', 'alert-type' => 'alert-fixed']);
        }
        return redirect()->back()->with('alert-message', ['message' => 'Archivo no encondrado. Ruta no especificada', 'alert-class' => 'bg-danger text-white', 'alert-type' => 'alert-fixed']);
    }

    public function searchNorms(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_norma' => 'nullable',
            'id_tipo_norma' => 'required_without_all:id_norma,fec_norma,fec_carga,texto_norma',
            'texto_norma' => 'nullable',
            'fec_norma' => 'nullable',
            'fec_carga' => 'nullable',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $norms = Norm::join('tipo_norma', 'normas.id_tipo_norma', '=', 'tipo_norma.id_tipo_norma')
        ->join('jurisdicciones', 'tipo_norma.idjurisdiccion', '=', 'jurisdicciones.idjurisdiccion')
        ->where(function($query) use ($request){
            if(!is_null($request->id_norma)){
                if($this->checkIfSlash($request->id_norma)){
                    $number = explode('/', $request->id_norma);
                    $number = $number[0].'/'.$number[1];
                    $query->where('normas.id_norma', 'like', $number.'%');
                }else{
                    $number = $request->id_norma;
                    $query->where('normas.id_norma', '=', $number);
                    $query->orWhere('normas.id_norma', 'like', $number. '/' . '%');
                }
            }
            if(!is_null($request->id_tipo_norma)){
                $query->where('normas.id_tipo_norma', $request->id_tipo_norma);
            }
            if(!is_null($request->texto_norma)){
                $query->where('normas.texto_norma', $request->texto_norma);
            }
            if(!is_null($request->fec_carga)){
                $query->whereDate('normas.fec_carga', $request->fec_carga);
            }
            if(!is_null($request->fec_norma)){
                $query->whereDate('normas.fec_norma', $request->fec_norma);
            }
        })->select('normas.*', 'tipo_norma.id_tipo_norma as nt_id', 'tipo_norma.desc_tipo_norma as nt_desc', 'jurisdicciones.siglabuscgral as j_acr')
        ->orderBy('fec_carga', 'desc')
        ->paginate(20);

        return view('numeric.results.norms')->with(compact('norms'));
    }

    public function checkIfSlash($norm_number)
    {
        if(strpos($norm_number, '/') !== false){
            return true;
        }
        return false;
    }
}
