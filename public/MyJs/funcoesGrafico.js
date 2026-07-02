
        // funcao  de criacao de grafico de baras


        function graficodelinearsobreado($messes,$Foradoprazo,$produtosArmazem,$vendido){
             // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  : $messes,
      datasets: [
        {
          label               : 'produtos  do Armazem',
          fillColor           : 'rgba(24, 96, 250, 0.342)',
          strokeColor         : 'rgba(24, 96, 250, 0.342)',
          pointColor          : 'rgba(24, 96, 250, 0.342)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : $produtosArmazem
        },
        {
          label               : 'Fora do prazo',
          fillColor           : 'rgba(250, 24, 24, 0.342)',
          strokeColor         : 'rgba(250, 24, 24, 0.342)',
          pointColor          : 'red',
          pointStrokeColor    : 'red',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(250, 24, 24, 1)',
          data                :$Foradoprazo
        },
        {
            label               : 'vendido',
            fillColor           : 'rgba(9, 241, 67, 0.514)',
            strokeColor         : 'rgba(9, 241, 67, 0.514)',
            pointColor          : 'rgba(9, 241, 67, 0.514)',
            pointStrokeColor    : 'rgba(9, 241, 67, 0.514)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(9, 241, 67, 1)',
            data                :$vendido
          }
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
    areaChart.Line(areaChartData, areaChartOptions)


        };



       // grafico circular

       function  graficocircular($ForadoprazoTAmanho, $DentrodoprazoTAmanho,
	   $vendidoTamanho,$produtosArmazemtamanho,$produtosPrestesForadePrazo){
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieChart       = new Chart(pieChartCanvas)
        var PieData        = [
          {
            value    :$ForadoprazoTAmanho,
            color    : '#f56954',
            highlight: '#f56954',
            label    : 'produtos fora do prazo'
          },
          {
            value    : $vendidoTamanho,
            color    : '#00a65a',
            highlight: '#00a65a',
            label    : 'vendas realizadas'
          },
          {
            value    : $produtosPrestesForadePrazo,
            color    : '#f39c12',
            highlight: '#f39c12',
            label    : 'prestes a passar  de prazo'
          },
          {
            value    : $DentrodoprazoTAmanho,
            color    : '#00c0ef',
            highlight: '#00c0ef',
            label    : "Dentro do prazo"
          },
          {
            value    : $produtosArmazemtamanho,
            color    : '#3c8dbc',
            highlight: '#3c8dbc',
            label    : 'Produtos no armazem'
          }

        ]
        var pieOptions     = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke    : true,
          //String - The colour of each segment stroke
          segmentStrokeColor   : '#fff',
          //Number - The width of each segment stroke
          segmentStrokeWidth   : 4,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps       : 100,
          //String - Animation easing effect
          animationEasing      : 'easeOutBounce',
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate        : true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale         :true,
          //Boolean - whether to make the chart responsive to window resizing
          responsive           : true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio  : true,
          //String - A legend template
          legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions)
       }
