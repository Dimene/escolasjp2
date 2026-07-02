
	$(document).ready(function() {






	           tabelaIndex();
				tabelashow();

		
		$(".ListaItem").click(function(){
			tabelashow();
			$(".novo").css("background","#fff");
           $(".ListaItem").removeClass('active');
           $(this).addClass('active');
		   
		   $(".ListaItemDiv").hide();
		  $("."+$(this).attr('title')+"").fadeIn("slow");
        });
        
		
		
		
		// alterar  elementos da tabela 
		
		
		
		
		
		
		
		
		
    } );
	
	
	
	// retornar formulario 
	
	function tabelaIndex(){
		  $.ajax({
            url: "/RegistoAcademico/TabelaValores/create",
            type: 'GET',
            success: function (data, textStatus, jqXHR) {
				$(".tabelaformshow").html(data);
		  
			}
				  });
			
	}
	
	// retornar tabela 
	
	function tabelashow(){
		  $.ajax({
            url: "/RegistoAcademico/TabelaValores/show",
            type: 'GET',
            success: function (data, textStatus, jqXHR) {
				$(".Tabelashow").html(data);
		  
			}
				  });
			
	}
	
	//edit tabela 
	
	function tabelasEdit(){
		
		
		  $.ajax({
            url: "/RegistoAcademico/TabelaValores/"+$(this).attr('title')+"/edit",
            type: 'GET',
            success: function (data, textStatus, jqXHR) {
				 $(".TablelaAdicionar").fadeIn("slow");
		  $(".ListaItemDiv").fadeOut("slow");
				$(".tabelaformshow").html(data);
				
		 
		  
			}
				  });
			
	}
	
	
	
	
	
	