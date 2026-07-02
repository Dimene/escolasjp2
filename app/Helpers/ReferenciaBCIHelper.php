<?php

namespace App\Helpers;

class ReferenciaBCIHelper
{
    public static function gerarReferencia(string $entidade, string $codigo, string $mes, float $montante): string
    {
        $entidade = preg_replace('/\D/', '', $entidade);
        $codigo = preg_replace('/\D/', '', $codigo);
        $mes = str_pad($mes, 2, '0', STR_PAD_LEFT);
        $montante = number_format($montante, 2, '', '');

        $sequencia = $entidade . $codigo . $mes . $montante;
        $pi = 0;

        for ($i = 0; $i < strlen($sequencia); $i++) {
            $si = intval($sequencia[$i]) + $pi;
            $pi = ($si * 10) % 97;
        }

        $pn = ($pi * 10) % 97;
        $checkDigit = str_pad(98 - $pn, 2, '0', STR_PAD_LEFT);

        return $codigo . $mes . $checkDigit;
    }
}