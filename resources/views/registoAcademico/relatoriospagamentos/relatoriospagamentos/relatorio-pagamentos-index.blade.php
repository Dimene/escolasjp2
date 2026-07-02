@extends('layouts.admin-Lti')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Registo Académico</a></li>
                            <li class="breadcrumb-item ">Relatorio</li>
                            <li class="breadcrumb-item active">pagamentos</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>


        <div class=" card conuainer">


            <div class="row card-body container-fluid">



                <div class="col-md-4">


                    <div class="form-group">
                        <label for="my-Classe">Classe</label>
                        <select id="my-Classe" class="form-control" name="">


                            <option value="0">Todas</option>
                            @foreach ($classe as $classeItem)
                                <option value="{{ $classeItem->id }}">{{ $classeItem->Descricao }}</option>
                            @endforeach




                        </select>
                    </div>
                </div>






                <div class="col">

                    <label> Escolha o intervalo dos Dias</label>
                    <div id="reportrange" class="pull-right form-control "
                        style="background: #fff;   cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">

                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span class="datashow"></span> <b class="caret"></b>
                    </div>



                </div>
                <div class="col-md-2">

                    <div class="form-group">
                        <label for="my-input"> </label>
                        <br>
                        <button class=" btn btn-primary imprimir-relatorioDario"><i class="fa fa-lg fa-print"></i></button>
                    </div>
                </div>







            </div>


            <div class="card">
                <div class="card-body conteudo conteudo-relatorio" id="conteudoRelatorio">

                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script type="text/javascript" src="{{ asset('bootstrap-daterangepicker-master/moment.js') }}"></script>
        <script type="text/javascript" src="{{ asset('bootstrap-daterangepicker-master/daterangepicker.js') }}"></script>
        <script>
            function adicionardadostabela() {

                var ano = $('#my-ano').val();

                var classe = $('#my-Classe').val();


                var s = $(".datashow").text();

                var myArray = s.split("-");
                var data1 = myArray[0];
                var data2 = myArray[1];

                var date1 = new Date(data1);
                var date2 = new Date(data2);



                data1send = date1.getFullYear() + "-" + (date1.getMonth() + 1) + "-" + date1.getDate();
                data2send = date2.getFullYear() + "-" + (date2.getMonth() + 1) + "-" + date2.getDate();

                console.log(data1send);
                console.log(data2send);

                $.ajax({
                    url: '/aluno/mensalidade/Relatorio/pagamentos/' + ano + '/' + classe + '/' + data1send + '/' +
                        data2send + '',
                    type: 'GET',
                    success: function(data) {
                        $(".conteudo").html(data);



                    },
                    beforeSend: function() {
                        $(".conteudo").html(
                            ' <img src="{{ asset('imageproceaament/loading.gif') }}"  style=" margin-left:500px;width:200px;height:200px">'
                            );
                    }

                })
            }



            $(document).ready(function() {
                $('#reservationtime').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 30,
                    format: 'MM/DD/YYYY h:mm A'
                }, function(start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                });
            });


            $(document).ready(function() {

                var cb = function(start, end, label) {
                    //console.log('FUNC: cb',start.toISOString(), end.toISOString(), label);
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }

                var ranges = {
                    'Hoje': [moment(), moment()],
                    'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Utimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                    'Ultimos 14 Dias': [moment().subtract(13, 'days'), moment()],
                    'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                    'Este Mês ': [moment().startOf('month'), moment().endOf('month')],
                    'Ultimo Mês ': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                        .endOf('month')
                    ]
                };

                var optionSet1 = {
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment(),
                    minDate: '01/01/2012',
                    maxDate: '12/31/2015',
                    dateLimit: {
                        days: 60
                    },
                    showDropdowns: true,
                    showWeekNumbers: true,
                    timePicker: false,
                    timePickerIncrement: 1,
                    timePicker12Hour: true,
                    showRangeInputsOnCustomRangeOnly: true,
                    ranges: ranges,
                    opens: 'left',
                    buttonClasses: ['btn btn-default'],
                    applyClass: 'btn-small btn-primary',
                    cancelClass: 'btn-small',
                    format: 'MM/DD/YYYY',
                    separator: ' to ',
                    locale: {
                        applyLabel: 'Submit',
                        cancelLabel: 'Clear',
                        fromLabel: 'From',
                        toLabel: 'To',
                        customRangeLabel: 'Custom',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                            'September', 'October', 'November', 'December'
                        ],
                        firstDay: 1
                    }
                };

                var optionSet2 = {
                    startDate: moment().subtract(9, 'days'),
                    endDate: moment(),
                    opens: 'left',
                    showRangeInputsOnCustomRangeOnly: true
                };

                var optionSet3 = {
                    startDate: moment().subtract(16, 'days'),
                    endDate: moment(),
                    opens: 'left',
                    showRangeInputsOnCustomRangeOnly: true,
                    ranges: ranges
                };

                $('#reportrange span').html(moment().subtract(1, 'days').format('MMMM D, YYYY') + ' - ' + moment()
                    .format('MMMM D, YYYY'));
                $('#reportrange').daterangepicker(optionSet3, cb);
                $('#reportrange').on('show.daterangepicker', function() {
                    console.log("show daterangepicker fired");
                });
                $('#options1').click(function() {
                    $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
                });
                $('#options2').click(function() {
                    $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
                });
                $('#options3').click(function() {
                    $('#reportrange').data('daterangepicker').setOptions(optionSet3, cb);
                });
                $('#destroy').click(function() {
                    $('#reportrange').data('daterangepicker').remove();
                });
            });




            $(document).ready(function() {
                adicionardadostabela();


            })



            $(document).on('click', '.applyBtn', function() {

                adicionardadostabela();


            });

            $(document).on('click', 'ul>li', function() {

                adicionardadostabela();


            });
            $(document).on('change', '#my-Classe', function() {


                adicionardadostabela();


            });


            $(document).on('click', '.imprimir-relatorioDario', function() {






                var ano = $('#my-ano').val();

                var classe = $('#my-Classe').val();


                var s = $(".datashow").text();

                var myArray = s.split("-");
                var data1 = myArray[0];
                var data2 = myArray[1];

                var date1 = new Date(data1);
                var date2 = new Date(data2);



                data1send = date1.getFullYear() + "-" + (date1.getMonth() + 1) + "-" + date1.getDate();
                data2send = date2.getFullYear() + "-" + (date2.getMonth() + 1) + "-" + date2.getDate();

                console.log(data1send);
                console.log(data2send);

                $.ajax({
                    url: '/aluno/mensalidade/Relatorio/pagamentosPrint/' + ano + '/' + classe + '/' +
                        data1send + '/' + data2send + '',
                    type: 'GET',
                    success: function(data) {



                        // var conteudo = document.getElementById('conteudoRelatorio').innerHTML;
                        tela_impressao = window.open('about:blank');
                        tela_impressao.document.write(data);
                        tela_impressao.window.print();
                        tela_impressao.window.close();

                    },
                    beforeSend: function() {
                        //  $(".conteudo").html(' <img src="{{ asset('imageproceaament/loading.gif') }}"  style=" margin-left:500px;width:200px;height:200px">');

                    }

                })


            })
        </script>
    @endpush
@endsection
