<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NormType extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tipo_norma';
    protected $primaryKey = 'id_tipo_norma';
    protected $fillable = ['desc_tipo_norma', 'id_tipo_norma', 'idjurisdiccion','idtipodocumento'];
    public $timestamps = false;
    public $incrementing = false;

    public function getAll()
    {
        $query = $this->setConnection($this->connection)->orderBy('desc_tipo_norma', 'asc')->get();

        return $query;
    }

    public function getNormType($id_tipo_norma)
    {
        $query = $this->setConnection($this->connection)->where('id_tipo_norma', $id_tipo_norma)->first();

        return $query;
    }
}
