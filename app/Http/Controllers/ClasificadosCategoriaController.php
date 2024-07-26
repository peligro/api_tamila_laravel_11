<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ClasificadosCategorias;
use App\Models\ClasificadosAvisos;
use Illuminate\Support\Str;
class ClasificadosCategoriaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos = ClasificadosCategorias::orderBy('id', 'desc')->get();
        return response()->json($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //recibir el json
       //echo file_get_contents('php://input');exit;
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
        ClasificadosCategorias::create(
            [
                'nombre'=>$json['nombre'],
                'slug'=>Str::slug($json['nombre'], '-')
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
        $datos=ClasificadosCategorias::where(['slug'=>$id])->first();
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
            return response()->json( $datos, 200);
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
        $datos=ClasificadosCategorias::where(['id'=>$id])->first();
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
        $json = json_decode(file_get_contents('php://input'), true);
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
        //ejecuto el update
        $datos->nombre=$json['nombre'];
        $datos->slug=Str::slug($json['nombre'], '-');
        $datos->save();
        //retorno un json
        $array=array
                    (
                        'estado'=>'ok',
                        'mensaje'=>'Se modificó el registro',
                    );
        return response()->json( $array, 201);
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $datos=ClasificadosCategorias::where(['id'=>$id])->firstOrFail();
        $existe = ClasificadosAvisos::where(['clasificados_categoria_id'=>$id])->count();
        if($existe==0)
        {
            ClasificadosCategorias::where(['id'=>$id])->delete();
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
                            'mensaje'=>'No se puede eliminar el registro',
                        );
            return response()->json( $array, 200);
        }
    }
}
