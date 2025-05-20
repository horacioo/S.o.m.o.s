<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Título Padrão')</title>
    @yield('css')

</head>

<body class="container">







        <!-- Conteúdo principal -->
        @yield('content')
    



    
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
