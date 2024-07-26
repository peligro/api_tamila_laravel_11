<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClasificadosCategorias;
use App\Models\VariablesGlobales;
use App\Models\ClasificadosAvisos;
use Illuminate\Support\Str;
class ClasificadosAvisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $porpagina=2;
        $datos=ClasificadosAvisos::orderBy('id', 'desc')->paginate($porpagina);
        $array=array();
        if($datos->total()==0)
        {
            return response()->json( array('total'=>0,'por_pagina'=>sizeof($array), 'links'=>0,'datos'=>$array));
        }else
        {

            foreach($datos as $dato)
            {

                $array[]=array(
                    "id"=>$dato->id,
                    "nombre"=>$dato->nombre,
                    "slug"=>$dato->slug,
                    "descripcion"=>$dato->descripcion,
                    "fecha"=>$dato->fecha,
                    "foto"=>$dato->foto,
                    "clasificados_categoria_id"=>$dato->clasificados_categoria_id,
                    "clasificados_categoria_nombre"=>$dato->clasificados_categoria->nombre,
                    "clasificados_categoria_slug"=>$dato->clasificados_categoria->slug
                );

            }
            $links=$datos->total()/$porpagina;
            return response()->json( array('total'=>$datos->total(),'por_pagina'=>sizeof($array), 'links'=>number_format($links, 0 , '', ''), 'datos'=>$array));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         if(empty($_FILES["imagen"]["tmp_name"]))
        {
            $array=
                    array
                    (
                        'response'=>array
                        (
                            'estado'=>'Conflict',
                            'mensaje'=>'La imagen es obligatoria '
                        )
                    )
                ;
            return response()->json($array, 200);
        }
        if($_FILES["imagen"]["type"]=='image/jpeg' or $_FILES["imagen"]["type"]=='image/png')
        {

            switch($_FILES["imagen"]["type"])
            {
                case 'image/jpeg':
                    $archivo =time().".jpg";
                break;
                case 'image/png':
                    $archivo =time().".png";
                break;
            }
            copy($_FILES["imagen"]["tmp_name"], VariablesGlobales::find(10)->valor."uploads/avisos/".$archivo);
        }else
        {
            $array=
                    array
                    (
                        'response'=>array
                        (
                            'estado'=>'Conflict',
                            'mensaje'=>'La foto es no tiene formato válido'
                        )
                    );
            return response()->json($array, 200);
        }
        ClasificadosAvisos::create(
            [
                'nombre'=>$request->input('nombre'),
                'slug'=>Str::slug($request->input('nombre')),
                'descripcion'=>$request->input('descripcion'),
                'foto'=>$archivo,
                'clasificados_categoria_id'=>$request->input('clasificados_categoria_id'),
                'fecha'=>date('Y-m-d')
            ]
            );
        $array=array
                    (
                        'estado'=>'ok',
                        'mensaje'=>'Se creó el registro exitosamente',
                    );
        return response()->json( $array, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datos=ClasificadosAvisos::where(['id'=>$id])->first();
        if(!is_object($datos))
        {
            $array=array
                (
                    'estado'=>'error',
                    'mensaje'=>'No existe el registro',
                );
            return response()->json( $array, 404);
        }else
        {
            return response()->json( array(
                    "id"=>$datos->id,
                    "nombre"=>$datos->nombre,
                    "slug"=>$datos->slug,
                    "descripcion"=>$datos->descripcion,
                    "fecha"=>$datos->fecha,
                    "foto"=>$datos->foto,
                    "clasificados_categoria_id"=>$datos->clasificados_categoria_id,
                    "clasificados_categoria_nombre"=>$datos->clasificados_categoria->nombre,
                    "clasificados_categoria_slug"=>$datos->clasificados_categoria->slug
                ), 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $datos=ClasificadosAvisos::where(['id'=>$id])->first();
         if(is_object($datos))
        {
            unlink(VariablesGlobales::find(10)->valor."uploads/avisos/".$datos->foto);
            ClasificadosAvisos::where(['id'=>$id])->delete();

            $array=array
                    (
                        'estado'=>'ok',
                        'mensaje'=>'Se eliminó el registro',
                    );
        return response()->json( $array, 201);
        }else
        {
            $array=array
                    (
                        'estado'=>'error',
                        'mensaje'=>'No existe el registro',
                    );
        return response()->json( $array, 201);
        }
    }
}
