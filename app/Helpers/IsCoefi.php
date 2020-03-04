<?php 

namespace App\Helpers;

class IsCoefi {
    public static function isCoefi($request, $desc_nodo)
    {
        if(!$request->isMethod('get'))
        {
            $prevPath = str_replace(url('/'), '', url()->previous());
            $urlNoParams[] = substr($prevPath, 0, strpos($prevPath, "?"));
        }
        
        $curPath = str_replace(url('/'), '', url()->full());
        $urlNoParams[] = substr($curPath, 0, strpos($curPath, "?"));

        $coefiUrls = ['/materias-coes/filtrar/final/coefi', '/materias-coes/filtrar/coefi'];

        if(!empty(array_intersect($urlNoParams, $coefiUrls)) || $desc_nodo == 'Tablas y Cuadros' || !is_null($request->isTabCuad))
        {
            return true;
        }
        return false;
    }
}