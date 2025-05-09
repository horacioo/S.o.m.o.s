@extends('somos.layout.template')


@section('title')
    aqui é a somos oceano
@endsection


@section('css')
    <link rel="stylesheet" href="{{ asset('css/somos/home/desktop.css') }}" media="all">
@endsection


@section('content')
    <header>
        <h1><span class="tit">S.O.M.O.S.</span> <span class='sub'>Oceano</span></h1>
        <span id="subtitulo">
            Sistema de observação e
            monitoramento da saúde dos
            oceanos
        </span>
        <img id='horse' src={{ asset('img/home/CavaloMarinho.svg') }}>
    </header>

    <nav> @include('somos.layout.partes.menu') </nav>

    <main id="descricaoProjeto">
        <p>O oceano é o pulmão azul do planeta — e cuidar dele é urgente. Nosso sistema de observação e monitoramento da
            saúde do oceano oferece dados em tempo real, análises precisas e alertas estratégicos sobre condições
            ambientais, qualidade da água, biodiversida de marinha e mudanças climáticas. Ideal para pesquisadores,
            governos, ONGs e empresas do setor, a plataforma integra tecnologia de ponta e inteligência ambiental para
            decisões mais sustentáveis e seguras.  Com uma interface intuitiva e acesso remoto, você acompanha os
            indicadores oceânicos de forma contínua, contribuindo diretamente para a preservação dos ecossistemas marinhos.
            Seja parte da transformação azul. Monitore, entenda e proteja o oceano com dados confiáveis e em tempo real.
        </p>
        <img id='imgCentro' src={{ asset('img/home/imagem-texto-main.jpg') }}>
    </main>



    @include('somos.layout.partes.cards') 

     @include('somos.layout.partes.textoRapido') 



@endsection







@section('footer')
@endsection
