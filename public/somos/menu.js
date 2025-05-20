 jQuery(document).ready(function() {});


        function verificarLarguraTela() {
            if (window.innerWidth > 768.5) {
                // Ações para telas maiores que 1369 pixels
                console.log("Tela maior que 768px");
                jQuery('nav').show();
            } else {

                console.log("Tela menor ou igual a 768px");
                jQuery('body').append('<div id="fundaoMenu"> fundo </div>');
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