<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\configuraceos;
use App\Models\registoAcademico\Aluno;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('tenant')->get('/instituicao/logomarca', function (Request $request) {
    $configuracao = configuraceos::query()->first();

    abort_if(!$configuracao || !$configuracao->avatar, 404, 'Logomarca não encontrada.');

    $subdomain = explode('.', $request->getHost(), 2)[0];
    $caminhoLogo = $subdomain . '/logoMarca/' . basename($configuracao->avatar);
    $discoPublico = Storage::disk('public');

    abort_unless($discoPublico->exists($caminhoLogo), 404, 'Arquivo da logomarca não encontrado.');

    return response()->file($discoPublico->path($caminhoLogo));
});


Route::middleware('tenant')->get('/aluno/imagem/{id}', function (Request $request, $id) {
    $aluno = Aluno::query()->find($id);
    abort_if(!$aluno || !$aluno->avatar, 404, 'Foto do aluno não encontrada.');

    $subdomain = explode('.', $request->getHost(), 2)[0];
    $caminhoFoto = $subdomain . '/fotoAluno/' . basename($aluno->avatar);
    $discoPublico = Storage::disk('public');

    abort_unless($discoPublico->exists($caminhoFoto), 404, 'Arquivo da foto do aluno não encontrado.');

    return response()->file($discoPublico->path($caminhoFoto));
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
