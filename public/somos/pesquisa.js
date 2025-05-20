jQuery(document).ready(function () {
    // Oculta todos os <ul> e <div> filhos de <li>
    jQuery("ul li ul, ul li div").hide();

    // Ao clicar em um <li>
    jQuery("ul li").click(function (e) {
        e.stopPropagation(); // Impede que o clique afete pais

        // Fecha todos os <ul> e <div> dentro deste <li>
        ///jQuery(this).find('ul, div').slideUp();

        // Alterna exibição apenas dos filhos diretos (se estiverem ocultos)
        jQuery(this).children("ul, div").not(":visible").slideDown();
    });
});

jQuery("#cidades").change(function () {
    var valor = jQuery(this).val(); // valor selecionado
    console.log("Valor selecionado: " + valor);

    // Aqui usamos um valor fictício (ex: __ID__) para depois substituir
    var baseUrl =
        "{{ route('coord.pedaco.municipio', ['municipio' => '__ID__']) }}";

    // Substitui '__ID__' pelo valor real
    var urlMunicipio = baseUrl.replace("__ID__", valor);

    console.log("URL montada: " + urlMunicipio);

    // Carrega o conteúdo da rota no elemento
    jQuery("#meu_Mapa").empty().off().load(urlMunicipio);
});

setInterval(() => {
    const data1x = jQuery("#date1").val();
    const data2x = jQuery("#date2").val();

    if (data1x !== "" && data2x !== "") {
        window.sessionStorage.setItem("date1", data1x);
        window.sessionStorage.setItem("date2", data2x);
        /******/
        var baseUrl = "{{ route('coord.pedaco.data', ['data' => '__ID__']) }}";
        var datas = btoa(data1x + "*" + data2x);
        var urldatas = baseUrl.replace("__ID__", datas);
        console.log(urldatas);

        jQuery("#meu_Mapa").empty().off().load(urldatas);
        /**********************************/
        jQuery("#date1").val("");
        jQuery("#date2").val("");
        /**********************************/
    }
}, 500);

jQuery("#grauDecimal").click(function () {
    window.sessionStorage.setItem("tipo", "1");
    jQuery("#meu_Mapa")
        .empty()
        .off()
        .load("http://127.0.0.1:8000/bloco/decimal");
});

jQuery("#PesquisaGMD").click(function () {
    window.sessionStorage.setItem("tipo", "2");
    jQuery("#meu_Mapa")
        .empty()
        .off()
        .load("http://127.0.0.1:8000/bloco/decimal");
});

jQuery("#PesquisaGMS").click(function () {
    window.sessionStorage.setItem("tipo", "3");
    jQuery("#meu_Mapa")
        .empty()
        .off()
        .load("http://127.0.0.1:8000/bloco/decimal");
});

jQuery("#mapaClick").click(function () {
    jQuery("#meu_Mapa").html("");
    jQuery("#meu_Mapa")
        .empty()
        .off()
        .load("http://127.0.0.1:8000/bloco/desenhaMapa");
});

let ultimoValor = sessionStorage.getItem("coordCript");

setInterval(() => {
    const valorAtual = sessionStorage.getItem("coordCript");

    // Certifique-se que o valor não é nulo e diferente
    if (valorAtual && valorAtual !== ultimoValor) {
        console.log("Valor mudou para:", valorAtual);
        ultimoValor = valorAtual;

        jQuery("#meu_Mapa").html("");
        jQuery("#meu_Mapa")
            .empty()
            .off()
            .load("http://127.0.0.1:8000/bloco/mapaselecao/" + valorAtual);
    }
}, 500);
