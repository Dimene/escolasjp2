<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Routing\Route;

class NotificacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    // Pega todas as notificações do usuário autenticado
    $notificacoesNaoLidas = auth()->user()->unreadNotifications;
    $notificacoesLidas = auth()->user()->readNotifications;

    return view("Notificacao.Notificacao-index", compact('notificacoesNaoLidas', 'notificacoesLidas'));
}

    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

$notificacao = auth()->user()->notifications()->where('id', $id)->first();

        return view ("Notificacao.Notificacao-visualizar",compact('notificacao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(string $id)
{
    $notificacao = auth()->user()->notifications()->where('id', $id)->first();

    if ($notificacao) {
        $notificacao->markAsRead();
    }

    // Redireciona para a rota show
    return redirect()->route('BDNotificao.show', $id);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
{
    // Busca a notificação pelo ID
    $notificacao = auth()->user()->notifications()->where('id', $id)->first();

    if ($notificacao) {
        $notificacao->delete(); // Apaga a notificação
        return redirect()->route('BDNotificao.index')
                         ->with('success', 'Notificação apagada com sucesso!');
    }

    return redirect()->route('BDNotificao.index')
                     ->with('error', 'Notificação não encontrada.');
}

}
