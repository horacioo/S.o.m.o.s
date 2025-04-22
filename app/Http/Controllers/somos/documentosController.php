<?php

namespace App\Http\Controllers\somos;

use App\Http\Controllers\Controller;
use App\Models\somos\amostra;
use App\Models\somos\amostras;
use App\Models\somos\AmostrasTipo;
use App\Models\somos\cidades;
use App\Models\somos\CoordenadasTipo;
use App\Models\somos\documentos;
use App\Models\somos\keywords;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\User;


/***********************
SELECT d.autor, d.programa, d.orientador, cd.municipio,  UPPER(formatar_nome(d.orientador,1)) as citacao, kw.keyword , UPPER(us.name) as aluno, am.latitude, am.longitude, 
dms_para_decimal(am.latitude) as lat, dms_para_decimal(am.longitude) as lgnt,
am.tipo_de_coleta_id
FROM documentos as d
inner join keywords as kw on kw.documento_id = d.id  
inner join users as us on us.id = d.user
inner join amostras as am on am.documento_id = d.id
inner join cidades as cd on cd.id = d.municipio 
*********************/
/*************************************
SELECT dms_para_decimal('22° 57.115\' S') as xx ,
dms_para_decimal('22° 57.115\' S') as xx2, 
dms_para_decimal('22° 57\' 06.9" S') as xx3
FROM pesquisardadosdetrabalho
*************************************/

class documentosController extends Controller
{

    private $IdDocumento;



    public function pesquisa(){
        $cidades = cidades::all();
       return view('somos.trabalhos.pesquisa',compact('cidades'));
    }

    public function cadTrab()
    {
        $user = Auth::user();
        $token = $user->createToken('MyAppToken')->plainTextToken;
        $usuario = $user->id;

        $infoGerado = mt_rand(1000000000, 9999999999);
        $info  = md5($token . "-" . time() . "-" . $user->id . "-" . $user->name . "-" . $user->email);
        $info = preg_replace('/\D/', '', $info); // Remove qualquer caractere não numérico
        $combinados = $info . $infoGerado;
        $info = substr($combinados, 0, 18);

        $trabalhos = new Documentos();
        $cord = new CoordenadasTipo();
        $amost = new AmostrasTipo();
        $all = $cord->all();
        $amall = $amost->all();
        return view('somos.trabalhos.cadastro', compact('trabalhos', 'all', 'amall', 'token', 'info', 'usuario'));
    }



    public function store(Request $request)
    {

        $dados = $request->all();

        $info = new documentos();
        $info->programa = $dados['programa'];
        $info->titulo = $dados['titulo'];
        $info->tipo_do_documento = $dados['tipo_do_documento'];
        $info->autor = $dados['autor'];
        $info->citacao = $dados['citacao'];
        $info->orientador = $dados['orientador'];
        $info->data_deposito = $dados['data_deposito'];

        if ($info->save()) {

            $this->IdDocumento = $info->id;
            $this->PalavrasChaves($request->input('keywords'), $info->id);  // Chama a função PalavrasChaves passando o ID do documento e as keywords

            return response()->json([
                'success' => true,
                'message' => 'Documento salvo com sucesso!',
                'id' => $info->id,
                'dados' => $this->SalvaCoordenadas($dados['coletas'])
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao salvar o documento',
                'dados' => $this->SalvaCoordenadas($dados['coletas'])
            ], 500);
        }
    }





    private function SalvaCoordenadas($dados) {
        $json = $dados;
        $array = json_decode($json, true);

        


        foreach($array as $a):
            $sample = new amostra();
            $info = array();
             $info['latitude']=$a['latitude'];
             $info['longitude']=$a['longitude'];
             $info['amostra']=$a['amostra'];
             $info['tipo']=1;

             $sample->latitude            = $a['latitude'];
             $sample->longitude           = $a['longitude'];
             $sample->tipo_de_coleta_id   = $a['amostra'];
             $sample->documento_id        = $this->IdDocumento;

             $sample->save();

           
        endforeach;
        return $dados;
    }










    private function PalavrasChaves($palavras, $id)
    {
        // Divide a string de palavras-chave em um array
        $palavrasArray = explode(",", $palavras);

        // Preenche o array com os dados
        foreach ($palavrasArray as $p) {
            $keyword = trim($p); // Remove espaços em branco extras

            // Verifica se a palavra-chave já existe; se não, cria uma nova
            keywords::firstOrCreate(
                ['keyword' => $keyword], // Condição de busca
                ['documento_id' => $id]  // Dados a serem inseridos se não existir
            );
        }
    }




    public function apiSalvaColetas(Request $request)
    {
        $dados = array(
            $request->latitude,
            $request->longitude,
            $request->Coord
        );
        $x = new coordenadasController;
        return response()->json($x->TrataCoordenada($dados));

        /*$recebidos =  $request->all();
        $data = [
            'recebidos' => $recebidos,
            'message' => 'Olá',
            'status' => 'success',
            'statusCode' => 200
        ];*/

        // Retornar a resposta em JSON com código de status 200 (OK)
        return response()->json($data, 200);




        $validatedData = $request->validate([
            'programa' => 'required|string|max:255',
            'tipo_do_documento' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'citacao' => 'required|string',
            'orientador' => 'required|string|max:255',
            'data_deposito' => 'required|date',
            // 'coleta' => 'required|integer', // Descomente se 'coleta' for obrigatório
        ]);

        // Criação de um novo registro no banco de dados
        $documento = Documentos::create([
            'programa' => $validatedData['programa'],
            'tipo_do_documento' => $validatedData['tipo_do_documento'],
            'titulo' => $validatedData['titulo'],
            'autor' => $validatedData['autor'],
            'citacao' => $validatedData['citacao'],
            'orientador' => $validatedData['orientador'],
            'data_deposito' => $validatedData['data_deposito'],
            'coleta' => $request->input('coleta'), // Utilize input() para campos opcionais
        ]);

        /*
        $amostra = new amostra();
        $amostra->latitude          = $request->latitude;
        $amostra->longitude         = $request->longitude;
        $amostra->ligacao           = $request->ligacao;
        $amostra->tipo_de_coleta_id = $request->amostra;
        $amostra->save();
*/
    }
}
