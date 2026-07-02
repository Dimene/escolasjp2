<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModalApagar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            <b>
                <div class="Categoria_produto_tipo"></div>
                <i class="fa fa-page-break"></i> </b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/produto/caractericas" method="post" >
            @csrf
<input  type="hidden"  name="Categoria_id" class="Categoria_id" />
          <div class="row">
            <label for="" class=" col-md-4">Nome/Tipo:</label>
  <input class="form-control col-md-7" name="Descricao">
          </div>
          <br>
          <center><label for="" class=" ">Nome  das Caracteristicas</label></center>

          <div class="row form-control">
<div class="row elementosCaracterisitcas">
<div class="col-md-10">

    <select class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" name="Caracteristicas[]">
        <option class="form-control"  value="">slecione A caracteriticas</option>

        @foreach ($carateristicas as $carateristicasItem)


        <option class="form-control"  value="{{ $carateristicasItem->id }}">{{ $carateristicasItem->Descricao }}</option>
        @endforeach
    </select></div>
<div class="col-md-2">
    <span class="btn btn-primary adicionar-Caracteristicas" ><i class="fa fa-plus"  ></i></span>
</div>
<br>
<br>
</div>
Caso nao tenha as Caracteristicas que necessita pode Adiicionar no Formulario Abaixo
<div class="row elementosCaracterisitcas2" >

    <div class="col-10"><input  class="form-control" type="text" name="Caracteristicas2[]">  </div>
    <div class="col-2"> <button  class=" btn badge-primary adicionar-Caracteristicas2"  type="button"><i class="fa fa-plus-circle"></i></button></div>
</div>

    </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
      </div>
    </div>
  </div>
</div>
@push('script')
<script>

    $.ajax({
        url: "/caracteriticas/json",
        type: 'GET',
        dataType:'json',
        success: function (data, textStatus, jqXHR) {

 }

        }
    });
</script>
<script src="{{ asset('Myjs/adicionar_produtos_categoria.js')}}"></script>
@endpush
