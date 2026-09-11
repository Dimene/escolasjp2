<?php $__env->startSection('title', 'Ano Lectivo'); ?>
<?php $__env->startSection('content'); ?>

<style>
    /* Customizações adicionais */
    .content-wrapper {
        background-color: #f8f9fa;
    }
    .card {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        border-radius: 0.75rem;
        transition: box-shadow 0.2s;
    }
    .card:hover {
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.12);
    }
    .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        font-weight: 600;
        padding: 1.25rem 1.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .table th {
        border-top: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    .table td {
        vertical-align: middle;
    }
    .table tbody tr:hover {
        background-color: #f8f9fc;
    }
    .action-btns .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.5rem;
        margin: 0 2px;
    }
    .alert-custom {
        border-radius: 0.75rem;
        border-left: 4px solid;
        padding: 1rem 1.5rem;
    }
    .alert-success-custom {
        background-color: #e6f7e6;
        border-left-color: #28a745;
        color: #1e7e34;
    }
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(1.5em + 0.75rem + 2px) !important;
        padding: 0.375rem 0.75rem;
    }
    .select2-container--bootstrap4 .select2-selection__rendered {
        line-height: 1.5 !important;
    }
    .select2-container--bootstrap4 .select2-selection__arrow {
        height: calc(1.5em + 0.75rem) !important;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
    }
    .section-title i {
        margin-right: 0.75rem;
        color: #4e73df;
    }
</style>
<div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-cogs"></i> Gestão de Administrativa</a>
            </li>

 <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-sliders"></i>  Configuracoes</a>
            </li>

            <li class="breadcrumb-item active">
                <i class="fa fa-table"></i> <b>Tabela de  Valores</b>
            </li>
        </ol>
    </div>
<!-- Content Wrapper. Contains page content -->
<div class="">
  <!-- Content Header (Page header) -->

<?php if($errors->any()): ?>
    <div class="alert alert-danger container-fluid col-md-8">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
  <!-- /.content-header -->


  <div class="row container-fluid  mx-auto">
  <div class="col-md-12">

 <?php echo $__env->make("Componetes.menu-componte-tabelavalores", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </diV>
  <div class="col-md-12">

  <!-- Main content -->
  <div class="TablelaVisualizar ListaItemDiv">
  <?php if(isset($colecao)): ?>
    <div class="alert alerta-cadastro alert-success " role="alert">
        <h4 class="alert-heading"><?php echo e($colecao); ?></h4>

    </div>
	  <?php endif; ?>
    <div class="content-Add no-border   Tabelashow"  >
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <center>
                <h4 class="GuardarNovo" >Criar novo Tipo de Pagamento</h4>
                <h4 class="AtualizarNovo" style="display: none"> Atualzar Tipo de Pagamento</h4>
<hr>
            </center>

<form  method="post" action>
    <?php echo method_field("PUT"); ?>
    <?php echo csrf_field(); ?>

<div class="row">

<div class="col">
<label>Nome </label>
    <input value="" name="Idpagamento" type="hidden">
<input class="form-control nomePagamento" required type="text" name="nomePagamento">
</div>
<div class="col">
<label>Icon </label>
  <select id="icon-select" style="width: 100%;" class="form-control icon" name="icon">
    <option value="fa-user" data-icon="fa-solid fa-user">Usuário</option>
    <option value="fa-users" data-icon="fa-solid fa-users">Usuários</option>
    <option value="fa-envelope" data-icon="fa-solid fa-envelope">E-mail</option>
    <option value="fa-cog" data-icon="fa-solid fa-cog">Configuração</option>
    <option value="fa-id-card-o" data-icon="fa-solid fa-id-card-o">Cartão</option>
    <option value="fa-car" data-icon="fa-solid fa-car">Carro</option>
    <option value="fa-camera-retro" data-icon="fa-solid fa-camera-retro">Câmera</option>
    <option value="fa-book" data-icon="fa-solid fa-book">Livro</option>
    <option value="fa-shopping-cart" data-icon="fa-solid fa-shopping-cart">Carrinho</option>
    <option value="fa-money" data-icon="fa-solid fa-money">Dinheiro</option>
    <option value="fa-chart-line" data-icon="fa-solid fa-chart-line">Relatórios</option>
    <option value="fa-calendar-alt" data-icon="fa-solid fa-calendar-alt">Calendário</option>
    <option value="fa-file-alt" data-icon="fa-solid fa-file-alt">Documentos</option>
    <option value="fa-phone" data-icon="fa-solid fa-phone">Telefone</option>
    <option value="fa-lock" data-icon="fa-solid fa-lock">Segurança</option>
    <option value="fa-heart" data-icon="fa-solid fa-heart">Favoritos</option>
    <option value="fa-star" data-icon="fa-solid fa-star">Avaliações</option>
    <option value="fa-bell" data-icon="fa-solid fa-bell">Notificações</option>
    <option value="fa-map-marker-alt" data-icon="fa-solid fa-map-marker-alt">Localização</option>
    <option value="fa-globe" data-icon="fa-solid fa-globe">Internet</option>
    <option value="fa-cloud" data-icon="fa-solid fa-cloud">Armazenamento</option>
    <option value="fa-trash" data-icon="fa-solid fa-trash">Lixeira</option>
    <option value="fa-edit" data-icon="fa-solid fa-edit">Edição</option>
    <option value="fa-wrench" data-icon="fa-solid fa-wrench">Ferramentas</option>
    <option value="fa-code" data-icon="fa-solid fa-code">Código</option>
    <option value="fa-camera" data-icon="fa-solid fa-camera">Fotografia</option>
    <option value="fa-lightbulb" data-icon="fa-solid fa-lightbulb">Ideias</option>
    <option value="fa-chart-pie" data-icon="fa-solid fa-chart-pie">Estatísticas</option>
    <option value="fa-folder" data-icon="fa-solid fa-folder">Pasta</option>
    <option value="fa-download" data-icon="fa-solid fa-download">Download</option>
    <option value="fa-upload" data-icon="fa-solid fa-upload">Upload</option>
</select>
</div>

<div class="col-2">
<label> </label>
<button class="form-control btn btn-primary GuardarNovo "
type="button" name="GuardarNovo">
    Guardar
</button>

<button class="form-control btn btn-primary AtualizarNovo"
 type="button" name="AtualizarNovo"
  style="display:none"
 >Atualizar</button>

</div>
</div>
</form>
</div>

    </div>
</div>
<div class="card">
    <div class="card-body">




        <table class="table" id="listadevalorestabela">
        <thead>
        <tr>

        <th>Nr</th>
        <th >Icon</th>
        <th >Descções</th>
<th>Acções</th>
        </tr>
        </thead>
        <tbody class="boddy">
            <?php $__currentLoopData = $dados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $dadosItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<tr>
    <td><?php echo e($key+1); ?></td>
    <td> <i class="fa fa-lg <?php echo e($dadosItem->icon); ?>"></i></td>
    <td><?php echo e($dadosItem->Descricao); ?></td>
    <td class="action-btns">
        <button class="btn btn-outline-primary btn-edit edit-tipoPagamento btn-sm"
        title="<?php echo e($dadosItem->Descricao); ?>" id="<?php echo e($dadosItem->id); ?>"  icon="<?php echo e($dadosItem->icon); ?>"  tipo_janela="<?php echo e($dadosItem->tipo_janela); ?>" >
         <i class="fa fa-edit "></i></button>

         <button class="btn btn-outline-danger btn-trash apagarNovo btn-sm"
        title="<?php echo e($dadosItem->Descricao); ?>" id="<?php echo e($dadosItem->id); ?>"  >
         <i class="fa fa-trash "></i></button>
        

    </td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
        <tfoot>
         <tr>

        <th>Nr</th>
        <th>Icon</th>
        <th>Descções</th>
<th>Acções</th>

        </tr>
        </tfoot>


        </table>



</div>
</div>






</div>
<br>
</div>




</div>
</div>
</div>







    <!-- Conteúdo -->





  <!-- JS -->
  <?php $__env->startPush('scripts'); ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script>

















</script>


<style>
<style>
.novoItem {

background: red;
transition-property: background;
transition-duration: 30s;
transition-timing-function: linear;
transition-delay: 10s;
}

.aparecer {

background:#5DAC68;
}

</style>




<script>

$(document).ready(function () {
  // Inicializar Select2
  $('#icon-select').select2({
    templateResult: formatOption,
    templateSelection: formatOption,
    escapeMarkup: function (markup) {
      return markup;
    }
  });

  function formatOption(option) {
    if (!option.id) return option.text;
    const icon = $(option.element).data('icon');
    return `<span><i class=" fa fa-lg ${icon}"></i> ${option.text}</span>`;
  }



  // Eventos de CRUD
  /*$(".GuardarNovo").click(function () {
    const pagamento = $(".nomePagamento").val();
	 const icon = $("[name='icon']").val();
    $.ajax({
      url: "/tipoPagamento/guardar",
      type: 'POST',
      data: {
        nomePagamento: pagamento,
        "_token": $("meta[name='csrf-token']").attr("content"),
		icon:icon
      },
      success: function () {
        location.reload();
      }
    });
  });

  $(".AtualizarNovo").click(function () {
    const pagamento = $(".nomePagamento").val();
    const id = $("[name='Idpagamento']").val();

    const icon = $("[name='icon']").val();
    $.ajax({
      url: "/tipoPagamento/atualizar",
      type: 'POST',
      data: {
        nomePagamento: pagamento,
        icon:icon,
        id: id,
        "_token": $("meta[name='csrf-token']").attr("content")
      },
      success: function () {
        location.reload();
      }
    });
  });
  */

  $(".apagarNovo").click(function () {
    const id = $(this).attr("id");
    $.ajax({
      url: "/tipoPagamento/apagar",
      type: 'POST',
      data: {
        id: id,
        "_token": $("meta[name='csrf-token']").attr("content")
      },
      success: function () {
        location.reload();
      }
    });
  });
});

    $('#listadevalorestabela').DataTable( {


        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": true,
        "lengthMenu": [[4,5, 10, 25, 50, -1], [4,5,10, 25, 50, "All"]],
        language: {
          "lengthMenu": "visualizar _MENU_ ",
          "zeroRecords": "Nada foi encontado",
          "info": "mostrara pagina por pagina",
          "processing":     "processando..",
          "infoEmpty": "Nada tem ",
          "infoFiltered": "(filtered from _MAX_ total records)",
          "loadingRecords": "processando...",
          "search":         "pesquisar:",
          "paginate": {
      "first":      "primera",
      "last":       "ultima",
      "next":       "proxima",
      "previous":   " Anterior"
    },
      },
        initComplete: function () {
            this.api().columns([0,2,4,]).every( function () {
                var column = this;
                var select = $('<select  class="SelectorSerach"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );




</script>

<script>

    $(document).on("click",".edit-tipoPagamento",function(){
        $("[name='nomePagamento']").val($(this).attr('title'));
        $("[name='Idpagamento']").val($(this).attr('id'));

        $icon=$(this).attr('icon');
        $tipo_janela=$(this).attr('tipo_janela');

  $('#icon-select').val($icon).trigger('change');
  $('#tipo_janela').val($tipo_janela).trigger('change');

        $(".AtualizarNovo").show();
        $(".GuardarNovo").hide();



      });
    $(document).ready(function(){



        $(".GuardarNovo").click(function(){
const icon = $("[name='icon']").val();
           $pagamento= $(".nomePagamento").val();
            $.ajax({
                url:"<?php echo e(Route('tipoPagamento.guardar')); ?>",
                type: 'POST',
    data: {
    'nomePagamento': $pagamento,
	'icon':icon,

     "_token": "<?php echo e(csrf_token()); ?>",
      "_method": "PUT"
    },
    success: function(data){
        location.reload(true);

    }});

        });




        $(".AtualizarNovo").click(function(){

            $pagamento= $(".nomePagamento").val();
            $id= $("[name='Idpagamento']").val();


    const tipo_janela = $("[name='tipo_janela']").val();
    const icon = $("[name='icon']").val();
             $.ajax({
                 url:"<?php echo e(Route('tipoPagamento.atualizar')); ?>",
                 type: 'POST',
     data: {
     'nomePagamento': $pagamento,
     'id':$id,
     "icon":icon,

      "_token": "<?php echo e(csrf_token()); ?>",
       "_method": "PUT"
     },


     success: function(data){
        location.reload(true);

     }});

         });





         //apagar tipo de pagamento

         $(".apagarNovo").click(function(){



            $pagamento= $(this).attr('title');
           $id= $(this).attr('id');
             $.ajax({
                 url:"<?php echo e(Route('tipoPagamento.apagar')); ?>",
                 type: 'POST',
     data: {
     'nomePagamento': $pagamento,
     'id':$id,

      "_token": "<?php echo e(csrf_token()); ?>",
       "_method": "PUT"
     },


     success: function(data){
        location.reload(true);

     }});

         });
       });
</script>

<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/tipopagamento-create-novo.blade.php ENDPATH**/ ?>