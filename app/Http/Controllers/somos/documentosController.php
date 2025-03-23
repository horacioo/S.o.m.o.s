<?php

namespace App\Http\Controllers\somos;

use App\Http\Controllers\Controller;
use App\Models\somos\AmostrasTipo;
use App\Models\somos\CoordenadasTipo;
use App\Models\somos\documentos;
use App\Models\somos\keywords;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class documentosController extends Controller
{

    public function cadTrab()
    {
        $user = Auth::user();
        $token = $user->createToken('MyAppToken')->plainTextToken;

        $trabalhos = new Documentos();
        $cord = new CoordenadasTipo();
        $amost = new AmostrasTipo();
        $all = $cord->all();
        $amall = $amost->all();
        return view('somos.trabalhos.cadastro', compact('trabalhos', 'all', 'amall'));
    }





























    public function store(Request $request)
    {
        // Validação dos dados recebidos no formulário
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

        // Verifica se o documento foi criado com sucesso
        if ($documento) {
            // Obtém o ID do documento recém-criado
            $documentoId = $documento->id;

            // Chama a função PalavrasChaves passando o ID do documento e as keywords
            $this->PalavrasChaves($request->input('keywords'), $documentoId);

            // Redireciona com mensagem de sucesso
            return redirect()->route('TrabalhosCadastros')->with('success', 'Documento cadastrado com sucesso!');
        } else {
            // Redireciona com mensagem de erro
            return redirect()->back()->with('error', 'Falha ao cadastrar o documento.');
        }
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
}
