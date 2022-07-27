<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Candidato;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Tem o Request só quando está recebendo informações (No cadastro e no atualizar)
Route::post('/cadastrar-candidato', function (Request $request) { 
    Candidato::create([
        'name' => $request->nome_candidato,
        'telefone' => $request->telefone_candidato
    ]);
    //dd($request->all()); // todas as informações vindas do formulário
    //dd($request->nome_candidato); // somente o nome_candidato
    echo "Candidato criado com sucesso!";
});

Route::get('/mostrar-candidato/{id_do_candidato}', function ($id_do_candidato) { 
    //Candidato::find($id_do_candidato); // find é uma função que sempre vai buscar pelo id
    // findOrFail é uma função que se não encontrar irá mostrar uma falha 404 NOT FOUND
    $candidato = Candidato::findOrFail($id_do_candidato); 
    echo "Nome: $candidato->name | Telefone: $candidato->telefone";
    
});

Route::get('/editar-candidato/{id_do_candidato}', function ($id_do_candidato) { 
    $candidato = Candidato::findOrFail($id_do_candidato); 

    return view('editar_candidato', ['candidato' => $candidato]);
});

// put() está enviando registros para o banco de dados para ATUALIZAR!
// Tem o Request só quando está recebendo informações
Route::put('/atualizar-candidato/{id_do_candidato}', function (Request $request, $id_do_candidato) { 
    $candidato = Candidato::findOrFail($id_do_candidato); 
    $candidato->name = $request->nome_candidato;
    $candidato->telefone = $request->telefone_candidato;
    $candidato->save();
    echo "Candidato Atualizado com Sucesso!";
});

Route::get('/excluir-candidato/{id_do_candidato}', function ($id_do_candidato) { 
    $candidato = Candidato::findOrFail($id_do_candidato); 
    $candidato->delete();
    echo "Candidato Deletado com Sucesso!";
});