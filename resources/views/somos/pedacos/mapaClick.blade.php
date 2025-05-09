<!-----<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>-->

<style>
    #meuMapa {
        border: 1px solid rgb(0, 98, 154);
        height: 50vh;
        width: 50vw;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css">


<h3><b>Clique no quadrado preto no mapa</b></h3>
<div id="meuMapa">olá xxxxxxx</div>


<script>
// ✅ Define o mapa aqui no escopo global
var local = L.map("meuMapa").setView([-23.5505, -46.6333], 13);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "&copy; OpenStreetMap contributors",
}).addTo(local);

var drawnItems = new L.FeatureGroup();
local.addLayer(drawnItems);

var drawControl = new L.Control.Draw({
    draw: {
        polyline: false,
        polygon: false,
        circle: false,
        circlemarker: false,
        marker: false,
        rectangle: {
            shapeOptions: {
                color: "#3388ff",
            },
        },
    },
    edit: {
        featureGroup: drawnItems,
    },
});
local.addControl(drawControl);

local.on("draw:created", function (e) {
    var tipo = e.layerType;
    var layer = e.layer;

    // Limpa tudo antes de adicionar o novo
    drawnItems.clearLayers();

    if (tipo === "rectangle") {
        var bounds = layer.getBounds();
        var centro = bounds.getCenter();
        var cantoNE = bounds.getNorthEast();
        var distancia = local.distance(centro, cantoNE); // metros

        var areaSelecionada = {
            
                lat: centro.lat,
                lng: centro.lng,
                raio_metros: distancia,
        };

        console.log("Área formatada:", areaSelecionada);
        Analisa()
        window.sessionStorage.setItem( "cordenadasMapa", JSON.stringify(areaSelecionada) );
        
        var base64String = btoa(JSON.stringify(areaSelecionada));
        window.sessionStorage.setItem('coordCript', base64String );


        // (Opcional) Desenha o círculo com base no retângulo
        var circulo = L.circle([centro.lat, centro.lng], {
            radius: distancia,
            color: "red",
            fillColor: "#f03",
            fillOpacity: 0.2,
        });

        // Adiciona o novo retângulo e o círculo no mapa
        drawnItems.addLayer(layer); // retângulo
        drawnItems.addLayer(circulo); // círculo
    }
});












function Analisa() {
    console.log("teste apenas")
}
</script>