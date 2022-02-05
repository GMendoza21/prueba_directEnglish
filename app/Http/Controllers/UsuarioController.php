<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarios;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuarios');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function usuariosAll(){
        $usuarios = usuarios::where('estado', 1)->get();

        $listaUsuarios = mb_convert_encoding($usuarios, 'UTF-8', 'UTF-8');
        return $listaUsuarios;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params_array = $request->all();

        if(!empty($params_array)){
            $campos = [
                'nombre' => 'required|string|max:255',
                'telefono' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'fechaNacimiento' => 'required|string|max:255',
                'email' => 'required|email',
                'password' => 'required|string|max:255'
            ];
    
            $validate = \Validator::make($params_array, $campos);
    
            if($validate->fails()){
    
                $data = [
                    'status' => 'error',
                    'code' => '400',
                    'message' => 'No se ha guardado el registro, datos incorrectos.',
                    'errors' => $validate->errors()
                ];
    
            }else{
    
                try {
    
                    $usuario = new usuarios;
    
                    $usuario->nombre = $params_array['nombre'];
                    $usuario->telefono = $params_array['telefono'];
                    $usuario->username = $params_array['username'];
                    $usuario->fechaNacimiento = $params_array['fechaNacimiento'];
                    $usuario->email = $params_array['email'];
                    $usuario->estado = 1;
                    $usuario->password = $params_array['password'];
    
                    $usuario->save();
                    
                    $data = [
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'usuario creado con exito.'
                    ];
    
                } catch (\Illuminate\Database\QueryException $e) {
                    $data = [
                        'status' => 'error',
                        'code' => 500,
                        'error' => $e->errorInfo
                    ];
                }
            }
        } else {
            $data = [
                'status' => 'error',
                'code' => '400',
                'message' => 'Enviar datos correctamente.'
            ];
        }

        return redirect('/');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if(!empty($params_array)){
            $campos = [
                'nombre' => 'required|string|max:255',
                'telefono' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'fechaNacimiento' => 'required|string|max:255',
                'email' => 'required|email',
                'estado' => 'required|integer',
                'password' => 'required|string|max:255'
            ];
    
            $validate = \Validator::make($params_array, $campos);
    
            if($validate->fails()){
    
                $data = [
                    'status' => 'error',
                    'code' => '400',
                    'message' => 'No se ha guardado el registro, datos incorrectos.',
                    'errors' => $validate->errors()
                ];
    
            }else{

                unset($params_array['id']);
                unset($params_array['usr_create']);
                unset($params_array['created_at']);

                $usuario = usuarios::where('id', $id)->first();

                if(!empty($usuario) && is_object($usuario)){

                    try{

                        $usuario->update($params_array);

                        $data = [
                            'status' => 'success',
                            'code' => 200,
                            'cambios' => $usuario
                        ];

                    }catch(\Illuminate\Database\QueryException $e){
                        $data = [
                            'status' => 'error',
                            'code' => 500,
                            'error' => $e->errorInfo
                        ];
                    }

                }else{
                    $data = [
                        'status' => 'error',
                        'code' => 404,
                        'message' => 'No existe el usuario.'
                    ];

                }
            }
        } else {
            $data = [
                'status' => 'error',
                'code' => '400',
                'message' => 'Enviar datos correctamente.'
            ];
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = usuarios::where('id', $id)->first();

        if(is_object($usuario)){

            try{
                $usuario->delete();
                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Usuario eliminado correctamente.',
                    'usuario' => $usuario
                ];

            }catch(\Illuminate\Database\QueryException $e){
                $data = [
                    'status' => 'error',
                    'code' => 500,
                    'error' => $e->errorInfo
                ];
            }

        } else {
            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'No existe el usuario.'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function desactivarUsuario(Request $request){
        $data = $request->all();
        $id = $data['key_id'];

        $usuario = usuarios::where('id', $id)->first();

        if(is_object($usuario)){

            try{
                $usuario->estado = 0;
                $usuario->save();

                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Producto ocultado correctamente.',
                    'producto' => $usuario
                ];

            }catch(\Illuminate\Database\QueryException $e){
                $data = [
                    'status' => 'error',
                    'code' => 500,
                    'error' => $e->errorInfo
                ];
            }

        } else {
            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'No existe el usuario.'
            ];
        }

        return redirect('/');
    }
}
