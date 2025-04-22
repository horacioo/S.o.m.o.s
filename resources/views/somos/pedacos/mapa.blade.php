<style>
    #meuMapa {
        border: 1px solid rgb(0, 98, 154);
        height: 50vh;
        width: 50vw;
    }
</style>







<!---<ul>
   /* @foreach ($resultados as $item)
        <li>
            Latitude: {{ $item->lat }} <br>
            Longitude: {{ $item->lgnt }} <br>
            Distância: {{ $item->distancia_km }} km
            Distância: {{ $item->programa }} km

        </li>
    @endforeach*/
</ul>-->

<div id="meuMapa"></div>





<script>
    var pontos = @json($resultados);

    var mapa = L.map('meuMapa').setView([-23.55, -46.63], 10);

    pontos.forEach(ponto => {
        L.marker([ponto.lat, ponto.lgnt])
            .addTo(mapa)
            .bindTooltip(ponto.programa, {
                permanent: true,
                direction: "top",
                offset: [0, -10]
            })
            .bindPopup(`Distância: ${ponto.distancia_km} km`);
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapa);

    if (pontos.length > 0) {
        mapa.setView([pontos[0].lat, pontos[0].lgnt], 13);
    }
</script>

