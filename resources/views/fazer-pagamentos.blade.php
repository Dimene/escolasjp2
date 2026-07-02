
<section class="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid shadow-no">
                    <div class="row mb-2">
                        <div class="col-sm-6">

                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Notificacao</a></li>
                                <li class="breadcrumb-item active">Sms</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                  <div class=" container container-fluid">
                <div class="card">
                    <div class="card-header">Enviar Pagamento</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('enviar-pagamento') }}">
                            @csrf

                            <div class="form-group">
                                <label for="input_TransactionReference">Referência da Transação</label>
                                <input type="text" name="input_TransactionReference" class="form-control"
                                    id="input_TransactionReference">
                            </div>

                            <div class="form-group">
                                <label for="input_CustomerMSISDN">Número do Cliente</label>
                                <input type="text" name="input_CustomerMSISDN" class="form-control"
                                    id="input_CustomerMSISDN">
                            </div>

                            <div class="form-group">
                                <label for="input_Amount">Valor</label>
                                <input type="text" name="input_Amount" class="form-control" id="input_Amount">
                            </div>

                            <!-- Adicione outros campos conforme necessário -->

                            <button type="submit" class="btn btn-primary">Enviar Pagamento</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
  </div>
  </section>
  
