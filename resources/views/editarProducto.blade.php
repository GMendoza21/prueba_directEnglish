@extends('layouts.app')

@section('content')

<h1 class="text-5xl text-center pt-24">Crear producto</h1>

<div class="block mx-auto my-12 p-8 bg-white w-1/2 border border-gray-200 
        rounded-lg shadow-lg">
    <form class="mt-4" method="POST" action="">
        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full
            text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="SKU" 
            id="SKU" name="SKU">

        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full
            text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Nombre del producto" 
            id="nombre" name="nombre">

        <input type="number" class="border border-gray-200 rounded-md bg-gray-200 w-full
            text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Cantidad" 
            id="cantidad" name="cantidad">

        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full
            text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Precio" 
            id="precio" name="precio">

        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full
            text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Descripcion" 
            id="descripcion" name="descripcion">

        <button type="submit" class="rounded-md bg-indigo-500 w-full text-lg text-white 
            font-semibold p-2 my-3 hover:bg-indigo-600">Guardar</button>
    </form>
</div>

@endsection