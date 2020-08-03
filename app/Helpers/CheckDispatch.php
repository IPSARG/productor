<?php

namespace App\Helpers;

use Session;
use App\RelSearch;
use Carbon\Carbon;

class CheckDispatch {

    protected $response;
    protected $codNodo;
    protected $descNodo;
    protected $codImpuesto;
    protected $codNorma;
    protected $normFileName;
    protected $codPadre;
    protected $ruta;
    protected $now;

    public function __construct($response)
    {
        $this->now = Carbon::now();
        $this->response = $response;
        
        $this->checkDispatch();

    }

    public function checkDispatch()
    {
        $this->ruta = isset($this->response->ruta) ? $this->response->ruta : null;
        $this->codNodo = isset($this->response->codigo) ? $this->response->codigo : null;

        if(\Request::has('DescNodo')){
            $this->descNodo = \Request::query('DescNodo');
        }

        switch ($this->ruta) {
            case null:
                $this->codNodo = \Request::query('CodNodo');
                // REDIRECCIONO A DispatchController 
                header('location:'. route('get.disp.Cl', ['CodNodo' => $this->codNodo, 'DescNodo' => $this->descNodo]));
                exit;
            break;
            case 'Bib':
                $this->codImpuesto = $this->response->param1;
                // REDIRECCIONO A DispatchController 
                header('location:'. route('get.topics.covered', ['codimpuesto' => $this->codImpuesto, 'DescNodo' => $this->descNodo, 'bus_mat' => true]));
                exit;
            break;
            case 'Buscar':
                $this->codImpuesto = $this->response->param1;
                $this->getBusquedaRel($this->codImpuesto);

                header('location:'. route('get.disp.NCl', ['CodNodo' => $this->codNodo, 'DescNodo' => $this->descNodo]));
                exit;
            break;
            case 'Cambiar':
                $this->codNodo = $this->response->param1;
                // la ruta "Cambiar" es la que tiene a todos los nodos que se llaman "Tablas y Cuadros" => Coefi 
            break;
            case 'TextoCapitulado':
                $this->codImpuesto = $this->response->param1;
                $this->codNorma = $this->response->param2;
                // if(!\Route::is('subject.search.legis')){
                //     $this->getBusquedaRel($this->codImpuesto);
                // }
                header('location:'. route('get.disp.cap', ['CodNodo' => $this->codNodo, 'Codimpuesto' => $this->codImpuesto, 'codnorma' => $this->codNorma, 'DescNodo' => $this->descNodo]));
                exit;
            break;
            case 'Ven':
                $this->codImpuesto = $this->response->param1;

                header('location: http://z0741.cponline.org.ar:8081/calendario/calendario?event=busquedaTitulo&cboJurisdicciones=0&cboImpuestos=' . $this->codImpuesto . '&cboAnio=' . $this->now->year . '&cboMes=' . $this->now->month . '&cboSemana=0&volver=2');
                exit;
            break;
            case 'VenP':
                $this->codImpuesto = $this->response->param1;
                
                header('location: http://z0741.cponline.org.ar:8081/calendario/calendario?event=busquedaTitulo&cboJurisdicciones='. $this->codImpuesto .'&cboImpuestos=0&cboAnio=' . $this->now->year . '&cboMes=' . $this->now->month . '&cboSemana=0&volver=2');
                exit;
            break;
        }
    }

    public function getBusquedaRel($codImpuesto)
    {
        // PASO POR TRVBUSQUEDAREL
        $relSearches = new RelSearch();
        $relSearches = $relSearches->getForImpCode($codImpuesto);
        // GUARDO LOS RESULTADOS EN VARIABLE DE SESSION
        $this->storeInSession($relSearches);
    }

    public function storeInSession($relSearches)
    {
        session()->forget('arrayRelSearch');
        session()->forget('relSearch');

        if(count($relSearches) > 1){
            $arrayRelSearch = [];
            foreach ($relSearches as $relSearch) {
                array_push($arrayRelSearch, ['inclusion' => $relSearch->tipoinclusion, 'busDesc' => $relSearch->busquedadescr]);
            }
            session(['arrayRelSearch' => $arrayRelSearch]);
        }else{
            foreach ($relSearches as $relSearch) {
                session(['relSearch'=> ['inclusion' => $relSearch->tipoinclusion, 'busDesc' => $relSearch->busquedadescr]]);
            }
        }
        session()->save();
    }
}