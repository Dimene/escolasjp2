<?php

namespace App\Http\Controllers\registoAcademico;

use App\Http\Controllers\Controller;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\classe;
use App\Models\registoAcademico\turma;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Http;
class mpesaController extends Controller
{
    protected  $insCodes;
    function __construct()
    {
      $this->insCodes = collect([
    [ "INS" => "INS-0", "descricao" => "Pedido processado com sucesso" ],
    [ "INS" => "INS-1", "descricao" => "Erro interno" ],
    [ "INS" => "INS-2", "descricao" => "Chave de API inválida" ],
    [ "INS" => "INS-4", "descricao" => "Usuário não está ativo" ],
    [ "INS" => "INS-5", "descricao" => "Transação cancelada pelo cliente" ],
    [ "INS" => "INS-6", "descricao" => "Falha na transação" ],
    [ "INS" => "INS-9", "descricao" => "Tempo limite da requisição" ],
    [ "INS" => "INS-10", "descricao" => "Transação duplicada" ],
    [ "INS" => "INS-13", "descricao" => "Shortcode inválido usado" ],
    [ "INS" => "INS-14", "descricao" => "Referência inválida usada" ],
    [ "INS" => "INS-15", "descricao" => "Valor inválido usado" ],
    [ "INS" => "INS-16", "descricao" => "Não foi possível processar devido a sobrecarga temporária" ],
    [ "INS" => "INS-17", "descricao" => "Referência de transação inválida. O comprimento deve estar entre 1 e 20." ],
    [ "INS" => "INS-18", "descricao" => "TransactionID inválido usado" ],
    [ "INS" => "INS-19", "descricao" => "ThirdPartyReference inválido usado" ],
    [ "INS" => "INS-20", "descricao" => "Nem todos os parâmetros foram fornecidos. Tente novamente." ],
    [ "INS" => "INS-21", "descricao" => "Validações de parâmetros falharam. Tente novamente." ],
    [ "INS" => "INS-22", "descricao" => "Tipo de operação inválido" ],
    [ "INS" => "INS-23", "descricao" => "Status desconhecido. Contate o suporte M-Pesa" ],
    [ "INS" => "INS-24", "descricao" => "InitiatorIdentifier inválido usado" ],
    [ "INS" => "INS-25", "descricao" => "SecurityCredential inválido usado" ],
    [ "INS" => "INS-26", "descricao" => "Não autorizado" ],
    [ "INS" => "INS-993", "descricao" => "Débito direto ausente" ],
    [ "INS" => "INS-994", "descricao" => "Débito direto já existe" ],
    [ "INS" => "INS-995", "descricao" => "Perfil do cliente apresenta problemas" ],
    [ "INS" => "INS-996", "descricao" => "Status da conta do cliente não está ativo" ],
    [ "INS" => "INS-997", "descricao" => "Transação de vinculação não encontrada" ],
    [ "INS" => "INS-998", "descricao" => "Mercado inválido" ],
    [ "INS" => "INS-2001", "descricao" => "Erro de autenticação do iniciador" ],
    [ "INS" => "INS-2002", "descricao" => "Receptor inválido" ],
    [ "INS" => "INS-2006", "descricao" => "Saldo insuficiente" ],
    [ "INS" => "INS-2051", "descricao" => "MSISDN inválido" ],
    [ "INS" => "INS-2057", "descricao" => "Código de idioma inválido" ],
]);
    }

    public function makePayment()
    {

$response=$this-> Mpesapagamento("Mensalidade",848976126,1000,35456);
// dd($response);
}

function Mpesapagamento($tipopagamento,$numero,$montant,$codigoFatura){

    $url = "https://api.sandbox.vm.co.mz:18352/ipg/v1x/c2bPayment/singleStage/";
    $apiKey = "xvxqoax17gqyv0mcaov8pbohh2589acw";

    $publicKey = "-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAmptSWqV7cGUUJJhUBxsMLonux24u+FoTlrb+4Kgc6092JIszmI1QUoMohaDDXSVueXx6IXwYGsjjWY32HGXj1iQhkALXfObJ4DqXn5h6E8y5/xQYNAyd5bpN5Z8r892B6toGzZQVB7qtebH4apDjmvTi5FGZVjVYxalyyQkj4uQbbRQjgCkubSi45Xl4CGtLqZztsKssWz3mcKncgTnq3DHGYYEYiKq0xIj100LGbnvNz20Sgqmw/cH+Bua4GJsWYLEqf/h/yiMgiBbxFxsnwZl0im5vXDlwKPw+QnO2fscDhxZFAwV06bgG0oEoWm9FnjMsfvwm0rUNYFlZ+TOtCEhmhtFp+Tsx9jPCuOd5h2emGdSKD8A6jtwhNa7oQ8RtLEEqwAn44orENa1ibOkxMiiiFpmmJkwgZPOG/zMCjXIrrhDWTDUOZaPx/lEQoInJoE2i43VN/HTGCCw8dKQAwg0jsEXau5ixD0GUothqvuX3B9taoeoFAIvUPEq35YulprMM7ThdKodSHvhnwKG82dCsodRwY428kg2xM/UjiTENog4B6zzZfPhMxFlOSFX4MnrqkAS+8Jamhy1GgoHkEMrsT5+/ofjCx0HjKbT5NuA2V/lmzgJLl3jIERadLzuTYnKGWxVJcGLkWXlEPYLbiaKzbJb2sYxt+Kt5OxQqC1MCAwEAAQ==
-----END PUBLIC KEY-----";

    openssl_public_encrypt($apiKey, $encryptedApiKey, $publicKey);
    $bearerToken = base64_encode($encryptedApiKey);

    $headers = [
        "Authorization" => "Bearer " . $bearerToken,
        "Origin" => "*",
    ];

    $payload = [
        "input_TransactionReference" =>$tipopagamento,
        "input_CustomerMSISDN" =>"258".$numero,
        "input_Amount" => $montant,
        "input_ThirdPartyReference" =>$codigoFatura,
        "input_ServiceProviderCode" => "171717",
    ];

    try {

        $response = Http::withHeaders($headers)
            ->timeout(7) // tempo máximo antes de considerar timeout
            ->post($url, $payload);

        $body = $response->json();

        $insCode = $body['output_ResponseCode'] ?? 'INS-23';
        $descricao = $this->insCodes
            ->firstWhere('INS', $insCode)['descricao'] ?? 'Código desconhecido';

        return [
            "INS" => $insCode,
            "Descricao" => $descricao,
            "Referencia" => $body["output_ConversationID"] ?? null
        ];

    } catch (\Illuminate\Http\Client\ConnectionException $e) {

        // Apenas captura timeout ou falha de conexão
        return [
            "INS" => "INS-9",
            "Descricao" => $this->insCodes->firstWhere('INS', 'INS-9')['descricao'],
            "Referencia" => null
        ];
    }
}



}








