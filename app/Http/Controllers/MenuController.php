<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Alternar o estado do menu (reduzido/expandido)
     */
    public function toggleState(Request $request)
    {
        try {
            $currentState = session('menu_collapsed', false);
            $newState = !$currentState;

            session(['menu_collapsed' => $newState]);

            // Se o request for AJAX, retorna JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'collapsed' => $newState,
                    'message' => $newState ? 'Menu recolhido' : 'Menu expandido'
                ]);
            }

            return back();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao salvar estado do menu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obter o estado atual do menu
     */
    public function getState()
    {
        try {
            return response()->json([
                'success' => true,
                'collapsed' => session('menu_collapsed', false)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao obter estado do menu'
            ], 500);
        }
    }
}
