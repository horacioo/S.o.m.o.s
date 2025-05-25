@extends('somos.layout.template')


@section('title')
    aqui é a somos oceano
@endsection


@section('css')
    <link rel="stylesheet" href="{{ asset('css/somos/home/desktop.css') }}" media="all">
@endsection






<!------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------->
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

    @include('somos.layout.partes.menu')

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

    @include('somos.layout.partes.textoRapido2')

    <section id="teste"></section>
@endsection
<!------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------->



@section('footer')
    <!-------------------------------------------------------------------->
    <!-------------------------------------------------------------------->
    <!-------------------------------------------------------------------->
    <!-------------------------------------------------------------------->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const itens = document.querySelectorAll('#MeusCards li');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const index = Array.from(itens).indexOf(entry.target);
                        setTimeout(() => {
                            entry.target.classList.add('aparece');
                        }, index * 500);
                    } else {
                        entry.target.classList.remove('aparece');
                    }
                });
            }, {
                threshold: 0.1
            });

            itens.forEach(item => observer.observe(item));
        });
    </script>

    <!-------------------------------------------------------------------->
    <!-------------------------------------------------------------------->
    <!-------------------------------------------------------------------->
    <!-------------------------------------------------------------------->

    <script>
        jQuery(document).ready(function() {});


        function verificarLarguraTela() {
            if (window.innerWidth > 768.5) {
                // Ações para telas maiores que 1369 pixels
                console.log("Tela maior que 768px");
                jQuery('nav').show();
                jQuery('#fundaoMenu').remove();
            } else {

                console.log("Tela menor ou igual a 768px");
                jQuery('#fundaoMenu').remove();
                jQuery('body').append('<div id="fundaoMenu"> </div>');
                jQuery('nav').hide();
                jQuery('#hamburguer').click(function() {
                    jQuery('#fundaoMenu').addClass('menunBackground');
                    jQuery('nav').addClass('showMenu');
                    jQuery('nav').show();
                })



                jQuery('#fundaoMenu').click(function() {

                    jQuery("nav").removeClass('showMenu');
                    jQuery("nav").addClass('FechaMenu');

                    jQuery('#fundaoMenu').removeClass('menunBackground');



                    setTimeout(() => {
                        jQuery("nav").removeClass('FechaMenu');
                        jQuery("nav").hide();
                        jQuery('#fundaoMenu').removeClass('menunBackground');
                        //jQuery('#fundaoMenu').hide();
                        console.log("fechando tudo")
                    }, 1500);
                })


            }
        }
        verificarLarguraTela();
        window.addEventListener('resize', verificarLarguraTela);
    </script>
    <!-------------------------------------------------------------------->
    <!-------------------------------------------------------------------->
    <!-------------------------------------------------------------------->
    <!-------------------------------------------------------------------->


    <script>
        const horse = document.getElementById('horse');

        // 🧭 Ajustes de centralização do cavalo em relação ao cursor
        const offsetX = horse.offsetWidth / 2;
        const offsetY = horse.offsetHeight / 2;

        // 📌 Posição inicial do cavalo na tela (usada como origem para retorno e limites)
        const horseRect = horse.getBoundingClientRect();
        const originX = horseRect.left;
        const originY = horseRect.top;

        // 🎯 Coordenadas de movimento
        let currentX = originX;
        let currentY = originY;
        let targetX = originX;
        let targetY = originY;

        // 🔄 Flags de controle de retorno e "jitter" (movimento aleatório ao voltar)
        let isReturning = false;
        let hasJitter = false;
        let mouseIdleTimer = null;

        // Inicializa a posição do cavalo
        horse.style.transform = `translate(0px, 0px)`;

        // 🚀 VELOCIDADE DE MOVIMENTO (ajuste principal)
        const speed = 0.000000172;
        // 💡 Valor entre 0 e 1 — quanto maior, mais rápido o movimento
        // Ex: 0.05 = lento, 0.5 = moderado, 1 = muito rápido
        // OBS: Esse valor é usado para calcular os fatores de suavidade abaixo

        // 🎛️ Limites de suavidade para interpolação
        const MAX_SMOOTHNESS = 0.115; // suavidade máxima possível
        const MIN_SMOOTHNESS = 0.01; // suavidade mínima (mais lento)

        // 🔁 Suavidade real usada no movimento ativo (mouse em movimento)
        const MOVE_SMOOTHNESS = MIN_SMOOTHNESS + (MAX_SMOOTHNESS - MIN_SMOOTHNESS) * speed;

        // 🔁 Suavidade usada no retorno automático (quando mouse para)
        const RETURN_SMOOTHNESS = MOVE_SMOOTHNESS * 0.5;
        // Quanto menor, mais suave/lento é o retorno

        // 🎯 DISTÂNCIA MÁXIMA permitida do cavalo em relação à origem
        const MAX_DISTANCE = 100;
        // Evita que o cavalo "corra demais" atrás do cursor

        // ⏱️ TEMPO DE INATIVIDADE para disparar o retorno (em milissegundos)
        const IDLE_TIMEOUT = 1000;
        // Ex: 1000 = 1 segundo parado para voltar

        // 🌀 Função que gera um deslocamento aleatório entre [min, max] em px
        const getRandomOffset = (min, max) => {
            const magnitude = Math.floor(Math.random() * (max - min + 1)) + min;
            return Math.random() < 0.5 ? -magnitude : magnitude;
        };

        // 🖱️ Listener de movimento do mouse
        document.addEventListener('mousemove', (event) => {
            const mouseX = event.clientX - offsetX;
            const mouseY = event.clientY - offsetY;

            const dx = mouseX - originX;
            const dy = mouseY - originY;
            const distance = Math.sqrt(dx * dx + dy * dy);

            if (distance > MAX_DISTANCE) {
                // Limita a distância máxima com base no ângulo
                const angle = Math.atan2(dy, dx);
                targetX = originX + Math.cos(angle) * MAX_DISTANCE;
                targetY = originY + Math.sin(angle) * MAX_DISTANCE;
            } else {
                // Alvo é diretamente onde o mouse está (dentro do limite)
                targetX = mouseX;
                targetY = mouseY;
            }

            // Resetando os estados de retorno e jitter
            isReturning = false;
            hasJitter = false;

            // Reinicia o temporizador de inatividade
            clearTimeout(mouseIdleTimer);
            mouseIdleTimer = setTimeout(() => {
                isReturning = true;

                // Aplica "jitter" uma única vez por retorno
                if (!hasJitter) {
                    const jitterX = getRandomOffset(5, 20); // movimentação aleatória horizontal
                    const jitterY = getRandomOffset(5, 20); // movimentação aleatória vertical
                    targetX = originX + jitterX;
                    targetY = originY + jitterY;
                    hasJitter = true;
                }
            }, IDLE_TIMEOUT);
        });

        // 🌀 Loop de animação contínuo com requestAnimationFrame
        function animate() {
            const smoothness = isReturning ? RETURN_SMOOTHNESS : MOVE_SMOOTHNESS;

            // Interpolação suave (easing manual)
            currentX += (targetX - currentX) * smoothness;
            currentY += (targetY - currentY) * smoothness;

            // Aplicação do deslocamento via transform
            const dx = currentX - originX;
            const dy = currentY - originY;

            horse.style.transform = `translate(${dx}px, ${dy}px)`;

            requestAnimationFrame(animate);
        }

        animate();
    </script>
@endsection
