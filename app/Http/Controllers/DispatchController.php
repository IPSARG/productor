<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Norm;
use App\Theme;
use App\TrvDoc;
use App\TrvTax;
use App\NormType;
use App\TrvDocType;
use App\NormArticle;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DispatchController extends Controller
{

    public function resultNCl(Request $request)
    {
        $descNodo = $request->DescNodo;
        $codNodo = $request->codNodo;

        $tematics = Norm::join('tipo_norma', 'normas.id_tipo_norma', '=', 'tipo_norma.id_tipo_norma')
        ->where(function($query) use($descNodo){
            $this->descNodoToIdTipoNorma($descNodo, $query);
        })
        ->select('normas.id_norma', 'normas.id_tipo_norma','normas.desc_norma', 'normas.fec_norma','normas.texto_norma as text_norm', 'normas.idtipodocumento', 'tipo_norma.desc_tipo_norma')
        ->orderBy('tipo_norma.desc_tipo_norma', 'asc')
        ->orderBy('normas.fec_norma', 'desc')
        ->orderBy('normas.id_norma', 'desc')
        ->paginate(12);

        $normType = new NormType();
        $normTypes = $normType->getAll();

        $tema = new Theme();
        $temas = $tema->getAll();

        Breadcrumb::create($request, $descNodo, $codNodo);

        return view('thematic.results.general')->with(compact('tematics', 'normTypes', 'temas'));
    }

    public function resultCl(Request $request)
    {
        $codNodo = $request->CodNodo;
        $descNodo = $request->DescNodo;

        $tematics = Norm::join('rel_nodo_tem', 'rel_nodo_tem.id_norma', '=', 'normas.id_norma')
        ->join('tipo_norma', 'normas.id_tipo_norma', '=', 'tipo_norma.id_tipo_norma')
        ->whereColumn('rel_nodo_tem.id_tipo_norma', '=', 'normas.id_tipo_norma')
        ->where('rel_nodo_tem.cod_nodo', $codNodo)
        ->select('normas.id_norma','normas.id_tipo_norma','normas.texto_norma as text_norm','normas.fec_norma','normas.desc_norma', 'tipo_norma.desc_tipo_norma', 'rel_nodo_tem.cod_nodo', 'rel_nodo_tem.articulo')
        ->orderBy('tipo_norma.desc_tipo_norma', 'asc')
        ->orderBy('normas.fec_norma', 'desc')
        ->orderBy('normas.id_norma', 'desc')
        ->paginate(12);

        $normType = new NormType();
        $normTypes = $normType->getAll();

        $tema = new Theme();
        $temas = $tema->getAll();

        Breadcrumb::create($request, $descNodo, $codNodo);

        return view('thematic.results.general')->with(compact('tematics', 'normTypes', 'temas'));
    }

    public function resultCoe(Request $request)
    {
        $codNodo = $request->CodNodo;
        $descNodo = $request->DescNodo;

        $tematics = Norm::join('rel_nodo_coe', 'rel_nodo_coe.id_norma', '=', 'normas.id_norma')
        ->join('tipo_norma', 'normas.id_tipo_norma', '=', 'tipo_norma.id_tipo_norma')
        ->whereColumn('rel_nodo_coe.id_tipo_norma', '=','normas.id_tipo_norma')
        ->where('rel_nodo_coe.cod_nodo', $codNodo)
        ->select('normas.id_norma','normas.id_tipo_norma','normas.texto_norma as text_norm','normas.fec_norma', 'normas.fec_carga', 'normas.desc_norma', 'tipo_norma.desc_tipo_norma', 'rel_nodo_coe.cod_nodo')
        ->orderBy('normas.fec_carga', 'desc')
        ->paginate(12);

        Breadcrumb::create($request, $descNodo, $codNodo);

        $normType = new NormType();
        $normTypes = $normType->getAll();

        $tema = new Theme();
        $temas = $tema->getAll();

        return view('thematic.results.general')->with(compact('tematics', 'normTypes', 'temas'));
    }

    public function resultCap(Request $request)
    {
        $codNodo = $request->CodNodo;
        $descNodo = $request->DescNodo;

        $codNorma = $request->get('codnorma');

        $tematics = NormArticle::join('trvnorma', function($join) use ($codNorma){
            $join->on('trvarticulonorma.codnorma', '=', 'trvnorma.codnorma')
                 ->where('trvnorma.codnorma', '=', $codNorma);
        })
        ->join('normas', 'trvnorma.nombrehtm', '=', 'normas.texto_norma')
        ->join('tipo_norma', 'tipo_norma.id_tipo_norma', '=', 'normas.id_tipo_norma')
        ->select('trvarticulonorma.codnorma','trvarticulonorma.nroorden', 'trvarticulonorma.nivel','trvarticulonorma.bold', 'trvarticulonorma.codarticulo','trvarticulonorma.descarticulo', 'trvarticulonorma.voces', 'trvnorma.nombrehtm', 'normas.texto_norma as text_norm', 'tipo_norma.desc_tipo_norma', 'normas.id_norma','normas.id_tipo_norma','trvarticulonorma.id as id')
        ->orderBy('trvarticulonorma.nroorden', 'asc')
        ->get();
        // dd($tematics->where('nivel',9)->first());
        $first = $tematics->first();
        $mayLvlFirst = ['0','1','3'];
        if(is_int($first->nivel) || $first->nivel != null){
            $firstDescArt = $first;
        }

        // dd($tematics->take(15),$firstDescArt);
        // RETRIEVE FIRST NUMBER BIGGER THEN 0 BUT SMALLER THEN 9 (IN ORDER TO COMPARE IN VIEW)
        $firstLvl = null;
        foreach ($tematics as $tematic) {
            if($firstLvl === null){
                // SI QUEDA NULL ES PORQUÉ NO HAY REGISTRO CON NIVEL ENTRE 2 Y 8
                foreach($mayLvlFirst as $lvl){
                    if($firstDescArt->nivel == $lvl){
                        if($tematic->nivel > $lvl && $tematic->nivel < 9){
                            $firstLvl = $tematic->nivel;
                        }
                    }
                }
            }
        }
        // dd($firstDescArt,$tematics->where('nivel','!=',0)->take(10),$firstLvl);
        // $firstLvl=1;
        // dd($firstDescArt,$firstLvl);

        $count = 0;

        Breadcrumb::create($request, $descNodo, $codNodo);

        return view('thematic.results.capitulated')->with(compact('tematics','firstDescArt', 'firstLvl', 'count'));

    }

    public function getTopicsCovered(Request $request)
    {
        $codNodo = $request->CodNodo;
        $descNodo = $request->DescNodo;

        $topicsArray = [];
        $topics = TrvTax::join('trvdocum', 'trvimpuesto.codimpuesto', '=', 'trvdocum.codimpuesto')
        ->whereIn('trvdocum.tipodoc', [4,5,6,7,8,9,11,12,20])
        ->select('trvimpuesto.codimpuesto')
        ->distinct()
        ->get();

        foreach($topics as $topic){
            array_push($topicsArray, $topic->codimpuesto);
        }

        $tipodoc = $request->input('tipodoc');
        $codimpuesto = $request->input('codimpuesto');

        $tematics = TrvDoc::join('trvimpuesto', 'trvdocum.codimpuesto', '=', 'trvimpuesto.codimpuesto')
        ->join('trvtipodoc', 'trvdocum.tipodoc', '=', 'trvtipodoc.tipodoc')
        ->where(function($query) use ($request, $topicsArray, $codimpuesto, $tipodoc){
            //  ACTIVIDAD
            if($tipodoc != 0){
                $query->where('trvdocum.tipodoc', $tipodoc);
            }
            if($tipodoc == 0){
                $query->whereIn('trvdocum.tipodoc',[4,5,6,7,8,9,11,12,20]);
            }
            // TEMAS
            if($codimpuesto != 0){
                $query->where('trvdocum.codimpuesto', $codimpuesto);
            }
            if($codimpuesto == 0){
                $query->whereIn('trvdocum.codimpuesto', $topicsArray);
            }
        })
        ->orderBy('trvimpuesto.descimpuesto')
        ->orderBy('trvtipodoc.desctipodoc')
        ->orderBy('anio', 'desc')
        ->orderBy('mes', 'desc')
        ->select('trvimpuesto.descimpuesto', 'trvtipodoc.desctipodoc', 'trvdocum.coddocum', 'trvdocum.anio', 'trvdocum.mes', 'trvdocum.descripcion', 'trvdocum.nombredochtm')
        ->get();

        // Nombre tema elegido
        $codimpuestoDesc = TrvTax::where('codimpuesto', $codimpuesto)->select('descimpuesto')->first();

        if($tematics->isEmpty()){
            Session::flash('error','Ningún resultado encontrado relativo a su búsqueda');
            return redirect()->back()->withInput();
        }

        Breadcrumb::create($request, $descNodo, $codNodo);

        return view('thematic.results.conferences')->with(compact('tematics', 'codimpuestoDesc'));
    }

    public function createQuery($query, $tabla, $columna, $operator = null, $idTipoNorma, $percent = null, $multiple = null)
    {
        // INCLUYE LA DESCR EN BUSQUEDA (I) O NO (E)
        // QUE INCLUIR O NO EN BUSQUEDA
        if(session()->has('arrayRelSearch')){
            $relSearches= session()->get('arrayRelSearch');
            // GUARDO LAS DESCRIPCIONES A INCLUIR O EXCLUIR
            $busDescs = [];
            foreach ($relSearches as $relSearch) {
                array_push($busDescs, $relSearch['busDesc']);
            }
            //  SI HAY QUE INCLUIR (LIKE)
            if($relSearch['inclusion'] == 'I'){
                $query->where(function($query) use($busDescs){
                    foreach ($busDescs as $busDesc) {
                        // $stmt =
                        $query->orWhere('normas.desc_norma', 'LIKE', '%' . $busDesc . '%');
                    }
                });
            //  SI HAY QUE EXCLUIR (NOT LIKE)
            }elseif ($relSearch['inclusion'] == 'E') {
                $query->where(function($query) use($busDescs){
                    foreach ($busDescs as $busDesc) {
                        // $stmt =
                        $query->orWhere('normas.desc_norma', 'NOT LIKE', '%' . $busDesc . '%');
                    }
                });
            }
            // $stmt->where(function ($query) use ($relSearch, $percent, $multiple, $tabla, $columna, $operator, $idTipoNorma){ });
            if($percent != null  && $multiple == null){
                $query->where($tabla . '.' . $columna, $operator, $idTipoNorma . $percent);
            }elseif($percent != null  && $multiple != null){
                if($multiple == 'res'){
                    $query->where($tabla . '.' . $columna, $operator, $idTipoNorma . $percent)
                            ->orWhere('tipo_norma.desc_tipo_norma', 'LIKE', 'rc.'.'%');
                }
                if($multiple == 'otros'){
                    $query->where($tabla . '.' . $columna, $operator, $idTipoNorma . $percent)
                    ->where('tipo_norma.desc_tipo_norma', 'NOT LIKE', 'Res.'.'%')
                    ->where('tipo_norma.desc_tipo_norma', 'NOT LIKE', 'Dict.'.'%')
                    ->where('tipo_norma.desc_tipo_norma', 'NOT LIKE', 'L.'.'%')
                    ->where('tipo_norma.desc_tipo_norma', 'NOT LIKE', 'Dto.'.'%')
                    ->where('tipo_norma.desc_tipo_norma', 'NOT LIKE', 'Jurisprudencia');
                }
            }else{
                $query->where($tabla . '.' . $columna, $operator, $idTipoNorma);
            }
        }elseif(session()->has('relSearch')){
            $relSearch= session()->get('relSearch');
            if($relSearch['inclusion'] == 'I'){
                $stmt = $query->where('normas.desc_norma', 'LIKE', '%' . $relSearch['busDesc']  . '%');
            }elseif($relSearch['inclusion']  == 'E'){
                $stmt = $query->where('normas.desc_norma', 'NOT LIKE', '%' . $relSearch['busDesc']  . '%');
            }
            $stmt->where(function ($query) use ($relSearch, $percent, $multiple, $tabla, $columna, $operator, $idTipoNorma){
                if($percent != null  && $multiple == null){
                    $query->where($tabla . '.' . $columna, $operator, $idTipoNorma . $percent);
                }elseif($percent != null  && $multiple != null){
                    if($multiple == 'res'){
                        $query->where($tabla . '.' . $columna, $operator, $idTipoNorma . $percent)->orWhere('tipo_norma.desc_tipo_norma', 'LIKE', 'rc.'.'%');
                    }
                    if($multiple == 'otros'){
                        $query->where($tabla . '.' . $columna, $operator, $idTipoNorma . $percent)
                        ->where('tipo_norma.desc_tipo_norma', 'NOT LIKE', 'Res.'.'%')
                        ->where('tipo_norma.desc_tipo_norma', 'NOT LIKE', 'Dict.'.'%')
                        ->where('tipo_norma.desc_tipo_norma', 'NOT LIKE', 'L.'.'%')
                        ->where('tipo_norma.desc_tipo_norma', 'NOT LIKE', 'Dto.'.'%')
                        ->where('tipo_norma.desc_tipo_norma', 'NOT LIKE', 'Jurisprudencia');
                    }
                }else{
                    $query->where($tabla . '.' . $columna, $operator, $idTipoNorma);
                }
            });
        }
    }

    public function descNodoToIdTipoNorma($descNodo, $query)
    {
        switch ($descNodo) {
            case 'Leyes':
                $this->createQuery($query, 'tipo_norma','desc_tipo_norma', '=', 'L.', null, false);
            break;
            case 'Decretos':
                $this->createQuery($query, 'tipo_norma','desc_tipo_norma', '=', 'Dto.', null, false);
            break;
            case 'Dictámenes':
                $this->createQuery($query, 'tipo_norma', 'desc_tipo_norma', 'LIKE', 'Dict.', '%', false);
            break;
            case 'Resoluciones':
                $this->createQuery($query, 'tipo_norma','desc_tipo_norma', 'LIKE', 'res.', '%', 'res');
            break;
            case 'Otros':
                $this->createQuery($query,'tipo_norma','desc_tipo_norma', 'NOT LIKE','res.', '%', 'otros');
            break;
            case 'Jurisprudencia':
                $this->createQuery($query, 'tipo_norma', 'desc_tipo_norma', '=', 'Jurisprudencia', null, false);
            break;
            case 'Dictámenes AFIP DAL':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'DICTDAL', null, false);
            break;
            case 'Doctrina':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'Todos', null, false);
            break;
            case 'Dictámenes AFIP DALTT':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'DICTDALT', null, false);
            break;
            case 'Dictámenes AFIP DAT':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'DICTDAT', null, false);
            break;
            case 'Dictámenes AFIP DATyJ':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'DICTDATJ', null, false);
            break;
            case 'Dictámenes DGI DLTRSS':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'DICTDLTR', null, false);
            break;
            case 'Dictámenes DiALIR':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'DICTDIALIR', null, false);
            break;
            case 'Dictámenes PTN':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'DICTPTN', null, false);
            break;
            case 'AFIP':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'RGAFIP', null, false);
            break;
            case 'DGR (GCBA)':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'RESDGRGCBA', null, false);
            break;
            case 'ANSES':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'RESANSES', null, false);
            break;
            case 'MEyOySP':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'RMEYOYSP', null, false);
            break;
            case 'DGI':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'RESOLUC', null, false);
            break;
            case 'Interp. CFI':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'RGINTERP', null, false);
            break;
            case 'SH':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'RESSH', null, false);
            break;
            case 'Instrucciones DATyJ':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'IDATYJ', null, false);
            break;
            case 'Nota Externa DGI':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'NEXTDGI', null, false);
            break;
            case 'Nota Externa AFIP':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'NEXTAFIP', null, false);
            break;
            case 'Circular DGI':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'CIRCULAR', null, false);
            break;
            case 'Dto. Pres. (HSN)':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'DTOPRES', null, false);
            break;
            case 'Res.SH':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'RESSH', null, false);
            break;
            case 'Casos Prácticos':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'CASOPRAC', null, false);
            break;
            case 'Colaboraciones Técnicas':
                $this->createQuery($query, 'normas', 'id_tipo_norma', '=', 'COLABTEC', null, false);
            break;
        }
    }
}

