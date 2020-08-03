<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NumNode extends Model
{
    protected $connection = 'mysql';
    protected $table = 'nodonum';
    protected $primaryKey = 'cod_nodo';
    public $timestamps = false;
    public $incrementing = false;

    public function getAll()
    {
        $query = $this->setConnection($this->connection)->orderBy('desc_nodo', 'asc')->get();

        return $query;
    }

    public function getCodNodeByDesc($desc_tipo_norma)
    {
        $query = $this->setConnection($this->connection)->where('desc_nodo', $desc_tipo_norma)->first();

        return $query;
    }
}
