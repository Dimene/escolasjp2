<form method="post" action="{{ Route('turma.store') }}" >

@csrf
 <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
 <div class="row mb-2">
    <div class="col-md-5">
	@if(!empty($alunoclasse))
<input value="{{$alunoclasse[0]->Classe_id}}"    type="hidden" name="classeFrequentada">
<input value="{{$alunoclasse[0]->anolectivo_id}}"   type="hidden"  name="Anolectivo_IDD">
@endif

<div class="card">
    <div class="card-body">
       <table id="listadosalunos" class="display no-shadow table table-light container-fluid" >
    <thead>
    <tr>
    <th>Nr</th>
    <th>Nome</th>
    <th><i class="fa fa-2x fa-arrow-right py-2 passarparaturma"></i></th>
    </thead>
       <tbody class="tbodyListaclasses">


@foreach ( $alunoclasse as $key=> $alunoclasseItem)
     <tr class="{{ $alunoclasseItem->idAlunoclasse }}tr">
     <td><input  type="hidden" class="alunoporanoselecionado"    name="alunoClasse"
     value="{{  $alunoclasseItem->idAlunoclasse }}"  >
     {{$key+1}}

     </td>
     <td>{{ $alunoclasseItem->nome}}</td>
    <td>
    <span class="badge badge-primary selecionarunico">

    <i class="fa  fa-2x fa-caret-right selecionarunico"
    nome="{{  $alunoclasseItem->nome }}"
    index="{{$key+1  }}"
    idalunoIntem="{{ $alunoclasseItem->idAlunoclasse }}" aria-hidden= "true"></i></i>

</span>
</td>
            </tr>


@endforeach
</table>
    </div>
</div>


     </div>



    <div class="col">

        <div class="card">
            <div class="card-body">

               @if (!empty($turmascriadas[0]->turmas))

               @foreach ($turmascriadas as $Item )
			   <input name="turma_id[]" value="{{$Item->turma_id }}">
               <a class="badge badge-primary">{{  $Item->turmas }}</a>
               @endforeach

               @endif
            </div>

        </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Atribua nome da Turma</h5><br>
          <div class="container">
		  <input  name="nomeTurma" type="text" class="form-control col">

		  </div>
          <div class="container conteudo">



        <table class="table table-light"  id="listadosalunosTurma" class="display no-shadow table table-light container-fluid" >
        <thead>

        <th>Nr</th>
        <th>Nome</th>
        <th> <i class=" fa fa-2x fa-arrow-left"></i></th>
        </thead>
            <tbody>
			  @if (!empty($turmascriadas[0]->turmas))
			@foreach($alunoclasseTurma as $key=>$turma)
		<tr>
		<td>{{$key+1}}</td>
		<td>{{$turma->nome}}</td>
		<td></td>

		</tr>
			@endforeach
			@endif

            </tbody>
        </table>

          <hr>
          </div>
          <div class="container "><hr>
          <input type="button"
           class="form-control  btn btn-primary   GuardarTurmaToda  difa fa-lg fa-save col-2 float-right"      value="Guardar">
           </div>

        </div>
      </div>
</div>
</form>




	<script>


	$(document).ready(function() {
var Turmas=[];
       var arrayid=[];
       var arrayname=[];
       var arrayNr=[];
       var count=1;








     //selecionar alunos
$("table>tbody>tr").click(function(){

    $(this).toggleClass("selected");
var id= ($(this).children("td:nth-child(1)").find(".alunoporanoselecionado").val());
var nome= $(this).children("td:nth-child(2)").text();
var nr= $(this).children("td:nth-child(1)").text();


 var $dadosremove=[];

$index= 0;




 if(arrayid.indexOf(id)>-1){

   console.log(arrayid.indexOf(id));
  arrayid.splice(arrayid.indexOf(id),1);
  arrayname.splice(arrayid.indexOf(id),1);
  arrayNr.splice(arrayNr.indexOf(id),1);
}
else{

   arrayid.push( $(this).children("td:nth-child(1)").find(".alunoporanoselecionado").val());
   arrayname.push($(this).children("td:nth-child(2)").text());
   arrayNr.push(parseInt(nr));
}




//console.log(arrayid);
//console.log(arrayname);
console.log(arrayNr);






});




     //fim  de selecoa de alunos
var tabela=    $('#listadosalunos').DataTable( {

            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            "lengthMenu": [[5, 10, 25, 50, -1], [5,10, 25, 50, "All"]],
            language: {
              "lengthMenu": "visualizar _MENU_ ",
              "zeroRecords": "Nada foi encontado",
              "info": "mostrara pagina por pagina",
              "processing":     "processando..",
              "infoEmpty": "Nada tem ",
              "infoFiltered": "(filtered from _MAX_ total records)",
              "loadingRecords": "processando...",
              "search":         "pesquisar:",
              "paginate": {
          "first":      "primera",
          "last":       "ultima",
          "next":       "proxima",
          "previous":   " Anterior"
        },
          },

        } );
 var tabelaTurma=$('#listadosalunosTurmazx').DataTable( {

            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            "lengthMenu": [[ 10, 25, 50, -1], [10, 25, 50, "All"]],
            language: {
              "lengthMenu": "visualizar _MENU_ ",
              "zeroRecords": "Nada foi encontado",
              "info": "mostrara pagina por pagina",
              "processing":     "processando..",
              "infoEmpty": "Nada tem ",
              "infoFiltered": "(filtered from _MAX_ total records)",
              "loadingRecords": "processando...",
              "search":         "pesquisar:",
              "paginate": {
          "first":      "primera",
          "last":       "ultima",
          "next":       "proxima",
          "previous":   " Anterior"
        },
          },

        } );


// adicionar a turma

 $(".passarparaturma").click(function(){



tabela.rows('.selected').remove().draw( false );

arrayid.forEach(function(e){

var mtmls='<tr><td><input name="classes[]" value="'+e+'" />">'+count+'</td><td>'+rrayname[$index]+'</td><td></td><i  clasSSIDALUNO="'+e+'"  index="'+arrayNr[$index]+'" nome="'+arrayname[$index]+'"  class="fa fa-arrow-left removedaListaUnitariamente" aria-hidden= "true"></i></tr>';
$("#listadosalunosTurma>tbody").append(mtmls);


count++;


   $index++; });
  arrayid=[];
     arrayname=[];
        arrayNr=[];

    });






// selecionar unicamente




//selecionar unicamente

$(".selecionarunico").click(function(e){
	e.stopPropagation();
  var classe=$(this).attr("idalunoIntem");
  var classeIndex=$(this).attr('index');
  var nome=$(this).attr('nome');
  if(nome!="undefined"){
tabela.row("."+classe+"tr").remove().draw( false );

 /*tabelaTurma.row.add( ['<input type="hidden" value="'+classe+'" indexdata="'+classeIndex+'">'+count,nome,
         '<i class="fa fa-arrow-left removedaListaUnitariamente" nome="'+nome+'" aria-hidden= "true"></i>' ] ).draw( false );
*/var mtmls='<tr><td><input name="classes[]" value="'+classe+'" />'+count+'</td><td>'+nome+'</td><td><i class="fa fa-arrow-left removedaListaUnitariamente"   clasSSIDALUNO="'+classe+'"  index="'+classeIndex+'" nome="'+nome+'" aria-hidden= "true"></i></td></tr>'
         $("#listadosalunosTurma>tbody").append(mtmls);




count++;
}

  arrayid=[];
     arrayname=[];
        arrayNr=[];
});


// remover unicamente


       } );




$(document).on('click','.removedaListaUnitariamente',function(e){
e.stopPropagation();
  $(this).parents('tr').remove();



  return false;
})


// funcao que adiciona elementos na pagina

function addicionaraturma(idclassAluno,index,nome){

  var urlSelectAlunoItem ="{{Route('turma.store')}}";

  var token ='{{Session::token()}}';
     var classesItem=[];

			   $("input[name='urlSelectAlunoItem']:checked").each(function(){
				   classesItem.push(this.value);
			   });

			   $.ajax({
            url: urlSelectAlunoItem,
            type: 'POST',
           // dataType:"json",
			data:{_token:token,
			index:index,
			nome:nome,
			classes:idclassAluno},
            success: function (data, textStatus, jqXHR) {






            }
               });
}



$(".GuardarTurmaToda").click(function(){
	 var classesItem=[];
var nomeTurma=$("[name='nomeTurma']").val();
var Anolectivo_IDD=$("[name='Anolectivo_IDD']").val();
var classeFrequentada=$("[name='classeFrequentada']").val();

			   $("input[name='classes[]']").each(function(){
				   classesItem.push(this.value);
			   });
			   if(classesItem==""||nomeTurma==""){
			   alert("precha  os dados necesarios");
			   }
			   else{




				   var urlSelectAlunoItem ="{{Route('turma.store')}}";

  var token ='{{Session::token()}}';


			   $.ajax({
            url: urlSelectAlunoItem,
            type: 'POST',
           // dataType:"json",
			data:{'_token':token,
			nomeTurma:nomeTurma,
			classesItem:classesItem,
			classeFrequentada:classeFrequentada,
			Anolectivo_IDD:Anolectivo_IDD,


			},
            success: function (data, textStatus, jqXHR) {

               $(".conteudo").html(data);



            }
               });
				   console.log(nomeTurma,classesItem,classeFrequentada,Anolectivo_IDD);
			   }

});
    </script>
