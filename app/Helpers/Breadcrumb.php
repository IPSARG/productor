<?php

namespace App\Helpers;

class Breadcrumb {

    public static function create($request, $descNodo, $codNodo)
    {
        $arrayDesc = [];
        // SI ES ARRAY
        if(is_array($request->session()->get('arrayDescNodo'))){
            // MUEVO TODA LA INFO DE LA SESSION arrayDescNodo IN ARRAYDESC[]
            foreach($request->session()->get('arrayDescNodo') as $node){
                array_push($arrayDesc, $node['desc']);
            }
            // SI DESCNODO NO ESTÁ EN EL ARRAY GENERADO LO AGREGO O NO
            if(!in_array($descNodo, $arrayDesc)){
                $request->session()->push('arrayDescNodo', ['desc' => $descNodo, 'code' => $codNodo, 'prim' => 'false', 'url' => $request->segment(3)]);
            };
            // SI HAY 3 O MAS EN PANTALLA Y LA REQUEST ENTRA POR MEDIO DE UN BREADCRUMB
            if(count($arrayDesc) > 1 && $request->query('brcr') == 1){
                // SI DONDE ESTAMOS AHORA ES DISTINTO DEL ULTIMO EN ARRAYDESC (hicieron click atrás)
                if($request->query('DescNodo') !== end($arrayDesc)){
                    $indexes = [];
                    // RECORRO TODAS LAS VARIABLES DE arrayDescNodo Y GUARDO LOS INDEXES
                    foreach ($request->session()->get('arrayDescNodo') as $key => $node) {
                        array_push($indexes, $key);
                        // SI NODE['CODE'] ES IGUAL A PARAMETRO nodecode DONDE ESTAMOS AHORA
                        if($node['code'] == $request->query('CodNodo')){
                            // AGARRO EL INDEX ACTUAL DE arrayDescNodo (donde hicieron click)
                            $i = $key;
                        }
                    }
                    foreach ($indexes as $index) {
                        if($index > $i){
                            // ELIMINO LOS INDEX DEL ARRAY DE SESSION MAYORES AL INDEX DE DONDE HICIERON CLICK
                            $request->session()->forget('arrayDescNodo.'. $index);
                        }
                    }
                };
            }
        }else{
            // EL PRIMERO DE LA SESSION ARRAYDESCNODO
            $request->session()->push('arrayDescNodo', ['desc' => $descNodo, 'code' => $codNodo, 'prim' => 'true', 'url' => $request->segment(3)]);
        }
        session()->save();
    }
}