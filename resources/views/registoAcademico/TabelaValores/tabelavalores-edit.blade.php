

 <center> <legend><b><i class="fa fa-lg fa-edit"></i>Atualizar TAbela de Valores</b></legend></center>
  <form class="formularioValores"  action="{{Route('TabelaValores.store')}}" method="post">

      @method("PUT")
  @csrf
  <div class="row">
   <div class="col-md-6 card">


       <div class="form-group">
         <label for="my-select-AnoLectivo">Ano Lectivo</label>
         <select id="my-select-AnoLectivo" class="custom-select" name="AnoLectivo">
         @foreach ($anolectivo as $anolectivoItem)


           <option value="{{$anolectivoItem->id}}"   @if($tabelaItem->anolectivo_id==$anolectivoItem->id) selected  @endif;  >{{$anolectivoItem->anolectivo}}   </option>
            @endforeach
         </select>
       </div>

        <div class="form-group">
           <label for="my-Descricao">Descrição</label>
           <input id="my-Descricao" class="form-control" type="text" name="Descricao"  list="Listapagamentos" value="{{$tabelaItem->Descricao}}">

		  <datalist  id="Listapagamentos" >
		  <option>MAtricula </option>
		  <option>Mensalidades</option>
		  <option>Uniforme</option>
		  <option>Outros safsfsdfd</option>

		  </datalist>
       </div>

	   <div class="form-group">
           <label for="my-Montante">Montante</label>
           <input id="my-Montante" class="form-control" type="text"  value="{{$tabelaItem->valorDescricao}}" name="Montante">
       </div>
	    <div class="form-group">
           <label for="my-Multa">Multa%</label>
           <input id="my-Multa" class="form-control" type="text" name="Multa" value="{{$tabelaItem->multa}}" >
       </div>



   </div>
   <div class="col-md-6  ">
   <ul class="list-group classesDiv">

    @for($x=0; $x<count($clases); $x++)

        <li class="list-group-item">

        <label>
                <input type="checkbox" value="{{$clases[$x]->id}}" class="classes"
				@for($i=0; $i<count($classeporValor); $i++)
					@if($classeporValor[$i]->classe_id==$clases[$x]->id)  checked   @endif @endfor name="classes">
                       {{$clases[$x]->Descricao}}
            </label>


      </li>


    @endfor
    </ul>
   </div>

   </div>

   <br>
   <div class="col container-fluid">
      <button class="btn btn-primary float-right guardarpreco" type="button"  >
<i class="fa fa-save">&nbsp;</i>Guardar</button>
   </div>


          </div>
          </form>

</div>


