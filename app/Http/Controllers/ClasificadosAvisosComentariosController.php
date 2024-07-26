<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClaificadosAvisosComentarios;
class ClasificadosAvisosComentariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = json_decode(file_get_contents('php://input') , true);
       //print_r($json);
       //validar que viene un json
        if(!is_array($json ))
        {
            $array=
                    array
                    (
                        'response'=>array
                        (
                            'estado'=>'Bad Request',
                            'mensaje'=>'La peticion HTTP no trae datos para procesar '
                        )
                    )
                ;
            return response()->json($array, 400);
        }
       //crear el registro
        ClaificadosAvisosComentarios::create(
            [
                'nombre'=>$request->input('nombre'),
                'correo'=>$request->input('correo'),
                'clasificados_avisos_id'=>$request->input('clasificados_avisos_id'),
                'mensaje'=>$request->input('mensaje')
            ]
        );
       //retornar un json
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
        $datos=ClaificadosAvisosComentarios::where(['clasificados_avisos_id'=>$id])->orderBy('id', 'desc')->get();
        return response()->json($datos, 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
