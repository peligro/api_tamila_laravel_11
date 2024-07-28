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
             
            'monto' => 'required|integer',
            'iva' => 'required|integer',
            'total' => 'required|integer',
            'glosa' => 'required',
            'proveedores_id' => 'required',
           
        ],[ 
            'monto.required'=>'El campo Monto está vacío',
            'monto.integer'=>'El campo Monto debe ser numérico',
            'iva.required'=>'El campo IVA está vacío',
            'iva.integer'=>'El campo IVA debe ser numérico',
            'total.required'=>'El campo Total está vacío',
            'total.integer'=>'El campo Total debe ser numérico',
        ]);
        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } 
        GastosPorDia::create
        (
            [
                'neto'=>$request->neto,
                'iva'=>$request->iva,
                'total'=>$request->total,
                'estados_id'=>2,
                'proveedores_id'=>$request->proveedores_id,
                'fecha'=>date("Y-m-d"),
                'glosa'=>$request->glosa
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
        $validator = \Validator::make($request->all(), 
        [
             
            'monto' => 'required|integer',
            'iva' => 'required|integer',
            'total' => 'required|integer',
            'glosa' => 'required',
            'proveedores_id' => 'required',
           
        ],[ 
            'monto.required'=>'El campo Monto está vacío',
            'monto.integer'=>'El campo Monto debe ser numérico',
            'iva.required'=>'El campo IVA está vacío',
            'iva.integer'=>'El campo IVA debe ser numérico',
            'total.required'=>'El campo Total está vacío',
            'total.integer'=>'El campo Total debe ser numérico',
        ]);
        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } 
        $save=GastosPorDia::where(['id'=>$id])->first();
        if(!is_object($save))
        {
            $array=array
                (
                    'estado'=>'error',
                    'mensaje'=>'No existe el registro',
                );
            return response()->json( $array, 404);
        }
        $save->neto=$request->neto;
        $save->iva=$request->iva;
        $save->total=$request->total;
        $save->glosa=$request->glosa;
        $save->proveedores_id=$request->proveedores_id;
        $save->save();
       
         return response()->json(
            [
                'estado'=>'OK',
                'mensaje' => 'Se modificó el registro exitosamente'
            ], Response::HTTP_OK
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datos=GastosPorDia::where(['id'=>$id])->first();
        if(!is_object($datos))
        {
            $array=array
                (
                    'estado'=>'error',
                    'mensaje'=>'No existe el registro',
                );
            return response()->json( $array, 404);
        }
        GastosPorDia::where(['id'=>$id])->delete();
        return response()->json(
            [
                'estado'=>'OK',
                'mensaje' => 'Se eliminó el registro exitosamente'
            ], Response::HTTP_OK
        );
    }
}
