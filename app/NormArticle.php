<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class NormArticle extends Model
{
    // use HasCompositePrimaryKey;

    protected $connection = 'mysql';
    protected $table = 'trvarticulonorma';
    // protected $primaryKey = 'id';
    protected $fillable = ['id','codnorma', 'nroorden', 'codarticulo','descarticulo','voces','nivel','bold'];
    public $timestamps = false;
    // public $incrementing = false;
}
