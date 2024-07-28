<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use App\Models\GastosPorDia;
use App\Models\Estados;
class GastosPorDiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $datos=GastosPorDia::where(['fecha'=>date('Y-m-d')])->orderBy('id', 'desc')->get();
         $array=array();
         foreach($datos as $dato)
         {  
            $array[]=array(
                    "id"=>$dato->id,
                    "neto"=>$dato->neto,
                    "iva"=>$dato->iva,
                    "total"=>$dato->total,
                    "fecha"=>$dato->fecha,
                    "glosa"=>$dato->glosa,
                    "proveedores_id"=>$dato->proveedores_id,
                    "proveedores"=>$dato->proveedores->nombre
                );
         }
         return response()->json($array, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), 
        [
            'nombre' => 'required',
            'monto' => 'required|integer',
            'iva' => 'required|integer',
            'total' => 'required|integer',
            'glosa' => 'required',
            'proveedores_id' => 'required',
           
        ],[
            'nombre.required'=>'El campo Nombre está vacío',
            'monto.required'=>'El campo Monto está vacío',
            'monto.integer'=>'El campo Monto debe ser numérico',
            'iva.required'=>'El campo IVA está vacío',
            'iva.integer'=>'El campo IVA debe ser numérico',
            'total.required'=>'El campo Total está vacío',
            'total.integer'=>'El campo Total debe ser numérico',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
