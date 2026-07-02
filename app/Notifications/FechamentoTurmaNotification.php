<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class FechamentoTurmaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $turma;
    protected $trimestre;
    protected $ano;
    protected $turmaNotificao;
    protected $divisao;
    protected $turmaClasse;
    protected $estado;
    protected $dados;

    public function __construct($turma, $turmaNotificao, $trimestre,$divisao,$turmaClasse, $ano,$estado, $dados)
    {
        $this->turma = $turma;
        $this->trimestre = $trimestre;
        $this->ano = $ano;
        $this->turmaNotificao = $turmaNotificao;
        $this->divisao = $divisao;
        $this->turmaClasse = $turmaClasse;
        $this->estado = $estado;
        $this->dados = $dados;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'titulo' => "{$this->estado} de Turma Aguardando Confirmação {$this->turmaNotificao}",
            'mensagem' => "A turma {$this->turmaNotificao}  da {$this->turmaClasse} do {$this->divisao} trimestre de {$this->ano} está aguardando confirmação de fechamento.",
            'turma' => $this->turma,
            'trimestre' => $this->trimestre,
            'ano' => $this->ano,
            'estado'=>$this->estado,
            "dados"=>$this->dados,
            "link"=>route('notas.trancar')

        ];
    }
}
