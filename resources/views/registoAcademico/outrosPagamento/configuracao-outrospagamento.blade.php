<div class="card">
    <div class="card-body">
        <h5 class="card-title" style="text-align: center; border: 5px">Configura&ccedil;&atilde;o  de {{ $dados->Descricao }}</h5>
        <hr>

<div class="row">
<div class="col-md-8">

</div>

<div class="col">

    <div class="btn-group btn-group-toggle  float-right " data-toggle="buttons"  >
        <label    class="btn    btn-success btn-danger BTN_CONT" >
          <input type="radio" name="options"  value="Não Pago"
           id="option_b1" autocomplete="off">Mensal
        </label>

        <label   class="btn    btn-success active BTN_CONT " >
          <input type="radio" name="options" id="option_b2"
            value="Pago" autocomplete="off">  Anual
        </label>

      </div>
</div>
</div>


        {{ $dados }}
    </div>
</div>


<script src="{{ asset('Datatable/js/jquery-3.5.1.js')}}"></script>
    <script>




</script>
