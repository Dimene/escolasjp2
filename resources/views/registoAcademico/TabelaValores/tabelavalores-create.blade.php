
  
 <center> <legend><b>Registo de Valores</b></legend></center>
  <form class="formularioValores"  action="{{Route('TabelaValores.store')}}" method="post">
  @csrf
  <div class="row">
   <div class="col-md-6 border">
   
       
       <div class="form-group">
         <label for="my-select-AnoLectivo">Ano Lectivo</label>
         <select id="my-select-AnoLectivo" class="custom-select" name="AnoLectivo">
         @foreach ($anolectivo as $anolectivoItem)
           
        
           <option value="{{$anolectivoItem->id}}" selected>{{$anolectivoItem->anolectivo}}   </option>
            @endforeach
         </select>
       </div>
       
        <div class="form-group">
           <label for="my-Descricao">Descrição</label>
           <input id="my-Descricao" class="form-control" type="text"  list="Listapagamentos"  name="Descricao">
             
		  <datalist  id="Listapagamentos" >
		  <option>MAtricula </option>
		  <option>Mensalidade</option>
		  <option>Uniforme</option>
		  
		  </datalist>
       </div>
	   
	   <div class="form-group">
           <label for="my-Montante">Montante</label>
           <input id="my-Montante" class="form-control" type="text" name="Montante">
       </div>
	    <div class="form-group">
           <label for="my-Multa">Multa%</label>
           <input id="my-Multa" class="form-control" type="text" name="Multa"  >
       </div>
	   
	   
       
   </div> 
   <div class="col-md-6  ">
   <ul class="list-group classesDiv">
  
    @for($x=0; $x<count($clases); $x++)
 
        <li class="list-group-item">

        <label>
                <input type="checkbox" value="{{$clases[$x]->id}}" class="classes" name="classes">   {{$clases[$x]->Descricao}}
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




</div>
</div>

<script>

	$(".guardarpreco").click(function(e){
			
			 e.preventDefault;
			$(".guardarpreco").prop('disabled',true);
           if($("[name='Descricao']").val()==""){$("[name='Descricao']").css('border','2px solid red');}
           else if($("[name='Descricao']").val()!=""){$("[name='Descricao']").css('border','2px solid #dee2e6');}
		   if($("[name='Montante']").val()==""){$("[name='Montante']").css('border','2px solid red');}
           else if($("[name='Montante']").val()!=""){$("[name='Montante']").css('border','2px solid #dee2e6');}
		    if($("[name='Multa']").val()==""){$("[name='Multa']").css('border','2px solid red');}
           else if($("[name='Multa']").val()!=""){$("[name='Multa']").css('border','2px solid #dee2e6');}
		    
			if($("[name='classes']").is(":checked")){$(".classesDiv").css('border','2px solid #dee2e6');}
           else{$(".classesDiv").css('border','2px solid red');}
		   
		   
		   //  enviar dados para guardar 
		   
		   if($("[name='Descricao']").val()!=""
		   &&$("[name='Montante']").val()!="" 
		  &&$("[name='Multa']").val()!=""
		  &&$("[name='classes']").is(":checked")
		  ){
			   
			   
			   // ajax enviar valores na tabela;
			   
			   var classesItem=[];
			   
			   $("input[name='classes']:checked").each(function(){
				   classesItem.push(this.value);
			   });
			   
			   $.ajax({
            url: urlstore,
            type: 'POST',
			dataType:'json',
			data:{_token:token,
			Descricao:$("[name='Descricao']").val(),
			AnoLectivo:$("[name='AnoLectivo']").val(),
			Montante: $("[name='Montante']").val(),
			Multa:$("[name='Multa']").val(),
			classes:classesItem},
            success: function (data, textStatus, jqXHR) {
				
				// limpar os campos 
				$("[name='Descricao']").val("");
		$("[name='Montante']").val(""); 
		 $("[name='Multa']").val("");
		  $("[name='classes']").prop("checked",false);
		  // fim limpar campos 
		  
		  
		  
		  
		  
		  
		
 //tabelashow();

var table = $('#listadevalorestabela').DataTable();

var rowNode = table
    .row.add( [data[0]['Descricao'], data[0]['valorDescricao'], data[0]['multa'], data[0]['classes'],data[0]['anolectivo'] ,"<button  class='btn btn-primary'> <i class='fa fa-edit'>"+
 "</i></button><button class='btn btn-danger'> <i class='fa fa-trash'></i></button>"] )
    .draw()
    .node();
	
 
$( rowNode )
    .css( 'background', 'red' )
    .animate( { color: 'black' } );		

 $("[type='search']").val(data[0]['Descricao']);
 $("[type='search']").blur();
 
 table.search( data[0]['Descricao'] )
        .draw();
 
		   
		  $(".ListaItemDiv").fadeIn("slow");;
		  $(".TablelaAdicionar").fadeOut("slow");
       
      
        

            }
   });
		   }
		   
		   
        
		
		
		
		});
		
		
	
</script>
	
	
	
	