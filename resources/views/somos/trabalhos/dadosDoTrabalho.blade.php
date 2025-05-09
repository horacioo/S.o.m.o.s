@extends('somos.layout.template')




@section('css')
    <style>
        input[type="radio"] {
            border: 1px solid red;

        }
    </style>
@endsection




@section('content')
    <?php $kw = []; ?>

    <h1>olá mundo</h1>


    <div class="container formulário">


        <h2>Cadastro de Documentos</h2>
        <form action="{{ route('trabalhos.updateData') }}" method="POST">
            <input type="hidden" name="csrfToken" id="csrfToken" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $doc->id }}">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            @csrf



            <div class="row">
                <div class="col-md-4">
                    <label for="programa">Programa</label>
                    <input type="text" name="programa" id="programa" class="form-control" value="{{ $doc->programa }}"
                        required>
                </div>
                <div class="col-md-4">
                    <label for="tipo_do_documento">Tipo do Documento</label>
                    <input type="text" name="tipo_do_documento" id="tipo_do_documento" class="form-control"
                        value="{{ $doc->tipo_do_documento }}" required>
                </div>
                <div class="col-md-4">
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $doc->titulo }}"
                        required>
                </div>
            </div>



            <div class="row">
                <div class="col-md-4">
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $doc->titulo }}"
                        required>
                </div>
                <div class="col-md-4">
                    <label for="autor">Autor</label>
                    <input type="text" name="autor" id="autor" class="form-control" value="{{ $doc->autor }}"
                        required>
                </div>
                <div class="col-md-4">
                    <label for="citacao">Citação</label>
                    <input type="text" name="citacao" id="citacao" class="form-control" value="{{ $doc->citacao }}"
                        required>
                </div>
            </div>



            <div class="row">
                <div class="col-md-4">
                    <label for="orientador">Orientador</label>
                    <input type="text" name="orientador" id="orientador" class="form-control"
                        value="{{ $doc->orientador }}" required>
                </div>
                <div class="col-md-4">
                    <label for="data_deposito">Data de Depósito</label>
                    <input type="date" name="data_deposito" id="data_deposito" class="form-control"
                        value="{{ $doc->data_deposito }}" required>
                </div>
                <div class="col-md-4">
                    <label for="coleta">Coleta</label>

                    <select class="form-control" id="coleta">
                        <option value="#">Escolha</option>
                        <option value="1">sim</option>
                        <option value="0">não</option>
                    </select>
                </div>
            </div>




            <?php foreach ($doc->keywords as $k):  $kw[] = $k->keyword; endforeach; ?>


            <div class="row">
                <div class="col-md-4">
                    <label for="keywords">palavras chaves(coloque os termos separados por virgula)</label>
                    
                    
                    <textarea name="keywords" id="keyword" >
                              <?php print_r(trim(implode(',', $kw))); ?>
                    </textarea>

                </div>

                <div class="col-md-4" id="mmunicipio">

                    <h2>municipio</h2>


                    <label>
                        @foreach ($cidades as $c)
                            <input type="radio" style="appearance: auto!important; -webkit-appearance: auto!important;"
                                name="cidade" value="{{ $c->id }}"
                                @if ($doc->Cidade && $doc->Cidade->id == $c->id) checked @endif>
                            {{ $c->municipio }}
                        @endforeach
                    </label>


                </div>


                <div class="col-md-4">
                    <label for="link">link</label>
                    <input type="text" name="link" id="link" class="form-control" value="{{ $doc->link }}"
                        required>
                </div>
            </div>



            <button type="submit" class="btn btn-primary mt-3">Cadastrar</button>
        </form>
    </div>
@endsection





@section('footer')
@endsection
