<script>
    var tipo = window.sessionStorage.getItem('tipo');

    jQuery(".form").hide();

    if (tipo == 1) {
        jQuery(".form").hide();
        jQuery("#tipo1").show();
    }

    if (tipo == 2) {
        jQuery(".form").hide();
        jQuery("#tipo2").show();
    }

    if (tipo == 3) {
        jQuery(".form").hide();
        jQuery("#tipo3").show();
    }



    jQuery('.closeDiv').click(function() {
            console.log("só teste");
            jQuery(this).closest('.form').fadeOut();
        });
        

</script>


<div class="form " id="tipo1">
    <span class="closeDiv">X</span>
    <div class="coordenada1" id="coord1"> Coord 1 <input class="input1" type="text" id="grauDecimal1"></div>
    <div class="coordenada2" id="coord2">Coord 2 <input class="input2" type="text" id="grauDecimal2"> </div>
    <div class="buttom" id="Query1">Pesquisar</div>
</div>





<div class="form" id="tipo2">
    <span class="closeDiv">X</span>
    <div id="coord1">Coord 1<input class="input1" type="text" id="graudDecimalQuery1"></div>
    <div id="coord2">Coord 2<input class="input2" type="text" id="graudDecimalQuery2"></div>
    <div class="buttom" id="Query1">Pesquisar</div>
</div>



<div class="form " id="tipo3">
    <span class="closeDiv">X</span>
    <div id="coord1">Coord 1 <input class="input1" type="text" id="grauDecimalSegundo1"></div>
    <div id="coord2">Coord 2 <input class="input2" type="text" id="grauDecimalSegundo2"></div>
    <div class="buttom" id="Query1">Pesquisar</div>
</div>






<script>
    jQuery(".buttom").click(function() {
        jQuery('ul li ul, ul li div').hide();
        var container = jQuery(this).closest(".form");
        var lat = container.find('.input1').val();
        var lng = container.find('.input2').val();
        var distancia = "100.00";


        tipo = window.sessionStorage.getItem('tipo');

        if (tipo == 2) {
            console.log("entrada " + lat);
            lat = dmToDecimal(lat);
            console.log("saida " + lat);
            console.log("entrada " + lng);
            lng = dmToDecimal(lng);
            console.log("saida " + lng);
        }

        if (tipo == 3) {
            console.log("entrada3 " + lat);
            lat = dmsToDecimal(lat);
            console.log("saida3 " + lat);
            console.log("entrada3 " + lng);
            lng = dmsToDecimal(lng);
            console.log("saida3 " + lng);
        }



        var areaSelecionada = {
            lat: lat,
            lng: lng,
            raio_metros: distancia,
        };

        window.sessionStorage.setItem("cordenadasMapa", JSON.stringify(areaSelecionada));
        var base64String = btoa(JSON.stringify(areaSelecionada));
        window.sessionStorage.setItem('coordCript', base64String);

        console.log("valor sendo localizado: " + lat + " " + lng);
    });
</script>


<script>
    function dmsToDecimal(dmsString) {
        const regex = /^([+-]?)(\d{1,3})[°\s]+(\d{1,2})[′'\s]+([\d.]+)["″\s]*([NSEW])?$/i;
        const match = dmsString.trim().match(regex);

        if (!match) return NaN;

        const sign = match[1] === '-' ? -1 : 1;
        const degrees = parseInt(match[2], 10);
        const minutes = parseInt(match[3], 10);
        const seconds = parseFloat(match[4]);
        const direction = match[5] ? match[5].toUpperCase() : null;

        let decimal = degrees + minutes / 60 + seconds / 3600;

        if (direction === 'S' || direction === 'W') {
            decimal *= -1;
        } else {
            decimal *= sign;
        }

        return decimal;
    }
</script>







<script>
    function dmToDecimal(dmString) {
        const regex = /^([+-]?)(\d{1,3})[°\s]+([\d.]+)['\s]*([NSEW])?$/i;
        const match = dmString.trim().match(regex);

        if (!match) return NaN;

        const sign = match[1] === '-' ? -1 : 1;
        const degrees = parseInt(match[2], 10);
        const minutes = parseFloat(match[3]);
        const direction = match[4] ? match[4].toUpperCase() : null;

        let decimal = degrees + minutes / 60;

        if (direction === 'S' || direction === 'W') {
            decimal *= -1;
        } else {
            decimal *= sign;
        }

        return decimal;
    }
</script>


<script>
    /*jQuery(".buttom").click(function(){
    var container = jQuery(this).closest(".form");
    var lat = container.find('.input1').val();
    var lng = container.find('.input2').val();
    distancia= "100.00";
    var areaSelecionada = {
            lat: lat,
            lng: lng,
            raio_metros: distancia,
    };
    window.sessionStorage.setItem( "cordenadasMapa", JSON.stringify(areaSelecionada) );
    var base64String = btoa(JSON.stringify(areaSelecionada));
    window.sessionStorage.setItem('coordCript', base64String );

    console.log("valor sendo localizado: " + valor1 + " " + valor2);
});*/
</script>



<script>
    var decimalMask = new Inputmask({
        mask: "[-|+]9{1,3}.9{1,6}", // Permitindo sinal de + ou - no início
        greedy: false,
        allowMinus: true, // Permite o sinal de negativo
        allowPlus: true, // Permite o sinal de positivo
        placeholder: "", // Sem placeholder
        rightAlign: false, // Alinha à esquerda
        autoGroup: false, // Não utiliza agrupamento
        definitions: {
            '9': {
                validator: "[0-9]", // Permite apenas números
                cardinality: 1
            }
        }
    });

    // Aplica a máscara aos campos
    decimalMask.mask(document.getElementById("grauDecimal1"));
    decimalMask.mask(document.getElementById("grauDecimal2"));
</script>




<script>
    // Aplica a máscara para o formato de coordenadas "43° 12.629' W"
    var coordenadaMask = new Inputmask({
        mask: "99° 99.999' [A|S|E|W]",
        greedy: false,
        allowMinus: true,
        placeholder: "",
        definitions: {
            '9': {
                validator: "[0-9]",
                cardinality: 1
            },
            'A': {
                validator: "[NSEW]",
                cardinality: 1
            },
            'S': {
                validator: "[NSEW]",
                cardinality: 1
            },
            'E': {
                validator: "[NSEW]",
                cardinality: 1
            },
            'W': {
                validator: "[NSEW]",
                cardinality: 1
            }
        }
    });

    coordenadaMask.mask(document.getElementById("graudDecimalQuery1"));
    coordenadaMask.mask(document.getElementById("graudDecimalQuery2"));
</script>







<script>
    if (typeof decimalMask === 'undefined') {
        var decimalMask = new Inputmask({
            mask: "[+|-]9{1,3}° 9{1,6}′ 9{1,6}.9″",
            greedy: false,
            allowMinus: true,
            placeholder: "",
            definitions: {
                '9': {
                    validator: "[0-9]",
                    cardinality: 1
                }
            }
        });

        // Aplica a máscara aos campos
        decimalMask.mask(document.getElementById("graudSegundos"));
        decimalMask.mask(document.getElementById("graudSegundos2"));
    }
</script>





<script>
    jQuery(function($) {
        // Configuração da máscara para coordenadas no formato "22° 57′ 06.9″ S"
        var maskOptions = {
            mask: "[+|-]99° 99′ 99.9″ [N|S|E|W]",
            greedy: false,
            placeholder: "0",
            definitions: {
                '9': {
                    validator: "[0-9]",
                    cardinality: 1
                },
                'N': {
                    validator: "[NS]",
                    cardinality: 1,
                    casing: "upper"
                },
                'S': {
                    validator: "[NS]",
                    cardinality: 1,
                    casing: "upper"
                },
                'E': {
                    validator: "[EW]",
                    cardinality: 1,
                    casing: "upper"
                },
                'W': {
                    validator: "[EW]",
                    cardinality: 1,
                    casing: "upper"
                }
            },
            onBeforePaste: function(pastedValue, opts) {
                // Remove espaços extras e ajusta o valor colado
                return pastedValue.trim().replace(/\s+/g, ' ');
            }
        };

        // Aplica a máscara aos campos de entrada
        $('#grauDecimalSegundo1').inputmask(maskOptions);
        $('#grauDecimalSegundo2').inputmask(maskOptions);
    });
</script>
