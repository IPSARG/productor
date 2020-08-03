<?php

namespace App;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class RelCoeNode extends Model
{
    use HasCompositePrimaryKey;

    protected $connection = 'mysql';
    protected $table = 'rel_nodo_coe';
    protected $primaryKey = ['cod_nodo', 'id_norma', 'id_tipo_norma'];
    protected $fillable = ['cod_nodo', 'id_norma', 'id_tipo_norma'];
    public $timestamps = false;
    public $incrementing = false;
}
