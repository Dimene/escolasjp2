@if ($id == 0)
    @extends('layouts.admin-Lti')
    @section('title', 'Fazer PAgamento')
    @section('content')
    @endif;

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <center>
                            <h4>Enviar Pagamento</h4>
                        </center>
                    </div>
                    <div class="col-md-8 ">
                        <center>
                            <img src="{{ asset('imageproceaament/mpesalogo.png') }}" alt="Logo"
                                class="img-circle elevation-5"
                                style="opacity: .8 width:100px; height:100px; margin-left:150px;">
                        </center>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('enviar-pagamento') }}">
                            @csrf

                            <div class="form-group">
                                <label for="input_TransactionReference">Referência da Transação</label>
                                <input type="text" required name="input_TransactionReference" class="form-control"
                                    id="input_TransactionReference">
                            </div>

                            <div class="form-group">
                                <label for="input_CustomerMSISDN">Número do Cliente</label>
                                <input type="text" name="input_CustomerMSISDN" class="form-control"
                                    id="input_CustomerMSISDN" required>
                            </div>

                            <div class="form-group">
                                <label for="input_Amount">Valor</label>
                                <input type="text" required name="input_Amount" class="form-control" id="input_Amount">
                            </div>

                            <!-- Adicione outros campos conforme necessário -->

                            <button type="submit" class="btn btn-primary">Enviar Pagamento</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($id == 0)
        @endsection
    @endif
