<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class RelTemNode extends Model
{
    use HasCompositePrimaryKey;
    
    protected $connection = 'mysql';
    protected $table = 'rel_nodo_tem';
    protected $primaryKey = ['cod_nodo', 'id_norma', 'id_tipo_norma', 'articulo'];
    protected $fillable = ['cod_nodo', 'id_norma', 'id_tipo_norma', 'articulo'];
    public $timestamps = false;
    public $incrementing = false;
}
