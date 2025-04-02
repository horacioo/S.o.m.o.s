<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Título Padrão')</title>
    <!-- Inclua seus arquivos CSS aqui -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')

</head>

<body class="container">
    <header>
        <!-- Conteúdo do cabeçalho -->
        @include('somos.layout.partes.header')
    </header>

    <nav>@include('somos.layout.partes.menu') </nav>

    <main class="container">
        <!-- Conteúdo principal -->
        @yield('content')
    </main>



    
    <footer>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


        <!-- Conteúdo do rodapé -->
        @include('somos.layout.partes.footer')
        @yield('footer')
    </footer>

    <!-- Inclua seus arquivos JS aqui -->
    <!--<script src="{{ asset('js/app.js') }}"></script>-->

</body>

</html>
