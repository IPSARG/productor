<?php

namespace App\Http\Controllers;

use App\Norm;
use App\Theme;
use App\Coefic;
use App\CoeNode;
use App\NormArticle;
use App\TemNode;
use App\Dispatch;
use App\NormType;
use App\TemIndex;
use App\Parameter;
use Carbon\Carbon;
use App\RelCoeNode;
use App\RelTemNode;
use App\Jurisdiction;
use App\Helpers\IsCoefi;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;
use App\Helpers\CheckDispatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ThematicController extends Controller
{
    public function index(Request $request)
    {
        session()->flush('arrayDescNodo');
        session()->forget('main_indtem');

        $tematic = new TemIndex();
        $tematics = $tematic->getTNac();

        session()->put('main_indtem','Tributaria nacional');

        return view('thematic.index')->with(compact('tematics'));
    }

    public function getTemChild(Request $request)
    {
        $codNodo = $request->input('CodNodo');
        $descNodo = $request->input('DescNodo');
        $isPrim = $request->input('Prim');

        if($isPrim){
            session()->forget('arrayDescNodo');
            session()->forget('main_indtem');
            session()->put('main_indtem', $descNodo);
        }

        $tematic = new TemIndex();
        $tematics = $tematic->getChild($codNodo);

        if(!$isPrim)
        {
            Breadcrumb::create($request, $descNodo, $codNodo);
        }

        return view('thematic.index')->with(compact('tematics'));
    }

    public function getTemChildCoefi(Request $request)
    {
        $codNodo = $request->input('CodNodo');
        $descNodo = $request->input('DescNodo');
        $isPrim = $request->input('Prim');

        if($isPrim){
            session()->forget('arrayDescNodo');
            session()->forget('main_indtem');
            session()->put('main_indtem', $descNodo);
        }

        $tematic = new TemIndex();
        $tematics = $tematic->getChildCoefi($codNodo);
        // SI NO HAY MAS HIJOS VOY A DispatchConteoller@resultCoe
        if(count($tematics) === 0){
            return redirect()->route('get.disp.Coe', ['CodNodo' => $codNodo, 'DescNodo' => $descNodo]);
        }

        if(!$isPrim)
        {
            Breadcrumb::create($request, $descNodo, $codNodo);
        }

        return view('thematic.index')->with(compact('tematics', 'normTypes', 'temas', 'jurisdictions'));
    }

    public function postNode(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'desc_nodo' => 'required|string|max:80',
            'cod_padre' => 'required|string'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if(!IsCoefi::isCoefi($request, $request->desc_nodo))
        {
            // no es un coe
            $parameter = new Parameter();
            $param = $parameter->incrNodeCode('codigo_tem');
            $param = $parameter->getNodeCode('codigo_tem');

            $temNode = new TemNode();
            $temNode->desc_nodo = $request->desc_nodo;
            $temNode->cod_nodo = 'A' . $param;
            $temNode->fecha = Carbon::now();
            $temNode->save();

            $temIndex = new TemIndex();
            $temIndex->cod_padre = $request->cod_padre;
            $temIndex->cod_hijo = $temNode->cod_nodo;
            $temIndex->save();
        }else{
            // es un coe
            $parameter = new Parameter();
            $param = $parameter->incrNodeCode('codigo_coe');
            $param = $parameter->getNodeCode('codigo_coe');

            $coeNode = new CoeNode();
            $coeNode->desc_nodo = $request->desc_nodo;
            $coeNode->cod_nodo = 'A' . $param;
            $coeNode->fecha = Carbon::now();
            $coeNode->save();

            $coefic = new Coefic();
            // for Tablas y cuadros hay que agarrar param1 en dispatch como cod_padre
            if(!is_null($request->isTabCuad))
            {
                $dispatch = new Dispatch();
                $dispatch = Dispatch::where('codigo', $request->cod_padre)
                ->select('codigo', 'ruta', 'param1', 'param2', 'param3')
                ->first();

                if(count($dispatch) > 0)
                {
                    $coefic->cod_padre = $dispatch->param1;
                }else{
                    return redirect()->back()->with('alert-message', ['message' => 'El coeficiente no se pudo cargar', 'alert-class' => 'bg-success text-white', 'alert-type' => 'alert-fixed']);
                }
            }else{
                $coefic->cod_padre = $request->cod_padre;
            }

            $coefic->cod_hijo = $coeNode->cod_nodo;
            $coefic->save();
        }

        return redirect()->back()->with('alert-message', ['message' => 'Nodo cargado con éxito', 'alert-class' => 'bg-success text-white', 'alert-type' => 'alert-fixed']);
    }

    public function putNode(Request $request, $cod_nodo)
    {
        $validator = Validator::make($request->all(),[
            'cod_padre' => 'required|string',
            'desc_nodo' => 'required|string|max:80',

        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if(!IsCoefi::isCoefi($request, $request->desc_nodo))
        {
            $temNode = TemNode::where([
                'cod_nodo' => $request->cod_nodo,
            ])->update([
                'desc_nodo' => $request->desc_nodo
            ]);
        }else{
            $coeNode = CoeNode::where([
                'cod_nodo' => $request->cod_nodo,
            ])->update([
                'desc_nodo' => $request->desc_nodo
            ]);
        }

        return redirect()->back()->with('alert-message', ['message' => 'Nodo modificado con éxito', 'alert-class' => 'bg-info text-white', 'alert-type' => 'alert-fixed']);
    }

    public function deleteNode(Request $request, $cod_nodo)
    {
        // Agarro cod_padre e cod_hijo según param pasado
        if(!IsCoefi::isCoefi(request(), $request->desc_nodo))
        {
            $tableNodo = 'nodotem';
            $tableInd = 'indtem';
            $tableRel = 'rel_nodo_tem';
        }else{
            $tableNodo = 'nodocoe';
            $tableInd = 'coefic';
            $tableRel = 'rel_nodo_coe';
        }

        $query_one = DB::table($tableInd)->where('cod_padre', $request->cod_nodo)->orWhere('cod_hijo', $request->cod_nodo)->get();


        // Agarro cod_hijos del res de la primer query y cheques si es padre de otros hijos y agarro el hijo para eliminar el primer nivel padre/hijo
        foreach ($query_one as $one)
        {
            $hijos1[] = $one->cod_hijo;
        }
        $query_two = DB::table($tableInd)->whereIn('cod_padre', $hijos1)->orWhereIn('cod_hijo', $hijos1)->get();


        // dd($query_one,$query_two);
        // chequeo si los hijos de la segunda query son padres
        if(isset($query_two))
        foreach ($query_two as $two)
        {
            $hijos2[] = $two->cod_hijo;
            $query_three = DB::table($tableInd)->whereIn('cod_padre', $hijos2)->get();
        }

        if(isset($query_three))
        if(count($query_three) > 0)
        {
            $res = $query_three->values()->all();
        }else{
            $res = $query_two->values()->all();
        }

        // passo a null hijos de ese padre en INDTEM
        if(isset($query_two))
        foreach ($query_two as $two)
        {
            $padre[] = $two->cod_padre;
            $hijo[] = $two->cod_hijo;
        }
        if(isset($padre))
        $indtem = DB::table($tableInd)->whereIn('cod_padre', $padre)->whereIn('cod_hijo', $hijo)->delete();

        // genero array de nodos
        $nodes = [];

        if(isset($res))
        foreach ($res as $key => $node)
        {
            // dd($indtem);
            if(count($indtem) > 1)
            {
                array_push($nodes, $node->cod_padre, $node->cod_hijo);
            }else{
                array_push($nodes, $node->cod_hijo);
            }
        }

        // agarro valores unicos
        $nodes = array_values(array_unique($nodes));
        // elimino nodos en nodotem
        $temNode = DB::table($tableNodo)->whereIn('cod_nodo', $nodes)->delete();
        // elimino nodos en rel_nodo_tem
        $relNodeTem = DB::table($tableRel)->whereIn('cod_nodo', $nodes)->delete();

        return redirect()->back()->with('alert-message', ['message' => 'Nodo eliminado con éxito', 'alert-class' => 'bg-warning text-white', 'alert-type' => 'alert-fixed']);
    }


    public function updatecodoFinales(Request $re){
        // dd($codnorma,$nroorden);
        // dd($re->datos);
        $datos = [];
        if(isset($re->datos))
        $datos= json_decode($re->datos);
        $pos=1;
        // dd($datos);
        $ids=[];
        foreach($datos as $key=> $dato){
            $dato = (array)$dato;
            $norma=  NormArticle::find($dato['id']);
            if($norma == null || $dato['nuevo']==true){
                $norma= new NormArticle();
            }
            // dd($norma,$dato);
            // dd($dato['texto']);
            try {
                $norma->descarticulo=$dato['texto'];
                $norma->nivel=$dato['nivel'];
                $norma->nroorden=$pos;
                if(isset($dato['codarticulo']))
                $norma->codarticulo=$dato['codarticulo'];
                $norma->codnorma=$dato['codnorma'];
                $norma->save();
                $ids[]=$norma->id;
                $pos++;

            } catch (\Throwable $th) {
                dd($dato,$key, $re->datos[$key],$th);

                //throw $th;
            }

        }
        if(count($ids)>0){
            NormArticle::whereNotIn('id',$ids)->where('codnorma',$datos[0]->codnorma)->delete();
        }
        return "true";
//        return redirect()->back()->with('alert-message', ['message' => 'No se encontro el nodo', 'alert-class' => 'bg-warning text-white', 'alert-type' => 'alert-fixed']);


    }

    public function getLinkNorm($cod_nodo, $desc_nodo)
    {
        $normTypes = NormType::select('id_tipo_norma')->orderBy('id_tipo_norma', 'asc')->get();

        return view('thematic.linkNorm')->with(compact('cod_nodo', 'desc_nodo', 'normTypes'));
    }

    public function linkNorm(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'cod_padre' => 'required|string',
            'id_norma' => 'required|string',
            'id_tipo_norma' => 'required|string',
            'articulo' => 'nullable'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $relTemNode = new RelTemNode();
        $relTemNode->cod_nodo = $request->cod_padre;
        $relTemNode->id_norma = $request->id_norma;
        $relTemNode->id_tipo_norma = $request->id_tipo_norma;
        $relTemNode->articulo = $request->articulo;

        $relTemNode->save();

        return redirect()->back()->with('alert-message', ['message' => 'Nodo vinculado con éxito', 'alert-class' => 'bg-success text-white', 'alert-type' => 'alert-fixed']);
    }

    public function getAddCoe($cod_padre, $desc_nodo)
    {
        $cod_hijo = $cod_padre;
        $normTypes = NormType::select('id_tipo_norma')->orderBy('id_tipo_norma', 'asc')->get();

        $tema = new Theme();
        $temas = $tema->getAll();

        $jurisdiction = new Jurisdiction();
        $jurisdictions = $jurisdiction->getAll();

        return view('thematic.addCoe')->with(compact('cod_hijo', 'desc_nodo', 'normTypes', 'temas', 'jurisdictions'));
    }

    public function postCoe(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'cod_padre' => 'required|string',
            'id_norma' => 'required|string',
            'id_tipo_norma' => 'required|string',
            'desc_norma' => 'nullable|string',
            'idtema' => 'nullable|integer',
            'texto_norma' => 'nullable|file',
            'norm_folder' => 'required_with:texto_norma',
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
            $relCoeNode = new RelCoeNode();
            $relCoeNode->cod_nodo = $request->cod_padre;
            $relCoeNode->id_norma = $request->id_norma;
            $relCoeNode->id_tipo_norma = $request->id_tipo_norma;
            $relCoeNode->save();
        }else{
            return redirect()->back()->with('alert-message', ['message' => 'El coe no se pudo cargar correctamente', 'alert-class' => 'bg-danger text-white', 'alert-type' => 'alert-fixed']);
        }

        return redirect()->back()->with('alert-message', ['message' => 'Nodo vinculado con éxito', 'alert-class' => 'bg-success text-white', 'alert-type' => 'alert-fixed']);
    }

    public function putTemNorm(Request $request, $id_norma, $id_tipo_norma)
    {

        $validator = Validator::make($request->all(), [
            'id_norma' => 'required|string',
            'id_tipo_norma' => 'required|string',
            'desc_norma' => 'nullable|string',
            'fec_norma' => 'nullable|date',
            'fec_carga' => 'nullable|date',
            'idtema' => 'nullable|integer',
            'texto_norma' => 'nullable|file',
            'norm_folder' => 'required_with:texto_norma',
            'articulo' => 'nullable'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $norm = new Norm;
        $norm = $norm->getNorm($id_norma, $id_tipo_norma);

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
                    return redirect()->back()->with('alert-message', ['message' => 'Los nombres de archivo no coinciden', 'alert-class' => 'bg-danger text-white', 'alert-type' => 'alert-fixed']);
                }
            }
        }
        // UPDATE NORMAS
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

        if(!IsCoefi::isCoefi($request, $request->desc_nodo))
        {
            // UPDATE REL_NODO_TEM
            $relTemNode = RelTemNode::where(['id_norma' => $id_norma, 'id_tipo_norma' => $id_tipo_norma])
            ->update([
                'id_norma' => $request->id_norma,
                'id_tipo_norma' => $request->id_tipo_norma
            ]);
        }else{
            $relCoeNode = RelCoeNode::where(['id_norma' => $id_norma, 'id_tipo_norma' => $id_tipo_norma])
            ->update([
                'id_norma' => $request->id_norma,
                'id_tipo_norma' => $request->id_tipo_norma
            ]);
        }


        return redirect()->back()->with('alert-message', ['message' => 'Nodo modificado con éxito', 'alert-class' => 'bg-info text-white', 'alert-type' => 'alert-fixed']);
    }

    public function unlinkNode(Request $request, $id_norma, $id_tipo_norma)
    {
        if(!IsCoefi::isCoefi($request, $request->desc_nodo))
        {
            $relTemNode = RelTemNode::where(['cod_nodo' => $request->cod_nodo, 'id_norma' => $id_norma, 'id_tipo_norma' => $id_tipo_norma])->delete();
        }else{
            $relCoeNode = RelCoeNode::where(['cod_nodo' => $request->cod_nodo, 'id_norma' => $id_norma, 'id_tipo_norma' => $id_tipo_norma])->delete();
        }

        return redirect()->back()->with('alert-message', ['message' => 'Nodo desvinculado con éxito', 'alert-class' => 'bg-warning text-white', 'alert-type' => 'alert-fixed']);
    }

    public function deleteNorm(Request $request, $id_norma, $id_tipo_norma)
    {
        $norm = Norm::where(['id_norma' => $id_norma, 'id_tipo_norma' => $id_tipo_norma])->first();

        if(!IsCoefi::isCoefi($request, $request->desc_nodo))
        {
            $relNode = RelTemNode::where(['cod_nodo' => $request->cod_nodo, 'id_norma' => $id_norma, 'id_tipo_norma' => $id_tipo_norma])->first();
        }else{
            $relNode = RelCoeNode::where(['cod_nodo' => $request->cod_nodo, 'id_norma' => $id_norma, 'id_tipo_norma' => $id_tipo_norma])->first();
        }

        if(!is_null($relNode))
        {
            $relNode->delete();
        }

        $norm->delete();

        return redirect()->back()->with('alert-message', ['message' => 'Nodo eliminado con éxito', 'alert-class' => 'bg-warning text-white', 'alert-type' => 'alert-fixed']);
    }
}
