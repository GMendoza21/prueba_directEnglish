<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <title>Prueba Direct English</title>
</head>
<body class="bg-gray-100 text-gray-800">
    <nav class="flex py-5 bg-indigo-500 text-white">
        <div class="w-1/2 px-12 mr-auto">
            <p class="text-2xl font-bold">Prueba Direct English</p>
        </div>

        <ul class="w-1/2 px-16 ml-auto flex justify-end pt-1">
            <li class="mx-6">
                <a href="{{ url('/') }}" class="font-semibold 
                    hover:bg-indigo-700 py-3 px-4 rounded">Usuarios</a>
            </li>
            <li>
                <a href="{{ url('/productos') }}" class="font-semibold 
                    py-2 px-4 rounded-md hover:bg-indigo-700">Productos</a>
            </li>
        </ul>
    </nav>

    <div class="container mx-auto mt-5">
        @yield('content')
    </div>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>