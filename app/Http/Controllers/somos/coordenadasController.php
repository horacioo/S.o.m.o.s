<?php

namespace App\Http\Controllers\somos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class coordenadasController extends Controller
{
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
            $sinal = $info[0]; $info = substr($info, 1);
        } else {
            $sinal = '';  $info = $info; // Mantém o número original
        }


        $info = preg_replace("/[^0-9]/", "", $info);



        if ($output == 1) {
            //-23.3288º  $parte = substr($string, 0, 3);
            $lenght = strlen($info);
             return $sinal."".substr($info, 0, 2).".".substr($info, 2, 4)."°"; 
        }

        if ($output == 2) {
            //23.57,1'º  $parte = substr($string, 0, 3);
             return $sinal."".substr($info, 0, 2)."°".substr($info, 2, 2).",".substr($info, 4, 2); 
        }

        if ($output == 3) {
            //23.57'06'  $parte = substr($string, 0, 3);
             return $sinal."".substr($info, 0, 2)."°".substr($info, 2, 2).",'".substr($info, 4, 2)."'"; 
        }


        



    }
}
