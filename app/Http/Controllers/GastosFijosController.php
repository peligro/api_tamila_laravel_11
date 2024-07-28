<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\GastosFijos;
use App\Models\Estados;
class GastosFijosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos=GastosFijos::whereMonth('fecha', '=', date('m'))->orderBy('id', 'desc')->get();
         $array=array();
         foreach($datos as $dato)
         {  
            $array[]=array(
                    "id"=>$dato->id,
                    "nombre"=>$dato->nombre,
                    "monto"=>$dato->monto,
                    "fecha"=>$dato->fecha,
                    "glosa"=>$dato->glosa,
                    "proveedores_id"=>$dato->proveedores_id,
                    "proveedores"=>$dato->proveedores->nombre,
                    "estados_id"=>$dato->estados_id,
                    "estados"=>$dato->estados->nombre
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
            'proveedores_id' => 'required',
           
        ],[
            'nombre.required'=>'El campo Nombre está vacío',
            'monto.required'=>'El campo Monto está vacío',
            'monto.integer'=>'El campo Monto debe ser numérico',
            'proveedores_id.required'=>'El campo proveedores_id está vacío',
        ]);

        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } 
        GastosFijos::create
        (
            [
                'nombre'=>$request->nombre,
                'monto'=>$request->monto,
                'estados_id'=>2,
                'proveedores_id'=>$request->proveedores_id,
                'fecha'=>date("Y-m-d H:i:s")
            ]
        );
         return response()->json(
            [
                'estado'=>'OK',
                'mensaje' => 'Se creó el registro exitosamente'
            ], Response::HTTP_OK
        );
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
