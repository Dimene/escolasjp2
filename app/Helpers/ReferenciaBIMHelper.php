<?php

namespace App\Helpers;

class ReferenciaBIMHelper
{
    // Tabela de pesos conforme especificação (máximo 30 posições)
    private static array $pesos = [
        1 => 1, 2 => 10, 3 => 3, 4 => 30, 5 => 9, 6 => 90,
        7 => 27, 8 => 76, 9 => 81, 10 => 34, 11 => 49, 12 => 5,
        13 => 50, 14 => 15, 15 => 53, 16 => 45, 17 => 62, 18 => 38,
        19 => 89, 20 => 17, 21 => 73, 22 => 51, 23 => 25, 24 => 56,
        25 => 75, 26 => 71, 27 => 31, 28 => 19, 29 => 93, 30 => 57,
    ];

    /**
     * Gera referência com check digit para Millennium BIM (MOD 97-10)
     *
     * @param string $entidade 3 a 5 dígitos
     * @param string $referenciaBase 7 a 9 dígitos (sem check digit)
     * @param float $montante Valor com 2 casas decimais (ex: 5432.00)
     * @return string Referência com 2 dígitos de controlo
     */
    public static function gerarReferenciaComCheckDigit(string $entidade, string $referenciaBase, float $montante): string
    {
        // Normalizar entradas
        $entidade = str_pad(preg_replace('/\D/', '', $entidade), 3, '0', STR_PAD_LEFT);
        $referencia = str_pad(preg_replace('/\D/', '', $referenciaBase), 9, '0', STR_PAD_LEFT);
        $montante = number_format($montante, 2, '', '');
        $montante = str_pad($montante, 6, '0', STR_PAD_LEFT);
        $montante = str_pad($montante, 2, '0', STR_PAD_RIGHT);

        // Concatenar número completo (sem check digit)
        $numero = $entidade . $referencia . $montante;

        // Calcular soma ponderada
        $soma = 0;
        $digitos = str_split($numero);
        $totalDigitos = count($digitos);

        foreach ($digitos as $i => $digito) {
            $posicao = $totalDigitos - $i;
            $peso = self::$pesos[$posicao] ?? 0;
            $soma += intval($digito) * $peso;
        }

        // Calcular check digit
        $resto = $soma % 97;
        $checkDigit = str_pad(98 - $resto, 2, '0', STR_PAD_LEFT);

        // Retornar referência final (9 dígitos + 2 dígitos de controlo)
        return substr($referencia, -9) . $checkDigit;
    }



//     public static function gerarReferencia($Entidade,$Servico,$codigoAluno,$mes,$valor){
//     $montante = str_pad($valor, 6, '0', STR_PAD_LEFT);
//     $mes = str_pad($mes, 2, '0', STR_PAD_LEFT);
//     $montante = str_pad($montante , 10, '0', STR_PAD_RIGHT);
//     $referenciaInicial=$Servico.$codigoAluno."".$mes;

// $pesos = collect([
//     57, 93, 19, 31, 71, 75, 56, 25, 51, 73, 17, 89,
//     38, 62, 45, 53, 15, 50, 5, 49, 34, 81, 76, 27,
//     90, 9, 30, 3, 10, 1
// ]);

// $referenciaTotal=$Entidade.$referenciaInicial.$montante;
// // echo "referencia".$referenciaTotal;
// // echo "referencia".$referenciaInicial;



// $digitos = collect(str_split($referenciaTotal));
// $contadorposicoes=count($digitos );
// $contadorpeso=count($pesos);
// $totapesodigito=0;
// for($x=1;$x<($contadorposicoes+1);$x++){

//     $tota=$pesos[$contadorpeso-$x]*(int)$digitos[$contadorposicoes-$x];
//     $totapesodigito=$totapesodigito+$tota;



// }

// $resultadoDivisao =($totapesodigito/97);
// $decimal = $resultadoDivisao - floor($resultadoDivisao); // 0.34567

//  $dados= collect(str_split($decimal));
// // $variavel1=$dados[2]??$dados[2]:0;
// $variavel1 = $dados[1] ?? 0;
// $variavel2 = $dados[2] ?? 0;

// $flag=(int)($variavel1.$variavel2);

//  $checkdigit=98-$flag ;


// $referenciaTotal=$Entidade.$referenciaInicial;
// return ($referenciaInicial.$checkdigit);
//    // dd($montante, count($pesos),$codigoAluno,$mes,$Servico,$Entidade);




// // return
// }



public  static function  gerarReferencia($Entidade,$codigoAluno,$mes,$valor){

     $pesos = [
            1,10,3,30,9,90,27,76,81,34,49,5,50,15,53,45,62,38,89,17,
            73,51,25,56,75,71,31,19,93,57
        ];
         $valor2 = $valor."00";
 $mes2= str_pad($mes, 2, '0', STR_PAD_LEFT);


        $string=$Entidade.$codigoAluno.$mes2.$valor2;
        // dd( $string,$Entidade,$codigoAluno,$mes2,$valor2);

         $digitos=collect(str_split($string));
         $dadosRevertidos=collect();
         for( $X=count($digitos);$X>0; $X--){
 $dadosRevertidos->push($digitos[$X-1]);
         }


         $soma=0;
         for($x=0;$x<count($dadosRevertidos);$x++){
            $indice=$x+2;

            $mult=(int)$dadosRevertidos[$x]*(int)$pesos[$indice];

$soma=$soma+$mult;
         }

         $check=(98-($soma%97));
          $check2= str_pad($check, 2, '0', STR_PAD_LEFT);
      return $codigoAluno.$mes2.$check2;

}

}
