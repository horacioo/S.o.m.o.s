

@extends('somos.layout.template')




@section('css')
    <link rel="stylesheet" href="{{ asset('css/somos/css/trabalhos/style_cad.css') }}" media="all">
@endsection




@section('content')
   
<h1>Trabalhos cadastrados</h1>
<ul>
    @foreach($trabalhos as $t)
    <li><a  href="{{ route('trabalhoId',$t->id) }}">{{ $t->titulo }}</a></li>
    @endforeach
</ul>

@endsection





@section('footer')@endsection
