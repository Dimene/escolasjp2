  $(document).ready(function(){


    $(".inputSelectData").change(function(){

                data=$(this).val();

                arraydata = data.split('-');



$dadoinicial=arraydata[0];
$novodataInicia=$dadoinicial.split('/');
$dadofinal=arraydata[1];
$novodataFinal=$dadofinal.split('/');

$dataIn=$novodataInicia[2].trim()+"-"+$novodataInicia[0].trim()+"-"+$novodataInicia[1].trim();
$dataFin=$novodataFinal[2].trim()+"-"+$novodataFinal[0].trim()+"-"+$novodataFinal[1].trim();

$(".RelatorioVendasFeitasDados").attr("href", 'Stoque/Relatorio/vendas/'+$dataIn+'/'+$dataFin+'');
$(".RelatorioArmazemDados").attr("href", 'Stoque/Relatorio/Armazem/'+$dataIn+'/'+$dataFin+'');
$(".RelatorioFarmaciaDados").attr("href", 'Stoque/Relatorio/farmacia/'+$dataIn+'/'+$dataFin+'');
$(".RelatorioForaDoPRazoDados").attr("href", 'Stoque/Relatorio/Foradoprazo/'+$dataIn+'/'+$dataFin+'');
 //  $(".").attr('href',urlvendasFeitas);
$.ajax({
	url:urlselecionar,
                    type:'POST',
                   data:{
                       _token:token,
                       dataInicial:$dadoinicial,
                       dataFinal:$dadofinal},
                  dataType:'json',
                  beforeSend:function(){
                    $(".formularioData").fadeOut()
                    $(".processamento").fadeIn()
                   },


                   success:function(data, textStatus, jqXHR){

                    $(".processamento").fadeOut();

                 $(".formularioData").fadeIn();


				 $arrayDias= new Array();
                $arrayDiasDado= new Array();
                $produtoFoadoprazorenge= new Array();
                $produtoFoadoprazorengeTamanho= 0;
                $arrayDiasDadotamanho=0;
                $vendido= new Array();
                $vendidoTamanho=0;


                data.forEach(function($elementos){
                    $arrayDias.push($elementos["dia"]);
                    $arrayDiasDado.push($elementos["comprado"]);
                    $produtoFoadoprazorenge.push($elementos["produtoFoadoprazorenge"]);
                    $produtoFoadoprazorengeTamanho =$produtoFoadoprazorengeTamanho+$elementos["produtoFoadoprazorenge"];

                    $arrayDiasDadotamanho= $arrayDiasDadotamanho+parseInt($elementos["comprado"]);


                    $vendido.push($elementos["vendido"]);
                    $vendidoTamanho=$vendidoTamanho+parseInt($elementos["vendido"]);

                });
                $(".QuantidadeNOArmazem").html($arrayDiasDadotamanho);
                $(".produtoFoadoprazorenge").html($produtoFoadoprazorengeTamanho);
                $(".produtosVendidos").html($vendidoTamanho);

				if( $vendido.length>10){
				 $("#GraficoLinhas").addClass("col-md-12");
 $("#GraficoCircular").addClass("col-md-12");
				}

                graficodelinearsobreado($arrayDias,$produtoFoadoprazorenge, $arrayDiasDado,$vendido);
               // graficocircular($ForadoprazoTAmanho, $DentrodoprazoTAmanho,$vendidoTamanho,$arrayDiasDadotamanho)
                graficocircular($produtoFoadoprazorengeTamanho, "",$vendidoTamanho,$arrayDiasDadotamanho,"")


                   }


});
	});

  });









