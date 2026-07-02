$(document).ready(function(){
	$(".myano").change(function(){
		$ano=$(this).val();
		  
		  
		  	  $.ajax({
            url: '/aluno/aluno/'+$ano,
            type: 'GET',
            success: function (data, textStatus, jqXHR) {
$(".AdicionarTabela").html(data);
   }
   });

	});
});