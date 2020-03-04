<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class NormArticle extends Model
{
    use HasCompositePrimaryKey;
    
    protected $connection = 'mysql';
    protected $table = 'trvarticulonorma';
    protected $primaryKey = ['codnorma', 'nroorden'];
    public $timestamps = false;
    public $incrementing = false;
}
