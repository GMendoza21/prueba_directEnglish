<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\productos;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('productos');
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

    public function productosAll(){
        $productos = productos::where('eliminado', 1)->get();

        $listaProductos = mb_convert_encoding($productos, 'UTF-8', 'UTF-8');
        return $listaProductos;
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
                'SKU' => 'string|max:255',
                'nombre' => 'required|string|max:255',
                'cantidad' => 'required|integer',
                'precio' => 'required|numeric',
                'descripcion' => 'string|max:255'
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
    
                    $producto = new productos;
    
                    $producto->SKU = $params_array['SKU'];
                    $producto->nombre = $params_array['nombre'];
                    $producto->cantidad = $params_array['cantidad'];
                    $producto->precio = $params_array['precio'];
                    $producto->descripcion = $params_array['descripcion'];
                    $producto->eliminado = 1;
    
                    $producto->save();
                    
                    $data = [
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Producto creado con exito.'
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

        //return response()->json($data, $data['code']);
        return redirect('/productos');
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
        return view('editarProd');
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
                'SKU' => 'string|max:255',
                'nombre' => 'required|string|max:255',
                'cantidad' => 'required|integer',
                'precio' => 'required|numeric',
                'descripcion' => 'string|max:255',
                'eliminado' => 'integer'
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

                $producto = productos::where('id', $id)->first();

                if(!empty($producto) && is_object($producto)){

                    try{

                        $producto->update($params_array);

                        $data = [
                            'status' => 'success',
                            'code' => 200,
                            'cambios' => $producto
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
                        'message' => 'No existe el producto.'
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
        //
    }

    public function desactivarProducto(Request $request){
        $data = $request->all();
        $id = $data['key_id'];

        $producto = productos::where('id', $id)->first();

        if(is_object($producto)){

            try{
                $producto->eliminado = 0;
                $producto->save();

                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Producto ocultado correctamente.',
                    'producto' => $producto
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
                'message' => 'No existe el producto.'
            ];
        }

        return redirect('/productos');
    }
}
