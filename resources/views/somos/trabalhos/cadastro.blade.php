@extends('somos.layout.template')




@section('css')
    <link rel="stylesheet" href="{{ asset('css/somos/css/trabalhos/style_cad.css') }}" media="all">
@endsection




@section('content')
    <div class="container formulário">


        <h2>Cadastro de Documentos</h2>
        <form id="formularioBase" action="{{ route('trabalhos.api.cadastro') }}" method="POST">
            <input type="hidden" name="usuario" id="usuario" value="{{ $usuario }}">
            <input type="hidden" name="csrfToken" id="csrfToken" value="{{ csrf_token() }}">
            <meta name="csrf-token" content="{{ csrf_token() }}">
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


                <div class="col-md-2">
                    <label class="form-label" for="data_deposito">logintude</label>
                    <input required='require' type="text" name="latitude" id="latitude" class="form-control">
                </div>


                <div class="col-md-2">
                    <label class="form-label" for="data_deposito">latitude</label>
                    <input required='require' type="text" id="longitude" name="longitude" class="form-control">
                </div>


                <div class="col-md-2">
                    <label class="form-label" for="data_deposito">tipo de amostra</label>
                    <select required='require' class="form-control" id="amostras">
                        @foreach ($amall as $Amos)
                            <option value={{ $Amos->id }}>
                                {{ $Amos->tipoDeAmostra }}
                            </option>
                        @endforeach
                    </select>
                </div>



                <div class="col-md-2">
                    <label class="form-label"  for="data_deposito">tipo de Coordenadas</label>
                    <select required='require'  class="form-control" id="tipoCorrdenada">
                        <option value="1"> Decimal </option>
                        <option value="2">Grau, Minuto, Decimal(Gmd) </option>
                        <option value="3">Grau, Minuto, Segundo Decimal(gms) </option>
                    </select>
                </div>



                <div class="col-md-2">
                    <input type="submit" value="Cadastrar">
                </div>
            </div>
        </form>

        <div class="row">
            <table id="listaDeColetas" class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <td>registro</td>
                        <td>logintude</td>
                        <td>latitude</td>
                        <td>amostra</td>
                        <td>excluir</td>
                    </tr>
                </thead>
                <tbody>
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
        jQuery("#formularioBase").submit(function(e) {
            e.preventDefault();

            // Obtendo os dados do sessionStorage e convertendo de volta para um array
            var coletasArray = JSON.parse(window.sessionStorage.getItem("Amostras"));
            console.log(coletasArray);

            // Pegando todos os campos do formulário e serializando
            var formularioData = jQuery(this).serializeArray();
            console.log(formularioData);

            // Adicionando coletasArray aos dados do formulário com a chave 'coletas'
            formularioData.push({
                name: 'coletas',
                value: JSON.stringify(coletasArray)
            });

            console.log(formularioData); // Para ver os dados finais (formulário + coletas)

            // Obtendo o valor da ação do formulário
            var actionValue = jQuery("#formularioBase").attr("action");
            console.log(actionValue);
            var url = actionValue; // Defina a URL correta aqui

            var csrfToken = jQuery("#csrfToken").val(); // Defina o CSRF Token correto aqui

            var jq = jQuery.noConflict(); // Evita conflito com outras bibliotecas
            jq.ajax({
                url: url,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: formularioData, // Envia os dados concatenados do formulário e coletasArray
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log("Erro ao enviar os dados.");
                    console.log(error);
                }
            });
        });
    </script>









    <script>
        let listaDadosAmostras = [];

        @foreach ($amall as $Amos)
            listaDadosAmostras.push({
                id: {{ $Amos->id }},
                nome: "{{ $Amos->tipoDeAmostra }}" // Adicionado aspas para evitar erros em strings
            });
        @endforeach

        // Armazena a lista no sessionStorage convertendo para JSON
        window.sessionStorage.setItem("AmostrasDefinicao", JSON.stringify(listaDadosAmostras));

        console.log("Amostras salvas:", listaDadosAmostras); // Para depuração
    </script>
    <!---------------------------------------->
    <!---------------------------------------->
    <!---------------------------------------->

    <script>
        $(document).ready(function() {

            let amostras = [];
            window.sessionStorage.setItem("Amostras", amostras);

            var csrfToken = $("meta[name='csrf-token']").attr("content");

            var url = "{{ route('trabalhos.api.cadastro') }}"; // Define a URL correta
            console.log(url);

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

                /********************salvando as coletas****************************/

                // Obtém os valores do formulário
                var latitude = jQuery("#latitude").val();
                var longitude = jQuery("#longitude").val();
                var amostra = jQuery("#amostras").val();

                // Verifica se já existe um array válido no sessionStorage
                var amostras = [];
                var armazenado = sessionStorage.getItem("Amostras");

                if (armazenado) {
                    try {
                        amostras = JSON.parse(armazenado) || [];
                    } catch (e) {
                        console.error("Erro ao analisar JSON do sessionStorage:", e);
                        amostras = [];
                    }
                }

                amostras.push({
                    latitude: latitude,
                    longitude: longitude,
                    amostra: amostra
                });

                sessionStorage.setItem("Amostras", JSON.stringify(amostras));
                console.log("Dados armazenados:", amostras);
                listarDados();
                /**********************************************************************************/


                /*
                 */

            });
        });
    </script>
    <script>
        jQuery("#close").click(
            function() {
                jQuery("#telaDeColetas").hide();
                jQuery("#coleta").val('#');
            }
        )
    </script>
    <script>
        function listarDados() {
            console.log("Entrando na função e preenchendo a tabela");

            var armazenado = sessionStorage.getItem("Amostras");

            if (!armazenado) {
                console.log("Nenhuma amostra encontrada.");
                return;
            }

            var amostras = JSON.parse(armazenado);

            // Pega os dados de "AmostrasDefinicao" para comparar os ids
            var amostrasDefinicao = JSON.parse(sessionStorage.getItem("AmostrasDefinicao")) || [];

            // Seleciona o tbody da tabela
            var lista = jQuery("#listaDeColetas tbody");
            lista.empty(); // Limpa o conteúdo antes de adicionar novos itens

            amostras.forEach(function(amostra, index) {
                // Procura pelo nome que corresponde ao id de amostra
                var nomeAmostra = "Não encontrado"; // Valor padrão caso não encontre
                amostrasDefinicao.forEach(function(definicao) {
                    if (definicao.id == amostra.amostra) {
                        nomeAmostra = definicao.nome;
                    }
                });

                lista.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${amostra.latitude}</td>
                    <td>${amostra.longitude}</td>
                    <td>${nomeAmostra}</td> <!-- Exibe o nome encontrado -->
                    <td>
                        <button onclick="removerAmostra(${index})">Remover</button>
                    </td>
                </tr>
            `);
            });

            // Limpa os campos de latitude e longitude após a inserção
            jQuery("#latitude").val('');
            jQuery("#longitude").val('');
        }
    </script>

    <script>
        function removerAmostra(index) {
            console.log(`Removendo amostra de índice: ${index}`);
            var armazenado = sessionStorage.getItem("Amostras");
            if (!armazenado) {
                console.log("Nenhuma amostra encontrada para remover.");
                return;
            }
            var amostras = JSON.parse(armazenado);
            // Remove o item pelo índice
            amostras.splice(index, 1);
            // Atualiza o sessionStorage com a nova lista
            sessionStorage.setItem("Amostras", JSON.stringify(amostras));
            // Atualiza a tabela na tela
            listarDados();
        }
    </script>


    <!------------------------------------------>
    <!------------------------------------------>
    <script>
        jQuery(document).ready(function() {
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            var urlValidacao = "{{ route('coord.api.valida') }}";

            console.log(jQuery("#tipoCorrdenada").val());


            function formData() {
                return {
                    _token: csrfToken,
                    latitude: jQuery("#latitude").val(),
                    longitude: jQuery("#longitude").val(),
                    Coord: jQuery("#tipoCorrdenada").val()
                };
            }

            function enviarDadosParaValidacao() {
                console.log("teste");

                var dataToSend = formData();

                jQuery.ajax({
                    url: urlValidacao,
                    type: 'GET',
                    data: dataToSend,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        console.log("Sucesso:", response)
                        var dados = response;
                        jQuery("#latitude").val(dados['latitude']);
                        jQuery("#longitude").val(dados['longitude']);
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro:", status, error, xhr);
                        // Adicione aqui a lógica para lidar com erros
                    }
                });
            }

            // Anexa event listeners para o evento 'input' dos campos
            jQuery("#latitude").on("keyup", enviarDadosParaValidacao)
            jQuery("#longitude").on("keyup", enviarDadosParaValidacao)
            jQuery("#tipoCorrdenada").on("change", enviarDadosParaValidacao)


        });
    </script>
    <!---------------------------------------->
    <!---------------------------------------->
    <!---------------------------------------->
@endsection
