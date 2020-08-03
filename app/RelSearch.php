<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelSearch extends Model
{
    protected $connection = 'mysql';
    protected $table = 'trvbusquedarel';
    protected $primaryKey = 'idbusqueda';
    public $timestamps = false;
    public $incrementing = false;

    public function getForImpCode($codImpuesto)
    {
       $query = $this->setConnection($this->connection)
       ->where('codimpuesto', $codImpuesto)
       ->select('idbusqueda', 'codimpuesto', 'tipoinclusion', 'busquedadescr')
       ->get();

       if(count($query) > 0){
           $results = [];
            foreach ($query as $result) {
                array_push($results, $result);
            }
            return collect($results);
       }
    }
}
