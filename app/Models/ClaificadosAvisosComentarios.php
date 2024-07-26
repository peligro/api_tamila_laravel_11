<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ClasificadosAvisos;
class ClaificadosAvisosComentarios extends Model
{
    protected $guarded =[];
    public $timestamps = false;
    protected $table = 'clasificados_avisos_comentarios';

    public function clasificados_avisos()
    {
        return $this->belongsTo(ClasificadosAvisos::class);
    }
}
