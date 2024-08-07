<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-300 h-screen flex items-center justify-center">
    <div class="max-w-md bg-white shadow-md rounded-md overflow-hidden">
        <div class="px-6 py-4 bg-black text-white">
            <h2 class="text-2xl font-bold">{{__('inicio.accesoDenegado')}}</h2>
        </div>
        <div class="p-6">
            <p class="text-gray-700">{{__('inicio.noPermiso')}}</p>
            <p class="text-gray-700">{{__('inicio.contactaAdmin')}}</p>
        </div>
        <div class="px-6 py-4 bg-gray-100 text-right">
            <a href="{{route('inicio')}}" class="text-blue-500 font-bold hover:text-blue-700">{{__('inicio.volverInicio')}}</a>
        </div>
    </div>
</body>
</html>