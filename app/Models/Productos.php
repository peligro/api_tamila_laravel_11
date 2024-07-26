<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categorias;
class Productos extends Model
{
    protected $guarded =[];
    public $timestamps = false;
    protected $table = 'productos';

    public function categorias()
    {
        return $this->belongsTo(Categorias::class);
    }
}
