<?php

namespace App;

use App\Coefic;
use App\Dispatch;
use App\Helpers\CheckDispatch;
use Illuminate\Database\Eloquent\Model;

class TemIndex extends Model
{
    protected $connection = 'mysql';
    protected $table = 'indtem';
    protected $primaryKey = null;
    public $timestamps = false;
    public $incrementing = false;

    public function getTNac()
    {
        $query = $this->setConnection($this->connection)->where('cod_padre', 'CP1')
        ->join('nodotem', 'indtem.cod_hijo', '=', 'nodotem.cod_nodo')
        ->select('indtem.cod_hijo', 'indtem.cod_padre','nodotem.cod_nodo', 'nodotem.desc_nodo', 'nodotem.fecha')
        ->orderBy('desc_nodo', 'asc')
        ->get();

        return $query;
    }

    public function getChild($codNodo)
    {

        $query = $this->setConnection($this->connection)->where('cod_padre', $codNodo)
        ->join('nodotem', 'indtem.cod_hijo', '=', 'nodotem.cod_nodo')
        ->select('indtem.cod_hijo', 'indtem.cod_padre','nodotem.cod_nodo', 'nodotem.desc_nodo', 'nodotem.fecha')
        // ->orderBy('fecha', 'desc')
        ->orderBy('desc_nodo', 'asc')
        ->get();

        $dispatchSubject = new Dispatch();
        $dispatchSubject = Dispatch::where('codigo', $codNodo)->select('codigo', 'ruta', 'param1', 'param2', 'param3')->first();
        // IF NOT HIJOS CHECK SWITCH
        if(count($query) === 0){
            $checkSubject = new CheckDispatch($dispatchSubject);
        }

        return $query;
    }

    public function getChildCoefi($codNodo)
    {
        // LOGICA INVERSA A $this->index() (?)
        $dispatchSubject = new Dispatch();
        $dispatchSubject = Dispatch::where('codigo', $codNodo)->select('codigo', 'ruta', 'param1', 'param2', 'param3')->first();
        //  SI EXISTE IN DISPATCH LA VAR $codNodo PASA A SER = A PARAM1
        // dd($dispatchSubject);

        if($dispatchSubject!=null){
            $codNodo = $dispatchSubject->param1;
        };

        // INDICES Y TASAS CP0
        $query = Coefic::where('cod_padre', $codNodo)
        ->join('nodocoe', 'coefic.cod_hijo', '=', 'nodocoe.cod_nodo')
        ->select('coefic.cod_padre', 'coefic.cod_hijo', 'nodocoe.desc_nodo', 'nodocoe.fecha')
        ->orderBy('fecha', 'desc')
        ->orderBy('desc_nodo', 'asc')
        ->get();

        return $query;
    }
}
