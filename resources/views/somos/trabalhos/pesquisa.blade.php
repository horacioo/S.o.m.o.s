@extends('somos.layout.template')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/somos/pesquisa/style.css') }}" media="all">
@endsection


@section('content')
    @include('somos.layout.partes.menu')




    <section id="telaMae">
        <div id="meu_Mapa"></div>
        <div id="MinasPesquisas" >

            <input type="hidden" name="csrfToken" id="csrfToken" value="{{ csrf_token() }}">
            <ul>
                <li class="itemList area"><span class='decoracaoLinks'>Área</span>
                    <ul class="submenu">
                        <span class="closeDiv">X</span>
                        <li><span class='decoracaoLinks'>Coordenadas</span>
                            <ul class="submenu">
                                <span class="closeDiv">X</span>
                                <li id="grauDecimal"><span class='decoracaoLinks'>CGrau Decimal</span></li>
                                <li id="PesquisaGMD"><span class='decoracaoLinks'>CGrau/minuto Decimal</span></li>
                                <li id="PesquisaGMS"><span class='decoracaoLinks'>CGrau/Minuto/Segundo</span></li>
                            </ul>
                        </li>
                        <li id="mapaClick"><span class='decoracaoLinks'>Selecionar no mapa</span></li>
                        <li>
                            <span class='decoracaoLinks'>Municipio</span>
                            <div id="cidade">





                                <select id="cidades">
                                    Escolha a cidade:
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
                <li class="itemList"><span class='decoracaoLinks'>Período</span>




                    <div class="submenu Periodo">
                        Inicio<input type="date" id="date1">
                        Fim:<input type="date" id="date2">
                        <span class="closeDiv">X</span>
                    </div>





                </li>
                <li class="itemList">
                    <span class='decoracaoLinks'>Tópico</span>
                    <ul class="submenu">
                        <li> <span class="decoracaoLinks">Teses/Dissertações</span>
                            <span class="closeDiv">X</span>
                            <ul>
                                <li><span class="decoracaoLinks">PPG-BEMC</span>
                                    <ul class="submenu">
                                        <span class="closeDiv">X</span>
                                        <li><span class="decoracaoLinks">tese</span></li>
                                        <li><span class="decoracaoLinks">dissertações</span></li>
                                    </ul>
                                </li>
                                <li><span class="decoracaoLinks">PPG-ICTMAR</span>
                                    <ul>
                                        <li><span class="decoracaoLinks">tese</span></li>
                                        <li><span class="decoracaoLinks">dissertações</span></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </section>
@endsection







@section('footer')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />







<script>


jQuery(document).ready(function () {
    jQuery('.itemList').click(function (e) {
        e.stopPropagation(); // Evita conflitos com cliques internos

        // Fecha todos os submenus
        jQuery('.submenu').slideUp(200);

        // Abre apenas o submenu direto desse pai
        jQuery(this).children('.submenu').stop(true, true).slideDown(200);
    });

    // Fecha o submenu mais próximo ao clicar no X
    jQuery(document).on('click', '.closeDiv', function (e) {
        e.stopPropagation(); // Evita reabrir ao clicar no X
        jQuery(this).closest('.submenu').slideUp();
    });
});


</script>





    <script>
        jQuery(document).ready(function() {

            Close()
            jQuery('ul li').click(function(e) {
                jQuery(this).children().show();
                e.stopPropagation();
            })
            //jQuery('ul li').click(function(e) {
            //   e.stopPropagation(); // Impede que o clique afete pais
            //   Query(this).children('ul, div').not(':visible').slideDown();
            //});
        })
    </script>



    <script>
        jQuery("#cidades").change(function() {
            //Close();
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
                var datas = btoa(data1x + "*" + data2x);
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


    <script src="{{ asset('somos/menu.js') }}"></script>










    <script>
        jQuery('.closeDiv').click(function() {
            console.log("só teste");
            jQuery(this).closest('.submenu').fadeOut();
        });



     



        jQuery('.area').click(function() {
            
            jQuery(this).children('.submenu').css({
                'z-index': '1000',
                'display': 'block'
            });
        })


        jQuery('#meuMapa').on('DOMSubtreeModified', function() {
            alert('A div "meuMapa" foi alterada!');
        })




        function Close() {
            jQuery('ul li ul, ul li div').hide();
        }
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alvo = document.getElementById('meu_Mapa');

            if (alvo) {
                const observador = new MutationObserver(function(mutationsList, observer) {
                    // Isso evita alertas repetidos rapidamente
                    console.log('A div "meuMapa" foi alterada!');
                    Close();
                });

                observador.observe(alvo, {
                    childList: true, // observa adição/rem. de elementos
                    subtree: true, // observa alterações internas
                    characterData: true // observa mudanças em texto
                });
            } else {
                console.warn('Elemento #meuMapa não encontrado no DOM.');
            }
        });
    </script>
@endsection
