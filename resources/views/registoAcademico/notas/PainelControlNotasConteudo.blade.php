
                <!-- Card 1 -->
                <div class="col">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                   <i class="fa fa-lock fa-3x" style="border-radius:50%; background:#eee; padding:15px; color:rgb(255, 0, 123)"></i>
                   <br>
                   <h4>
                   {{  $trimestre[0]->anolectivo->anomodelo->Descricao}}
                   </h4>
                   Gerir Trimestre abrir e tranca
                            <h5 class="card-title"></h5>


                            <ul class="list-group">

                                @foreach ($trimestre as  $trimestreItem)


                                <li class="list-group-item d-flex justify-content-between align-items-center " id="{{$trimestreItem->id}}">
                                    {{   $trimestreItem->divisao}} &ordm; {{   $trimestreItem->anolectivo->anomodelo->Descricao}}

                          {{-- {{$dadosFechamento->where("id",$trimestreItem->id)->first()["total"]}} --}}

                          @php
                           $elementotrimeestre=$dadosFechamento->where("id",$trimestreItem->id)->first();
                           $total=$elementotrimeestre["total"];
                           $visualizar=$elementotrimeestre["visualizar"];
// dd($dadosFechamento,Auth::user()->id,$visualizar);
                          @endphp
                                    <i


    data-disabled="{{ $total == 0 ? 'true' : 'false' }}"

                                    class="fa  fa-lg
                                elemento-chave



@if($dadosFechamento->where("id",$trimestreItem->id)->first()["chave1status"]!=null &&
$dadosFechamento->where("id",$trimestreItem->id)->first()["chave2status"]!=null)
                                        fa-lock
                                         @elseif ($dadosFechamento->where("id",$trimestreItem->id)->first()["chave1status"]==Auth::user()->id)
fa-lock
 @elseif ($dadosFechamento->where("id",$trimestreItem->id)->first()["chave2status"]==Auth::user()->id)
 fa-lock
 @else
                                         fa-unlock
                                         @endif
                                        btn-fecharTrimestre"
                                        >
                                        <small>
                                        {{ $dadosFechamento->where("id",$trimestreItem->id)->first()["status"] }}
                                        </small>
                                    </i>

                                         <i class="fa  @if($visualizar==null)
                                         fa-eye
                                         @else
                                          fa-eye-slash
                                         @endif
                                          fa-lg  btn-mostrarTrimestre"></i>

                                      </li>


                                    @endforeach
                            </ul>



                        </div>


<button class="btn btn-primary btngravaralteracoesTrimestres">Guardar a modificação</button>
                    </div>
                </div>

