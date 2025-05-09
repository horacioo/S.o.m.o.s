@extends('somos.layout.template')
@section('css')
    <style>
        #meuMapa {
            border: 1px solid red;
            height: 30vh;
            width: 70vw;
        }
    </style>
@endsection


@section('content')
    <form>
        <input type="hidden" name="csrfToken" id="csrfToken" value="{{ csrf_token() }}">
        <ul>
            <li>Área
                <ul>
                    <li>Coordenadas
                        <ul>
                            <li id="grauDecimal">Grau Decimal</li>
                            <li id="PesquisaGMD">Grau/minuto Decimal</li>
                            <li id="PesquisaGMS">Grau/Minuto/Segundo</li>
                        </ul>
                    </li>
                    <li id="mapaClick">Selecionar no mapa</li>
                    <li>Municipio
                        <div id="cidade">



                            Escolha a cidade:
                            <select id="cidades">
                                <option value="#">selecione uma opção</option>
                                @foreach ($cidades as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('cidade_id') == $item->id ? 'selected' : '' }}>
                                        {{ ucfirst($item->municipio) }}
                                    </option>
                                @endforeach
                            </select>



                            <!--<button id="pesquisaCidade">Pesquisa</button>-->
                        </div>
                    </li>
                    <!---<li>Não definir área</li>-->
                </ul>
            </li>
            <li>Período
                <ul>
                    <li>Definir Período
                        <div>
                            Inicio<input type="date" id="date1">
                            Fim:<input type="date" id="date2">
                        </div>
                    </li>
                    <!--<li>Não definir Período</li>-->
                </ul>
            </li>
            <li>Tópico
                <ul>
                    <li> Teses/Dissertações
                        <ul>
                            <li>PPG-BEMC
                                <ul>
                                    <li>tese</li>
                                    <li>dissertações</li>
                                </ul>
                            </li>
                            <li>PPG-ICTMAR
                                <ul>
                                    <li>tese</li>
                                    <li>dissertações</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </form>

    <div id="meu_Mapa"></div>
@endsection







@section('footer')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>-->

    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />


    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.bundle.min.js"></script>-->






    <script>
        jQuery(document).ready(function() {
            // Oculta todos os <ul> e <div> filhos de <li>
            jQuery('ul li ul, ul li div').hide();

            // Ao clicar em um <li>
            jQuery('ul li').click(function(e) {
                e.stopPropagation(); // Impede que o clique afete pais

                // Fecha todos os <ul> e <div> dentro deste <li>
                ///jQuery(this).find('ul, div').slideUp();

                // Alterna exibição apenas dos filhos diretos (se estiverem ocultos)
                jQuery(this).children('ul, div').not(':visible').slideDown();
            });
        })
    </script>



    <script>
        jQuery("#cidades").change(function() {
            var valor = jQuery(this).val(); // valor selecionado
            console.log("Valor selecionado: " + valor);

            // Aqui usamos um valor fictício (ex: __ID__) para depois substituir
            var baseUrl = "{{ route('coord.pedaco.municipio', ['municipio' => '__ID__']) }}";

            // Substitui '__ID__' pelo valor real
            var urlMunicipio = baseUrl.replace('__ID__', valor);

            console.log("URL montada: " + urlMunicipio);

            // Carrega o conteúdo da rota no elemento
            jQuery("#meu_Mapa").empty().off().load(urlMunicipio);
        });
    </script>






    <script>
        setInterval(() => {
            const data1x = jQuery("#date1").val();
            const data2x = jQuery("#date2").val();

            if (data1x !== "" && data2x !== "") {
                window.sessionStorage.setItem('date1', data1x);
                window.sessionStorage.setItem('date2', data2x);
                /******/
                var baseUrl = "{{ route('coord.pedaco.data', ['data' => '__ID__']) }}";
                var datas = btoa(data1x+"*"+data2x);
                var urldatas = baseUrl.replace('__ID__', datas);
                console.log(urldatas);

                jQuery("#meu_Mapa").empty().off().load(urldatas);
                /**********************************/
                jQuery("#date1").val('');
                jQuery("#date2").val('');
                /**********************************/
            }

        }, 500);
    </script>



    <script>
        jQuery("#grauDecimal").click(function() {
            window.sessionStorage.setItem("tipo", "1");
            jQuery("#meu_Mapa").empty().off().load("http://127.0.0.1:8000/bloco/decimal");
        });
    </script>

    <script>
        jQuery("#PesquisaGMD").click(function() {
            window.sessionStorage.setItem("tipo", "2");
            jQuery("#meu_Mapa").empty().off().load("http://127.0.0.1:8000/bloco/decimal");
        });
    </script>

    <script>
        jQuery("#PesquisaGMS").click(function() {
            window.sessionStorage.setItem("tipo", "3");
            jQuery("#meu_Mapa").empty().off().load("http://127.0.0.1:8000/bloco/decimal");
        });
    </script>

    <script>
        jQuery("#mapaClick").click(function() {
            jQuery("#meu_Mapa").html("");
            jQuery("#meu_Mapa").empty().off().load("http://127.0.0.1:8000/bloco/desenhaMapa");
        });

        let ultimoValor = sessionStorage.getItem("coordCript");

        setInterval(() => {
            const valorAtual = sessionStorage.getItem("coordCript");

            // Certifique-se que o valor não é nulo e diferente
            if (valorAtual && valorAtual !== ultimoValor) {
                console.log("Valor mudou para:", valorAtual);
                ultimoValor = valorAtual;

                jQuery("#meu_Mapa").html("");
                jQuery("#meu_Mapa").empty().off().load("http://127.0.0.1:8000/bloco/mapaselecao/" + valorAtual);
            }
        }, 500);
    </script>
@endsection
