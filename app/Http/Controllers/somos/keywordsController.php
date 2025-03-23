<?php

namespace App\Http\Controllers\somos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class keywords extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'keyword' => 'required|string|max:255',
            'documento_id' => 'required|exists:documentos,id',
        ]);

        // Criação de uma nova keyword
        $keyword = Keyword::create($validatedData);

        // Redirecionamento ou resposta conforme necessário
        //return redirect()->back()->with('success', 'Keyword criada com sucesso!');
    }
}
