<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Services\TwilioService;
use Illuminate\Http\Request;
class smsNotificacaoController extends Controller
{


    protected $twilio;
    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function index (){
        return view('mensagems-index');
    }

    public function sendSms(Request $request)
    {
        $to = $request->input('to');
        $message = $request->input('message');

        $this->twilio->sendSms($to, $message);

        return response()->json(['status' => 'Message Sent!']);
    }

     public function receive(Request $request){
           // Recuperar os dados da mensagem recebida
           $from = $request->input('From');
           $body = $request->input('Body');

           // Processar a SMS recebida aqui
           // Por exemplo, você pode registrar a mensagem ou salvá-la no banco de dados
           \Log::info('Received SMS from ' . $from . ': ' . $body);

           // Opcionalmente, enviar uma resposta de volta ao Twilio
           $response = new \SimpleXMLElement('<Response></Response>');
           $response->addChild('Message', 'Thanks for your message!');

           return response($response->asXML(), 200)->header('Content-Type', 'text/xml');


     }

}
