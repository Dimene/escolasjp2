<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MpesaService
{

   protected $dados;

   public function sendPaymentRequest($referencia,$numero,$Muntante,$TipoTrasacaoReferencia){
    $api_url = 'https://api.sandbox.vm.co.mz:18352/ipg/v1x/c2bPayment/singleStage/';

    // Configuração dos dados da requisição
    $data = [
        'input_TransactionReference' =>$referencia,
        'input_CustomerMSISDN' =>$numero,
        'input_Amount' =>$Muntante,
        'input_ThirdPartyReference' =>$TipoTrasacaoReferencia,
        'input_ServiceProviderCode' => '171717'
    ];

    // Configuração das opções do cURL
    $curl = curl_init($api_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Origin: *',
        'Content-Type: application/json',
        'Authorization:Bearer a9i0OU3d/u3H+HRx8btYW/Q0VXLMhwshXttuNsGhhy5wKhlWP75sA7CE3poPs7l9m8srfA5uRqiXEeg6mIbaAExbZt9WHdIeVfz60Hb+VI7invszdJF+w0n6Qsb/OOvsNdmZXbBC4kG/mU3XP6WmWjZiM1miqH0DJQM1n566gRMptdXRpzE832UDKU2aB3MIKiSb2ITaB/lDyKUK72Oxx3SFvL3t4EyZbufivWY5cghsCuGvJpJ4D4Z7pxMU+RTCJLb9Vcvrh0msdXNnIiVfL0w9NA8X7CcFWQVVJwxoUyQomZHrZRebabfZe4eyWe3lNvzLihWhZHrCNbF1CygBva5ti7At4MUkJoVFaRsFhNE8Upp3QbzYbFyMDmarDctdMTjo/fie9SKUeOhNN2OsJGrsOXHE624XSouPfd853TuR0212YqD5dykhpZ4phTsAEmJN5KYzPtyJAFqCQ37jkbwlg1IvDzTADi3E6478Z4mnpdnZsGQQkZD0BrjnzDTIt7VTk9Kaug0FxTqepEH7F8Vqga4jiSObL/5qsk3XPUVYPvWnw3ZomnQTItjRNG1CyXVe9A1l7jHGxBVSzt/t0uo8EFoLOiojl/Z0MJ5sOHcLf7iOuQN9RQr1vcDxrsrq14xOVYMDKvOWA7j5SpvkbybQ1xO/mbIm1GmoScJaEQ8= ',
		'Origin: developer.mpesa.vm.co.mz'
    ]);

    // Execução da requisição
    $response = curl_exec($curl);
    $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    // Verificação de erros
	$this->dados=(json_decode($response));
    if($this->dados->output_ResponseCode=='INS-0'){ $this->dados->output_ResponseDesc="sucesso"; }

    else if($this->dados->output_ResponseCode=='INS-2006'){$this->dados->output_ResponseDesc="Salodo Insuficiente"; }
 else if($this->dados->output_ResponseCode=='INS-2051'){ $this->dados->output_ResponseDesc="Numero Invalido";  }

    else if($this->dados->output_ResponseCode=='INS-9'){$this->dados->output_ResponseDesc="Encedeu o Tempo Limite";  }

    else if($this->dados->output_ResponseCode=='INS-10'){ $this->dados->output_ResponseDesc="Duplicou Operacao";   }
    else{ $this->dados->output_ResponseDesc="Erro Verifique os dados";   }

    curl_close($curl);
    return $this->dados;

    }
}
