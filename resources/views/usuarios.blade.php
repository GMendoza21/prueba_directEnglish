@extends('layouts.app')

@section('content')
<h1 class="text-5xl text-center pt-24">Listado de usuarios</h1>

<div class="block mx-auto my-12 p-8 bg-white w-full border border-gray-200 
        rounded-lg shadow-lg">
        <table id="myTable" class="table-auto">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Username</th>
                    <th>Fecha de nacimiento</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
</div>

<h1 class="text-5xl text-center pt-24">Crear usuario</h1>

<div class="block mx-auto my-12 p-8 bg-white w-1/2 border border-gray-200 
        rounded-lg shadow-lg">
    <form class="mt-4">
        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full
            text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Nombre" 
            id="nombre" name="nombre">

        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full
            text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Telefono" 
            id="telefono" name="telefono">

        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full
            text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Username" 
            id="username" name="username">

        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full
            text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="fechaNacimiento" 
            id="fechaNacimiento" name="fechaNacimiento">

        <input type="email" class="border border-gray-200 rounded-md bg-gray-200 w-full
            text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Email" 
            id="email" name="email">

        <input type="password" class="border border-gray-200 rounded-md bg-gray-200 w-full
            text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Password" 
            id="password" name="password">

        <button type="submit" class="rounded-md bg-indigo-500 w-full text-lg text-white 
            font-semibold p-2 my-3 hover:bg-indigo-600" onclick="guardar_user()">Guardar</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "ajax": {
                url: "{{ route('allUsuarios') }}",
                dataType: "json",
                dataSrc: ""
            },
            deferRender: true,
            columns: [{
                    data: 'nombre'
                },
                {
                    data: 'telefono'
                },
                {
                    data: 'username'
                },
                {
                    data: 'fechaNacimiento'
                },
                {
                    data: 'email'
                },
                {
                    data: 'estado'
                },
                {
                    data: 'id',
                    "render": function (data, type, full, meta) {
                        return '<a href="" class="rounded-md bg-yellow-500 w-auto text-white font-semibold p-2 my-3 mx-3 hover:bg-yellow-600">Editar<a/><button type="submit" class="rounded-md bg-red-500 w-auto text-white font-semibold p-2 my-3 hover:bg-red-600" onclick="desactivar_user(' +
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

    function guardar_user() {
        let parametros = {
            "nombre": $("#nombre").val(),
            "telefono": $("#telefono").val(),
            "username": $("#username").val(),
            "fechaNacimiento": $("#fechaNacimiento").val(),
            "email": $("#email").val(),
            "password": $("#password").val()
        };

        $.ajax({
            url: "{{ route('usuario.store') }}",
            method: 'post',
            async: false,
            dataType: "json",
            data: parametros,
            beforeSend: function () {
            },
            success: function (response) {
                //
            },
            error: function () {
                //
            }
        });
        location.href = "{{ url('/') }}";
    };

    function desactivar_user(data) {
        Swal.fire({
            title: '¿Esta segur@ de ocultar este usuario?',
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
                url: "{{ url('/desactivarUsuario') }}",
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
            location.href = "{{ url('/') }}";
        })
    };
</script>
@endsection