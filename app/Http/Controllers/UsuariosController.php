<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos=User::orderBy('id', 'desc')->get();
         $array=array();
         foreach($datos as $dato)
         {  
            $array[]=array(
                    "id"=>$dato->id,
                    "nombre"=>$dato->name,
                    "correo"=>$dato->email
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
            'correo' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:6' , 
           
        ],[ 
            'nombre.required'=>'El campo Nombre está vacío',
            'correo.required'=>'El campo E-Mail está vacío',
            'correo.email'=>'El E-Mail ingresado no es válido',
            'correo.unique'=>'El E-Mail ingresado ya está siendo usado',
            'password.required'=>'El campo Contraseña está vacío',
            'password.min'=>'El campo Contraseña debe tener al menos 6 caracteres',
        ]);        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } 
        $save=new User;
        $save->name=$request->nombre;
        $save->email=$request->correo;
        $save->password=Hash::make($request->password);
        $save->created_at=date('Y-m-d H:i:s');
        $save->save();
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
             
            'nombre' => 'required',
            'correo' => 'required|email:rfc,dns',
            'password' => 'required|min:6' , 
           
        ],[ 
            'nombre.required'=>'El campo Nombre está vacío',
            'correo.required'=>'El campo E-Mail está vacío',
            'correo.email'=>'El E-Mail ingresado no es válido',
            'password.required'=>'El campo Contraseña está vacío',
            'password.min'=>'El campo Contraseña debe tener al menos 6 caracteres',
        ]);        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } 
        $save=User::where(['id'=>$id])->first();
        if(!is_object($save))
        {
            $array=array
                (
                    'estado'=>'error',
                    'mensaje'=>'No existe el registro',
                );
            return response()->json( $array, 404);
        }
        $save->name=$request->nombre;
        $save->email=$request->correo;
        $save->password=Hash::make($request->password);
        $save->created_at=date('Y-m-d H:i:s');
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
        $datos=User::where(['id'=>$id])->first();
        if(!is_object($datos))
        {
            $array=array
                (
                    'estado'=>'error',
                    'mensaje'=>'No existe el registro',
                );
            return response()->json( $array, 404);
        }
        User::where(['id'=>$id])->delete();
        return response()->json(
            [
                'estado'=>'OK',
                'mensaje' => 'Se eliminó el registro exitosamente'
            ], Response::HTTP_OK
        );
    }
}
