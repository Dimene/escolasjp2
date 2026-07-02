  $(document).ready(function(){


            $.ajax({
                url:urlmostrar,
                type:'Get',
                success:function(data){ 
				
				
$meses= new Array();
$produtosArmazem= new Array();
$vendido= new Array();
$Foradoprazo= new Array();
$produtosArmazemtamanho=0;
$vendidotamanho=0;
$produtosPrestesForadePrazo=0;
$ForadoprazoTAmanho=0;
$produtosDentrodoprazo=0;



data.forEach(function(e){
	
			  $meses.push(e["mes"]);
			  
			  $produtosArmazem.push(e["produtosArmazem"]);
			  $vendido.push(e["vendido"]);
			  $Foradoprazo.push(e["Foradoprazo"]);
			  $produtosArmazemtamanho=$produtosArmazemtamanho+ parseInt(e["produtosArmazem"]);
			  $vendidotamanho=$vendidotamanho+ parseInt(e["vendido"]);
			  $produtosPrestesForadePrazo= parseInt(e["produtosPrestesForadePrazo"]);
			  $ForadoprazoTAmanho= $ForadoprazoTAmanho+parseInt(e["Foradoprazo"]);
			  $produtosDentrodoprazo=parseInt(e["Dentroprazo"]);
			  //graficodelinearsobreado($meses,$Foradoprazo,$produtosArmazem,$vendido){
			   });

graficodelinearsobreado($meses,$Foradoprazo,$produtosArmazem,$vendido);
//raficocircular($ForadoprazoTAmanho, $DentrodoprazoTAmanho,$vendidoTamanho,$produtosArmazemtamanho){
 graficocircular($ForadoprazoTAmanho,$produtosDentrodoprazo,
	   $vendidotamanho, $produtosArmazemtamanho,$produtosPrestesForadePrazo);

     

         
				}
				
				
				
				
            });


			})