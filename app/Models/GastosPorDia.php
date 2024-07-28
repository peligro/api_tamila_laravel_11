<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estados;
use App\Models\Proveedor;
class GastosPorDia extends Model
{
    protected $guarded =[];
    public $timestamps = false;
    protected $table = 'gastos_por_dia';

    public function estados()
    {
        return $this->belongsTo(Estados::class);
    }
    public function proveedores()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
