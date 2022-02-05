@extends('layouts.app')

@section('content')
<h1 class="text-5xl text-center pt-24">Listado de productos</h1>

<div class="block mx-auto my-12 p-8 bg-white w-full border border-gray-200 
        rounded-lg shadow-lg">
        <table id="myTable" class="table-auto">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Descripcion</th>
                    <th>Eliminado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
</div>

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
            font-semibold p-2 my-3 hover:bg-indigo-600" onclick="guardar_prod()">Guardar</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "ajax": {
                url: "{{ route('allProductos') }}",
                dataType: "json",
                dataSrc: ""
            },
            deferRender: true,
            columns: [{
                    data: 'SKU'
                },
                {
                    data: 'nombre'
                },
                {
                    data: 'cantidad'
                },
                {
                    data: 'precio'
                },
                {
                    data: 'descripcion'
                },
                {
                    data: 'eliminado'
                },
                {
                    data: 'id',
                    "render": function (data, type, full, meta) {
                        return '<a href="" class="rounded-md bg-yellow-500 w-auto text-white font-semibold p-2 my-3 mx-3 hover:bg-yellow-600">Editar<a/><button type="submit" class="rounded-md bg-red-500 w-auto text-white font-semibold p-2 my-3 hover:bg-red-600" onclick="desactivar_prod(' +
                            data + ');">Desactivar</a>';
                    }
                }
            ],
            select: false,
            responsive: true,
            searching: true,
            language: {
                processing: "Petición en curso...",
                search: "Buscar&nbsp;:",
                lengthMenu: "Mostrar _MENU_ filas",
                info: "Mostrando del _START_ al _END_ de _TOTAL_ resultados.",
                infoEmpty: "Mostrando 0 resultados de un total de 0 elementos.",
                infoFiltered: "(Filtrado de _MAX_ elementos en total)",
                infoPostFix: "",
                loadingRecords: "Cargando la información...",
                zeroRecords: "Cero resultados",
                emptyTable: "No hay datos que mostrar de momento.",
                paginate: {
                    first: "<<",
                    previous: "<",
                    next: ">",
                    last: ">>"
                }
            }
        });
    });

    function guardar_prod() {
        let parametros = {
            "SKU": $("#SKU").val(),
            "nombre": $("#nombre").val(),
            "cantidad": $("#cantidad").val(),
            "precio": $("#precio").val(),
            "descripcion": $("#descripcion").val()
        };

        $.ajax({
        url: "{{ url('/producto') }}",
        method: 'post',
        async: true,
        dataType: "json",
        data: parametros,
        //  Funcion que se ejecuta antes de obtener respuesta de la petición.
        beforeSend: function () {
        },
        //  Función que se ejecuta al obtener la respuesta del servidor.
        success: function (response) {
            //$("#p-p-response").html(response);
            if (response.code === 500 || response.code === 400) {
                $('#p-p-response').hide();
                Swal.fire({
                    title: 'Atención',
                    text: response.message,
                    type: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            } else {
                $('#p-p-response').hide();
                Swal.fire({
                    title: 'Producto guardado correctamente.',
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Okay'
                }).then(function () {
                    location.href = "{{ url('') }}";
                });
            }
        },
        //  Función que se ejecuta si surge un error en la petición.
        error: function () {
            $("#p-p-response").html(
                '<p class="text-danger">Error.</p>'
            )
        }
    });
    };

    function desactivar_prod(data) {
        Swal.fire({
            title: '¿Esta segur@ de ocultar este producto?',
            text: 'No puede revertir esta acción',
            //icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                let key_id = data;
                $.ajax({
                url: "{{ url('/desactivarProducto') }}",
                method: 'post',
                async: true,
                dataType: "json",
                data: {
                    key_id: key_id
                },
                beforeSend: function () {
                },
                success: function (response) {
                    //
                },
                error: function () {
                    $("#p-p-response").html(
                        '<p class="text-danger">Error.</p>'
                    )
                }
            });
            }
            location.href = "{{ url('/productos') }}";
        })
    };
</script>
@endsection