@extends('somos.layout.template')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/somos/pesquisa/style.css') }}" media="all">
@endsection


@section('content')
    @include('somos.layout.partes.menu')




    <section id="telaMae">
        <div id="meu_Mapa"></div>
        <div id="MinasPesquisas">

            <input type="hidden" name="csrfToken" id="csrfToken" value="{{ csrf_token() }}">
            <ul>
                <li class="itemList area" id="area"><span class='decoracaoLinks'>Área</span>
                    <ul class="submenu">
                    
                        <li><span class='decoracaoLinks'>Coordenadas</span>
                            <ul class="submenu">
                                
                                <li id="grauDecimal"><span class='decoracaoLinks ponta'>Grau Decimal</span></li>
                                <li id="PesquisaGMD"><span class='decoracaoLinks ponta'>Grau/minuto Decimal</span></li>
                                <li id="PesquisaGMS"><span class='decoracaoLinks ponta'>Grau/Minuto/Segundo</span></li>
                            </ul>
                        </li>
                        <li id="mapaClick"><span class='decoracaoLinks ponta'>Selecionar no mapa</span></li>
                        <li>
                            <span class='decoracaoLinks'>Municipio</span>
                            <div id="cidade" class="submenu">





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
                <li id="periodo" class="itemList periodo"><span class='decoracaoLinks'>Período</span>




                    <div class="submenu Periodo">
                        Inicio<input type="date" id="date1">
                        Fim:<input type="date" id="date2">
                        
                    </div>





                </li>
                <li  id="topicos" class="itemList  topicos">
                    <span class='decoracaoLinks topico'>Tópico</span>
                    <ul class="submenu">
                        <li> <span class="decoracaoLinks">Teses/Dissertações</span>
                            
                            <ul class="submenu">
                                <li><span class="decoracaoLinks">PPG-BEMC</span>
                                    <ul class="submenu submenu3">
                                       
                                        <li><span class="decoracaoLinks">tese</span></li>
                                        <li><span class="decoracaoLinks">dissertações</span></li>
                                    </ul>
                                </li>
                                <li><span class="decoracaoLinks">PPG-ICTMAR</span>
                                    <ul class="submenu  submenu3">
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

    <div id='fundao'></div>
@endsection







@section('footer')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />






    <style>
        .hide {
            display: none !important;
        }
        .fundo{ 
            width: 100%;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: rgba(0, 0, 0, 0.637); 
            z-index: 412;
        }
    </style>



    <script>
        jQuery(document).ready(function() {

            jQuery('.submenu,Periodo ').addClass("hide");
            jQuery('.itemList').click(function(e) {   jQuery(this).parent('li').children('.submenu').removeClass('hide');  });

        });

        jQuery('.area, .topico').click(function() {  jQuery(this).children('.submenu').removeClass('hide'); })









        jQuery(document).on('click', '.decoracaoLinks', function() {

            jQuery('#fundao').addClass('fundo');
            
            jQuery(this).parent().children('.submenu').removeClass("hide").addClass("opened");
            jQuery(this).closest('.submenu').removeClass('hide');
            jQuery(this).parent('li').parent().addClass('opened');

            
            setTimeout(function(){
                jQuery('.opened').removeClass('hide');
            }, 20);
        });



         jQuery(document).on('click', '#fundao', function() {   
            console.log("teste");
            jQuery('.submenu').addClass('hide').removeClass('opened');
            jQuery(this).removeClass('fundo');
         })



        jQuery(".OpenSubmenu").click(function() {
            alert("olá mundo");
        })


        jQuery('#meuMapa').on('DOMSubtreeModified', function() {  alert('A div "meuMapa" foi alterada!'); 
             jQuery('#fundao').removeClass('fundo');
            jQuery('.submenu').addClass('hide').removeClass('opened');
         })

        /**********a classe ponta é a última parte do menu******/
        jQuery('.ponta').click(function() {  setTimeout(() => {   
            jQuery('#fundao').removeClass('fundo');
            jQuery('.submenu').addClass('hide').removeClass('opened');  }, 200); 
            
                setTimeout(() => {
                jQuery('#fundao').addClass('fundo');    
                }, 0300);
               
        })







        /**********************************************************************************/
        /**********************************************************************************/
        /**********************************************************************************/
        /**********************************************************************************/
        /**********************************************************************************/
        /**********************************************************************************/



        jQuery("#cidades").change(function() {

            jQuery('.submenu').addClass('hide');
             jQuery('#fundao').removeClass('fundo');
            jQuery('.submenu').addClass('hide').removeClass('opened');

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


        setInterval(() => {
            const data1x = jQuery("#date1").val();
            const data2x = jQuery("#date2").val();

            if (data1x !== "" && data2x !== "") {
                window.sessionStorage.setItem('date1', data1x);
                window.sessionStorage.setItem('date2', data2x);

                var baseUrl = "{{ route('coord.pedaco.data', ['data' => '__ID__']) }}";
                var datas = btoa(data1x + "*" + data2x);
                var urldatas = baseUrl.replace('__ID__', datas);
                console.log(urldatas);

                jQuery("#meu_Mapa").empty().off().load(urldatas);

                jQuery("#date1").val('');
                jQuery("#date2").val('');

                jQuery('.submenu').addClass('hide');
                jQuery('#fundao').removeClass('fundo');

            }

        }, 500);



        jQuery("#grauDecimal").click(function() {
            window.sessionStorage.setItem("tipo", "1");
            jQuery("#meu_Mapa").empty().off().load("http://127.0.0.1:8000/bloco/decimal");
        });



        jQuery("#PesquisaGMD").click(function() {
            window.sessionStorage.setItem("tipo", "2");
            jQuery("#meu_Mapa").empty().off().load("http://127.0.0.1:8000/bloco/decimal");
        });



        jQuery("#PesquisaGMS").click(function() {
            window.sessionStorage.setItem("tipo", "3");
            jQuery("#meu_Mapa").empty().off().load("http://127.0.0.1:8000/bloco/decimal");
        });


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
