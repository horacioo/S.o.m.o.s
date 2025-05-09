<?php

namespace App\Http\Controllers\somos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class coordenadasController extends Controller
{



    public function pesquisaData($data)
    {
        $info  = base64_decode($data);

        $info2 = explode('*', $info);

        $data1 = $info2[0];

        $data2 = $info2[1];

        $resultados =  DB::table('pesquisardadosdetrabalho')->whereBetween('data_deposito', [$data1, $data2])->get();

        return view('somos.pedacos.mapa', compact('resultados'));
    }




    public function pesquisaMunicipio($municipio)
    {
        $resultados = DB::table('pesquisardadosdetrabalho')
            ->select('*')
            ->where('municipio', $municipio)
            ->get();

        return view('somos.pedacos.mapa', compact('resultados'));
    }








    public function pesquisaDesenho($coord)
    {

        $infoCoord = base64_decode($coord);
        $infoCoord = json_decode($infoCoord, true);

        $lat = $infoCoord['lat'];
        $lng = $infoCoord['lng']; // <- corrigido de $long para $lng
        $raio = $infoCoord['raio_metros'];


        $lat_ = $this->prepararCoordenadaParaSQL($lat);
        $lng_ = $this->prepararCoordenadaParaSQL($lng);




        $limites  = $this->calcularLimitesGeograficos($lat, $lng, $raio);

        $resultados = DB::table('pesquisardadosdetrabalho')
            ->select('*')
            ->selectRaw("(
        6371 * acos(
            cos(radians(?)) * cos(radians(lat)) *
            cos(radians(lgnt) - radians(?)) +
            sin(radians(?)) * sin(radians(lat))
        )
    ) as distancia_km", [$lat, $lng, $lat])
            ->having('distancia_km', '<=', $raio)
            ->orderBy('distancia_km', 'asc')
            ->get();


        return view('somos.pedacos.mapa', compact('resultados'));
    }




    private function prepararCoordenadaParaSQL($coordenada)
    {
        // Remove espaços antes/depois
        $coordenada = trim($coordenada);

        // Converte aspas tipográficas para as simples e duplas normais
        $coordenada = str_replace(['′', '’', '‘'], "'", $coordenada);
        $coordenada = str_replace(['″', '“', '”'], '"', $coordenada);

        // Substitui espaços duplicados por um único espaço
        $coordenada = preg_replace('/\s+/', ' ', $coordenada);

        // Escapa aspas simples para evitar erro na query
        $coordenada = str_replace("'", "\\'", $coordenada);

        // Adiciona aspas simples para passar na query
        return "'" . $this->coordenadaParaDecimal($coordenada) . "'";
    }




    private function coordenadaParaDecimal($coordenada)
    {
        // Remove espaços extras
        $coordenada = trim($coordenada);

        // Caso já esteja no formato decimal, apenas retorna
        if (preg_match('/^[-]?\d+\.\d+$/', $coordenada)) {
            return (float)$coordenada;
        }

        // Normaliza as coordenadas removendo o símbolo de grau (°), minutos (′), segundos (″)
        // e tratando os hemisférios (N/S/E/W).
        $coordenada = str_replace(['°', '′', '″', 'N', 'S', 'E', 'W'], [' ', ' ', ' ', '', '', '', ''], $coordenada);
        $coordenada = trim($coordenada); // Remove espaços extras

        // Verifica se tem "S" ou "W" para adicionar o sinal negativo
        $sinal = 1; // Padrão: Norte ou Leste
        if (stripos($coordenada, 'S') !== false || stripos($coordenada, 'W') !== false) {
            $sinal = -1;
        }

        // Remove "S", "W" caso tenha ficado
        $coordenada = str_replace(['S', 'W'], '', $coordenada);

        // Verifica o formato e converte para decimal
        $partes = preg_split('/\s+/', $coordenada);

        if (count($partes) == 1) {
            // Caso em formato de grau decimal
            return $sinal * (float)$partes[0];
        } elseif (count($partes) == 2) {
            // Caso em formato grau/minuto decimal
            $graus = (float)$partes[0];
            $minutos = (float)$partes[1];
            return $sinal * ($graus + $minutos / 60);
        } elseif (count($partes) == 3) {
            // Caso em formato grau/minuto/segundo
            $graus = (float)$partes[0];
            $minutos = (float)$partes[1];
            $segundos = (float)$partes[2];
            return $sinal * ($graus + ($minutos / 60) + ($segundos / 3600));
        } else {
            // Caso em formato não reconhecido
            return null;
        }
    }





    public function TrataCoordenada($dados)
    {


        $latitude = $dados[0];
        $longitude = $dados[1];
        $tipo = $dados[2];


        if (is_null($latitude)) {
            $latitude = "0";
        }
        if (is_null($longitude)) {
            $longitude = "0";
        }
        // Faça aqui qualquer processamento ou validação que você precise com as coordenadas
        // Crie um array ou objeto PHP com os dados que você quer retornar em JSON

        $data = [
            'latitude' => $this->AnalizaCoordenadas($latitude, $tipo),
            'longitude' => $this->AnalizaCoordenadas($longitude, $tipo),
            'status' => 'success', // Você pode adicionar um status para indicar o resultado

            // Outros dados que você queira retornar
        ];

        // Retorne a resposta como JSON
        return $data;
    }





    private function AnalizaCoordenadas($info, $output)
    {

        if ($info[0] === '-' || $info[0] === '+') {
            $sinal = $info[0];
            $info = substr($info, 1);
        } else {
            $sinal = '';
            $info = $info; // Mantém o número original
        }


        $info = preg_replace("/[^0-9]/", "", $info);



        if ($output == 1) {
            //-23.3288º  $parte = substr($string, 0, 3);
            $lenght = strlen($info);
            return $sinal . "" . substr($info, 0, 2) . "." . substr($info, 2, 4) . "°";
        }

        if ($output == 2) {
            //23.57,1'º  $parte = substr($string, 0, 3);
            return $sinal . "" . substr($info, 0, 2) . "°" . substr($info, 2, 2) . "," . substr($info, 4, 2);
        }

        if ($output == 3) {
            //23.57'06'  $parte = substr($string, 0, 3);
            return $sinal . "" . substr($info, 0, 2) . "°" . substr($info, 2, 2) . ",'" . substr($info, 4, 2) . "'";
        }
    }



    public function desenha()
    {
        return view('somos.pedacos.mapaClick');
    }



    public function decimal()
    {
        return view('somos.pedacos.pequisaDecimal');
    }








    private function calcularLimitesGeograficos($lat, $lng, $raio_metros)
    {
        // Validação simples
        if (!is_numeric($lat) || !is_numeric($lng) || !is_numeric($raio_metros) || $raio_metros <= 0) {
            return false;
        }

        // 1 grau de latitude ≈ 111.32 km = 111320 metros
        $lat_diff = $raio_metros / 111320;

        // 1 grau de longitude depende da latitude (ajustado com cosseno)
        $lng_diff = $raio_metros / (111320 * cos(deg2rad($lat)));

        return [
            'lat_min' => $lat - $lat_diff,
            'lat_max' => $lat + $lat_diff,
            'lng_min' => $lng - $lng_diff,
            'lng_max' => $lng + $lng_diff,
        ];
    }
}
