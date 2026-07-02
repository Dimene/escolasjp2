
<style>
    body {
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
    }

    .info-box {
        min-height: 100px;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 0 10px #e0e0e0;
    }

    .info-box .info-box-icon {
        height: 80px;
        width: 80px;
        font-size: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-box-content {
        padding-left: 10px;
        font-size: 14px;
    }

    .info-box-text {
        font-weight: 600;
        font-size: 14px;
        color: #444;
    }

    .info-box-number {
        font-size: 18px;
        font-weight: bold;
        color: #000;
    }

    .description-block {
        padding: 10px;
        font-size: 13px;
        text-align: center;
    }

    .description-header {
        font-size: 16px;
        font-weight: bold;
        color: #000;
    }

    .description-percentage {
        font-size: 14px;
        font-weight: bold;
    }

    canvas {
        max-width: 100%;
        height: auto !important;
    }

    @media (max-width: 768px) {
        .info-box .info-box-icon {
            height: 60px;
            width: 60px;
            font-size: 24px;
        }

        .info-box-number {
            font-size: 16px;
        }

        .description-header {
            font-size: 14px;
        }
    }
</style>

<div class="row">

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>

            <div class="info-box-content">
                <span class="info-box-text dadosInfoDiaria"><a href="">Total de Diarias</a></span>
                <span class="info-box-number">
                    {{ $dados[0]->diarias }}

                    <small></small>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Mensal</span>
                <span class="info-box-number">{{ $dados[0]->mensal }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-group"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Esperado</span>
                <span class="info-box-number">{{ $dados[0]->Esperado }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"></span>
                <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">

            <div class="col-12 col-sm-6 col-md-8">
                <div class="info-box ">




                    <canvas id="myChart" width="400"></canvas>


                    <!-- /.info-box -->
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box ">

                    <canvas id="mypisa"></canvas>
                </div>
                <!-- /.info-box -->
            </div>
        </div>





        <div class="row card-footer">
            <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i>
                        @if ($dados[0]->mensal > 0)
                            {{ ($dados[0]->diarias / $dados[0]->Esperado) * 100 }}%
                        @endif
                    </span>
                    <h5 class="description-header">{{ $dados[0]->diariasvalor + $dados[0]->QtdadeEmValorMulta }},00MT
                    </h5>
                    <span style="font-size: 11px;"> <b>Multa:</b>{{ $dados[0]->QtdadeEmValorMulta }}
                        <b>Mensalidade:</b>{{ $dados[0]->diariasvalor }}
                    </span><br>
                    <span class="description-text">TOTAL DIARIO</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                    @if ($dados[0]->mensal > 0)
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i>
                            {{ ($dados[0]->mensal / $dados[0]->Esperado) * 100 }}%</span>
                    @endif
                    <h5 class="description-header">{{ $dados[0]->Mensalivalor + $dados[0]->MensalivalorMulta }},00MT
                    </h5>
                    <span style="font-size: 11px;"> <b>Multa:</b>{{ $dados[0]->MensalivalorMulta }}
                        <b>Mensalidade:</b>{{ $dados[0]->Mensalivalor }}
                    </span><br>
                    <span class="description-text">TOTAL MENSAL</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i></span>
                    <h5 class="description-header"></h5>
                    <span class="description-text"></span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-6">
                <div class="description-block">
                    <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 100%</span>
                    <h5 class="description-header">{{ $dados[0]->EsperadoValor }},00MT</h5>
                    <span class="description-text">MENSAL ESPERADO</span>
                </div>
                <!-- /.description-block -->
            </div>
        </div>



</section>
