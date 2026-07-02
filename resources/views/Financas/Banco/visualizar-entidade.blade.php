
<!-- Main content -->
<div class="content  container-fluid" id="content">
  <div class="container-fluid">


  <div class="card"  >


<div class="row">

<div class="col my-3 py-3">




              <div class="profile-block">
                  <h3>Dados Do Aluno</h3>

                  <ul>


                  <li><span class="font-400"><b>Nome do Aluno:</b> </span><span class="profile-right">{{ $aluno->nome }}</span> </li>
                  <li><span class="font-400"><b>Sexo:</b> </span><span class="profile-right">{{ $aluno->sexo }}</span> </li>
                  <li><span class="font-400"><b>Idade:</b> </span>
                      <span class="profile-right">{{ ((carbon\Carbon::now()->format('y'))-(carbon\Carbon::createFromDate($aluno->dataNascimento )->format('y'))

                       ) }}</span> </li>

                       <li><span class="font-400"><b>Tipo:</b> </span><span class="profile-right">
                           @if($aluno->Tipo=="B") {{ "Bolseiro" }}
                          @else {{ "Normal" }}
                      @endif</span> </li>

                     <li><span class="font-400"><b>Ano Lectivo :</b> </span><span class="">
                      {{ $aluno->anolectivo}}</span> </li>
<li><span class="font-400"><b>Classe  que frequentada :</b> </span><span class="profile-right">
                      {{ $aluno->classe}}</span> </li>




</ul>


</div>
</div>

  </div>



    <!-- /.row -->
<!-- /.container-fluid -->


  <div class="no-shadow my-4  container-fluid">

                   <center><h3> <b>Referncias de {{ $referenciasbancariasview[0]->tipo_pagamento }}  :</b></h3></center>
                   <ul>

                    <table class="table table-light  table-resposive">
                        <thead>
                                <tr>

                                    <th>Mês</th>
                                      <th>Banco</th>
                                   <th> Referncia   </th>
                                   <th> Entidade   </th>
                                   <th> Accoes   </th>



                                </tr>
                          </thead>
                        <tbody>

                        @foreach ($referenciasbancariasview as $Item)
                        <tr>
                            <td>
                            {{ $Item->mes }}
                            </td>

                            <td>
                                {{ $Item->Banco }}

                            </td>

                            <td>
                                {{ $Item->referencia }}
                                </td>


                                <td>
                                {{ $Item->Entidade }}
                                </td>

                                <td>
                                    <a class="btn btn-primary" href="/Financas/Banco/referencas/alunoReferenciasPrint/{{ $Item->id }}/
                                        {{$Item->tipo_pagamento_id}}/{{ $Item->mes_id }}">


                                    <i class="fa fa-print"></i>
                                </a>
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                   </ul>
  </div>
  </div>
  </div>


<div class="container-fluid">

    <div  class=" container-fluid col-md-6">
        <?php $mes=0;?>
<a href="/Financas/Banco/referencas/alunoReferenciasPrint/{{ $referenciasbancariasview[0]->id }}/
    {{$referenciasbancariasview[0]->tipo_pagamento_id}}/{{ $mes }}"
class="button btn  btn-primary  buttonbaixar">Baixar em pdf</a>
<button  class="buttonImprimir btn btn-success"   title="{{$referenciasbancariasview[0]->id}}" >Imprimir</button>
</div>
</div>
