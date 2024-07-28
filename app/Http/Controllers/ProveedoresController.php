<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Proveedor;
class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //sleep(2); 
        return response()->json(Proveedor::orderBy('id', 'desc')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), 
        [
            'nombre' => 'required',
           
        ],[
            'nombre.required'=>'El campo Nombre está vacío',
        ]);

        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } 
        Proveedor::create
        (
            [
                'nombre'=>$request->nombre
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
        //sleep(2); 
        $datos=Proveedor::where(['id'=>$id])->first();
        if(!is_object($datos))
        {
            $array=array
                (
                    'estado'=>'error',
                    'mensaje'=>'No existe el registro',
                );
            return response()->json( $array, 404);
        }
        return response()->json($datos, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $datos=Proveedor::where(['id'=>$id])->first();
        if(!is_object($datos))
        {
            $array=array
                (
                    'estado'=>'error',
                    'mensaje'=>'No existe el registro',
                );
            return response()->json( $array, 404);
        }
        $datos->nombre=$request->nombre;
        $datos->save();

        return response()->json(
            [
                'estado'=>'OK',
                'mensaje' => 'Se creó el registro exitosamente'
            ], Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
