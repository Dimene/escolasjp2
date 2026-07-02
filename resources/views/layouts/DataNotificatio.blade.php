
<?php if(Auth::user())  {
	 $Denucias =Auth::user()->Notifications->where('type','App\Notifications\NotificarDenucias');
               $menssageAmostrar= Auth::user()->UnreadNotifications->where('type','App\Notifications\NotificarDenucias');
} ?>
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="fa fa-bell-o"></i>
      <span class="badge badge-warning navbar-badge">{{count( $menssageAmostrar)}}</span>
    </a>


    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <span class="dropdown-item dropdown-header">{{count($Denucias)}} Notifica&ccedil;&otilde;es</span>

      @foreach($Denucias as  $notificacoes)

    <?php
      $mensagem= DB::table('denucias')->where('id',$notificacoes->data['messagem'])->first();
      $tipo_denucias= DB::table('tipo_denucias')->where('id',$mensagem->tipo_denucia_id)->first();
       ?>
      <div class="dropdown-divider"></div>
      <a href="{{ route('Denucias.show',$notificacoes->id) }}" class="dropdown-item"  @if(empty($notificacoes->read_at))    style="background: rgba(156, 156, 152,0.7)" @endif>
        <i class="fa fa-envelope-o mr-2"></i>  {{  $tipo_denucias->Descricao }}
        <span class="float-right text-muted text-sm">3 mins

            @if(empty($notificacoes->read_at))    Nova @endif
        </span>

      </a>



      @endforeach


      <div class="dropdown-divider"></div>
      <a href="{{ route('Denucias.index') }}" class="dropdown-item dropdown-footer">todas Notifica&ccedil;&otilde;es</a>
    </div>
  </li>
