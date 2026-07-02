<?php

namespace App\Models;

use emagombe\Mpesa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelmpesapay extends Model
{
    use HasFactory;

    protected $mpesa;
protected $variavel;

    public function __construct()
    {
        $api_key = "fwxnflm7ycgjx7xhmywrvjw2mz8cjb3m";		# Aqui introduz a api key disponibilizada no site
        $public_key = "MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAmptSWqV7cGUUJJhUBxsMLonux24u+FoTlrb+4Kgc6092JIszmI1QUoMohaDDXSVueXx6IXwYGsjjWY32HGXj1iQhkALXfObJ4DqXn5h6E8y5/xQYNAyd5bpN5Z8r892B6toGzZQVB7qtebH4apDjmvTi5FGZVjVYxalyyQkj4uQbbRQjgCkubSi45Xl4CGtLqZztsKssWz3mcKncgTnq3DHGYYEYiKq0xIj100LGbnvNz20Sgqmw/cH+Bua4GJsWYLEqf/h/yiMgiBbxFxsnwZl0im5vXDlwKPw+QnO2fscDhxZFAwV06bgG0oEoWm9FnjMsfvwm0rUNYFlZ+TOtCEhmhtFp+Tsx9jPCuOd5h2emGdSKD8A6jtwhNa7oQ8RtLEEqwAn44orENa1ibOkxMiiiFpmmJkwgZPOG/zMCjXIrrhDWTDUOZaPx/lEQoInJoE2i43VN/HTGCCw8dKQAwg0jsEXau5ixD0GUothqvuX3B9taoeoFAIvUPEq35YulprMM7ThdKodSHvhnwKG82dCsodRwY428kg2xM/UjiTENog4B6zzZfPhMxFlOSFX4MnrqkAS+8Jamhy1GgoHkEMrsT5+/ofjCx0HjKbT5NuA2V/lmzgJLl3jIERadLzuTYnKGWxVJcGLkWXlEPYLbiaKzbJb2sYxt+Kt5OxQqC1MCAwEAAQ==
        ";	# Aqui introduz o public key disponibilizado no site
        $ssl = true;		# True se pretende utilizar uma conexão segura (SSL)

        # Inicialização e criação do objecto
        $mpesa = Mpesa::init($api_key, $public_key, $ssl);

  $this->mpesa=$mpesa;

    }

   public function tranferencia($quantia,$numero){

   $mpesa= $this->mpesa;

   $data = [

	"value" =>$quantia,	# Valor a transferir
	"client_number" =>$numero,	# Número do cliente
	"agent_id" =>171717,	# Código do agente beneficiário,

];

$response=$mpesa->c2b($data, function($response) {
    $stringval=str_replace("{",'',$response);
    $stringval=str_replace("}",'',$stringval);
    $stringval=str_replace('"','',$stringval);

    $Arraydado=explode(',',$stringval);
    $arraynovo=collect();
    for($x=0; $x<count($Arraydado);$x++){
        $arrad=explode(":",$Arraydado[$x]);

$variavel=  str_replace('"','',$arrad[0]);
$variavel2=  str_replace('"','',$arrad[1]);
    $arraynovo->push((object) array("".$variavel.""=>$variavel2));
$this->variavel=$arraynovo;
    }


});


return $this->variavel;

   }
}
