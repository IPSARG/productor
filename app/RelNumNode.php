<?php

namespace App;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class RelNumNode extends Model
{
    use HasCompositePrimaryKey;

    protected $connection = 'mysql';
    protected $table = 'rel_nodo_num';
    protected $primaryKey = ['cod_nodo', 'id_norma', 'id_tipo_norma'];
    protected $fillable = ['cod_nodo', 'id_norma', 'id_tipo_norma'];
    public $timestamps = false;
    public $incrementing = false;

    public function getNorm($id_norma, $id_tipo_norma)
    {
        $query = $this->setConnection($this->connection)->where(['id_norma' => $id_norma, 'id_tipo_norma' => $id_tipo_norma])->first();

        return $query;
    }
}
