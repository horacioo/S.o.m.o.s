@extends('somos.layout.template')




@section('css')
    <link rel="stylesheet" href="{{ asset('css/somos/css/trabalhos/style_cad.css') }}" media="all">
@endsection




@section('content')
    <div class="container formulário">
        <h2>Cadastro de Documentos</h2>
        <form action="{{ route('TrabalhosCadastrosSave') }}" method="POST">
            @csrf



            <div class="row">
                <div class="col-md-4">
                    <label for="programa">Programa</label>
                    <input type="text" name="programa" id="programa" class="form-control" value="{{ old('programa') }}"
                        required>
                </div>
                <div class="col-md-4">
                    <label for="tipo_do_documento">Tipo do Documento</label>
                    <input type="text" name="tipo_do_documento" id="tipo_do_documento" class="form-control"
                        value="{{ old('tipo_do_documento') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}"
                        required>
                </div>
            </div>



            <div class="row">
                <div class="col-md-4">
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}"
                        required>
                </div>
                <div class="col-md-4">
                    <label for="autor">Autor</label>
                    <input type="text" name="autor" id="autor" class="form-control" value="{{ old('autor') }}"
                        required>
                </div>
                <div class="col-md-4">
                    <label for="citacao">Citação</label>
                    <input type="text" name="citacao" id="citacao" class="form-control" value="{{ old('citacao') }}"
                        required>
                </div>
            </div>



            <div class="row">
                <div class="col-md-4">
                    <label for="orientador">Orientador</label>
                    <input type="text" name="orientador" id="orientador" class="form-control"
                        value="{{ old('orientador') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="data_deposito">Data de Depósito</label>
                    <input type="date" name="data_deposito" id="data_deposito" class="form-control"
                        value="{{ old('data_deposito') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="coleta">Coleta</label>
                    <!--<input type="check" name="coleta" id="coleta" class="form-control" value="{{ old('coleta') }}">-->
                    <select class="form-control" id="coleta">
                        <option value="#">Escolha</option>
                        <option value="1">sim</option>
                        <option value="0">não</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="keywords">palavras chaves(coloque os termos separados por virgula)</label>
                    <textarea type="text" name="keywords" id="keyword" class="form-control" value="{{ old('keywords') }}" required></textarea>
                </div>
                <div class="col-md-6">
                    <label for="link">link</label>
                    <input type="text" name="link" id="link" class="form-control" value="{{ old('coleta') }}"
                        required>
                </div>
            </div>



            <button type="submit" class="btn btn-primary mt-3">Cadastrar</button>
        </form>
    </div>






    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------->
    <div id="telaDeColetas" class="row">
        <form id="coletasForm">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label" for="data_deposito">logintude</label>
                    <input type="text" name="latitude" id="latitude" class="form-control">

                </div>

                <div class="col-md-3">
                    <label class="form-label" for="data_deposito">latitude</label>
                    <input type="text" name="longitude" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label" for="data_deposito">tipo de amostra</label>
                    <select class="form-control" id="amostras">
                        @foreach ($amall as $Amos)
                            <option value={{ $Amos->id }}>
                                {{ $Amos->tipoDeAmostra }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="submit" value="Cadastrar">
                </div>
            </div>
        </form>

        <div class="row">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <td>logintude</td>
                        <td>latitude</td>
                        <td>amostra</td>
                        <td>editar</td>
                        <td>excluir</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>logintude</td>
                        <td>latitude</td>
                        <td>amostra</td>
                        <td>editar</td>
                        <td>excluir</td>
                    </tr>


                    <tr>
                        <td>logintude</td>
                        <td>latitude</td>
                        <td>amostra</td>
                        <td>editar</td>
                        <td>excluir</td>
                    </tr>
                </tbody>
            </table>
            <span id="close">Fechar</span>
        </div>

    </div>
    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------->
@endsection


@section('footer')
    <script>
    
    
    $(document).ready(function() {
    $("#telaDeColetas").hide();

    $("#coleta").change(function() {
        if ($(this).val() === "1") { // Se "sim" (valor 1) for selecionado
            $("#telaDeColetas").show();
        } else { // Se "não" (valor 0) for selecionado
            $("#telaDeColetas").hide();
        }
    });

    $('#coletasForm').submit(function(e) {
        e.preventDefault(); // Corrigido de e.eventprevent();

        var latitude = $(this).find("#latitude").val();
        var longitude = $(this).find("#longitude").val(); // Corrigido de "#logitude"
        var amostras = $(this).find("#amostras").val();

        var url = "absc.php"; // Define a URL correta

        $.ajax({
            url: url, // Corrigido: agora usa a variável corretamente
            type: "POST",
            data: {
                latitude: latitude,
                longitude: longitude,
                amostras: amostras
            },
            success: function(response) {
                alert("Dados enviados com sucesso!");
                console.log(response);
            },
            error: function(error) {
                alert("Erro ao enviar os dados.");
                console.log(error);
            }
        });
    });
});




    </script>
@endsection
