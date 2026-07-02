


  <!-- Main content -->
  <div class="content  container-fluid">
    <div class=" container  no-border no-shadow card-body" style="background-color: #fff">





	<div class="row">
              <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-right-tabContent">
                  <div class="tab-pane fade show active" id="vert-tabs-right-home" role="tabpanel" aria-labelledby="vert-tabs-right-home-tab">
				  <canvas id="myChart" >

</canvas>

					</div>
                  <div class="tab-pane fade" id="vert-tabs-right-profile" role="tabpanel" aria-labelledby="vert-tabs-right-profile-tab">






<?php $conter=1; ?>
<table>
    <tbody>
        <?php
         $totalmensalidades =0;
         $totalmulta =0;
         $total= 0;
        ?>
        @foreach ($arrayrelatorio as  $arrayrelatorioItem)
        @if ($conter==4) <?php $conter=1; ?> @endif
<?php
$totalmensalidades =   $totalmensalidades +$arrayrelatorioItem["valorpagoMensalidades"];
$totalmulta =  $totalmulta+$arrayrelatorioItem["valorpagodemulta"];
$total =$total+($totalmensalidades+$totalmulta);
?>

        @if( $conter==1)

         <tr >
             @endif
 <td><hr>
           <b>Mes:</b>    <a href="{{Route('mensalidade.Relatoriodetalhado',[$ano,$classe,$arrayrelatorioItem["mesId"]]) }}"  >
		   <input id="mes"  type="hidden" name='mes{{$arrayrelatorioItem["mesId"]}}' value='{{$arrayrelatorioItem["mes"]}}'
		   numeroAlunos='{{$arrayrelatorioItem["NrAlunos"] }}'
		   tranferencias='{{ $arrayrelatorioItem["tranferencias"] }}'
		   disistentes='{{ $arrayrelatorioItem["disistentes"] }}'
		   qtdQpagar='{{ $arrayrelatorioItem["qtdQpagar"] }}'
		   qtdQNpagar='{{ $arrayrelatorioItem["NrAlunos"]-$arrayrelatorioItem["qtdQpagar"] }}'
		   >
           {{$arrayrelatorioItem["mes"]}}
           </a>
           <br>
           <b> Numero de Alunos:</b>{{ $arrayrelatorioItem["NrAlunos"] }}

 <br>

 <b>Transferências:</b>{{ $arrayrelatorioItem["tranferencias"] }}

 <br>
           <b>Desistentes:</b>{{ $arrayrelatorioItem["disistentes"] }}
 <br>
           <b> pagamento de Mensalidades:</b>{{ $arrayrelatorioItem["qtdQpagar"] }}

           <br>
           <b>Alunos com Multa:</b>{{ $arrayrelatorioItem["alunoscommulta"] }}
           <br>
           <b>pagamento de multas:</b>{{ $arrayrelatorioItem["valorpagodemulta"] }},00 MT
           <br>
           <b>Pagamento de   Mensalidades:</b>{{ $arrayrelatorioItem["valorpagoMensalidades"] }},00 MT
           <br>
           <b>Total :</b>{{ $arrayrelatorioItem["valorpagoMensalidades"]+$arrayrelatorioItem["valorpagodemulta"]}},00 MT,


 </td>

        <?php $conter++; ?>

        @if($conter==4)
    </tr>
        @endif
        @endforeach
<tr style="background-color: rgba(0,0,0,0.07);">
    <td>Total de Mensalidades : {{ $totalmensalidades}},00MT
    </td>

 <td>Total de Multas : {{ $totalmulta}},00MT
    </td>

    <td>Total  : {{ $total}},00MT
    </td>

</tr>
</tbody>
</table>




                   </div>



                  <div class="tab-pane fade" id="vert-tabs-right-messages" role="tabpanel" aria-labelledby="vert-tabs-right-messages-tab">










					</div>

                </div>
              </div>
              <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs nav-tabs-right h-100" id="vert-tabs-right-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" id="vert-tabs-right-home-tab" data-toggle="pill" href="#vert-tabs-right-home" role="tab" aria-controls="vert-tabs-right-home" aria-selected="true">Relatorio Grafico Barra</a>
                  <a class="nav-link" id="vert-tabs-right-profile-tab" data-toggle="pill" href="#vert-tabs-right-profile" role="tab" aria-controls="vert-tabs-right-profile" aria-selected="false"> Relatorio texto</a>
                  {{--  <a class="nav-link" id="vert-tabs-right-messages-tab" data-toggle="pill" href="#vert-tabs-right-messages" role="tab" aria-controls="vert-tabs-right-messages" aria-selected="false">Relatorio Grafico Circular</a>  --}}

                </div>
              </div>
            </div>





        </div>
      </div>


<!-- jQuery -->
<script src="{{ asset('Admin-LTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->

<script src="{{ asset('Admin-LTE/plugins/chartjs-old/Chart.min.js')}}"></script>
<!-- AdminLTE App -->

<!-- AdminLTE for demo purposes -->

<!-- Page specific script -->
<script>


//Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#myChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
	$meses= new Array();
	$numeroAlunos= new Array();
	$tranferencias= new Array();
	$disistentes= new Array();
	$qtdQpagar= new Array();
	$qtdQNpagar= new Array();
for(x=1;x<13;x++){
	$meses.push($('[name="mes'+x+'"]').val());
	$numeroAlunos.push($('[name="mes'+x+'"]').attr('numeroAlunos'));
	$tranferencias.push($('[name="mes'+x+'"]').attr('tranferencias'));
	$disistentes.push($('[name="mes'+x+'"]').attr('disistentes'));
	$qtdQpagar.push($('[name="mes'+x+'"]').attr('qtdQpagar'));
	$qtdQNpagar.push($('[name="mes'+x+'"]').attr('qtdQNpagar'));

}

    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  :$meses,
      datasets: [
        {
          label               : 'alunos inscrito',
          fillColor           : 'rgba(255, 255, 255, 0.342)',
          strokeColor         : 'rgba(24, 96, 250, 0.342)',
          pointColor          : 'rgba(24, 96, 250, 0.342)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : $numeroAlunos
        },


	   {
            label               : 'os que nao pagaram mensalidade',
            fillColor           : 'rgba(250, 24, 24, 0.342)',
            strokeColor         : 'rgba(250, 24, 24, 0.342)',
            pointColor          : 'red',
            pointColor          : 'red',
            pointStrokeColor    : 'red',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(250, 24, 24, 0.342)',
            data                :$qtdQNpagar
          },


		  {
            label               : 'toral dos que pagaram mensalidades',
            fillColor           : 'rgba(19, 241, 67, 0.514)',
            strokeColor         : 'rgba(19, 241, 67, 0.514)',
            pointColor          : 'rgba(19, 241, 67, 0.514)',
            pointStrokeColor    : 'rgba(19, 241, 67, 0.514)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(19, 241, 67, 1)',
            data                :$qtdQpagar
          },
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : true,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 6,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions);






</script>










