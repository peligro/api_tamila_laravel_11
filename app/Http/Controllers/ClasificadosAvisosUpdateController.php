<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClasificadosCategorias;
use App\Models\VariablesGlobales;
use App\Models\ClasificadosAvisos;
use Illuminate\Support\Str;

class ClasificadosAvisosUpdateController extends Controller
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

       $datos=ClasificadosAvisos::where(['id'=>$request->input('id')])->firstOrFail();
       //print_r($datos->clasificados_categoria_id);exit;
        if(!empty($_FILES["imagen"]["tmp_name"]))
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
            $foto = $archivo;
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
        }else
        {
            $foto = $datos->foto;
        }
        $datos->nombre=$request->input('nombre');
        $datos->slug=Str::slug($request->input('nombre'), '-')."-".$request->input('id');
        $datos->descripcion=$request->input('descripcion');
        $datos->clasificados_categoria_id=$request->input('clasificados_categoria_id');
        $datos->foto=$foto;
        $datos->save();
        //retorno un json
        $array=array
                    (
                        'estado'=>'ok',
                        'mensaje'=>'Se modificó el registro',
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
        //
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

    }
}
