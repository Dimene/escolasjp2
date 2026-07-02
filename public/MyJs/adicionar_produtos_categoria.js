



    // adicionar as caracteristicas inicias
  $(document).ready(function(){

    Html="";
    $(".adicionar-Caracteristicas").click( function(){



        $.ajax({
            url: "/caracteriticas/json",
            type: 'GET',
            dataType:'json',
            success: function (data, textStatus, jqXHR) {
Html="";
     for($x=0;$x<data.length;$x++){

    Html+='<option  value="'+data[$x]['id']+'">'+data[$x]['Descricao']+'</option>';
     }

            }
        });

    $('.elementosCaracterisitcas').append(' <div  class="form-row col-md-12">\
      <div class="col-sm-12 col-md-10">\
         <select class="form-control"  name="Caracteristicas[] style="width: 100%;" tabindex="-1" aria-hidden="true">'+
                Html+
             '</select>\
     </div>\
         &nbsp;<button class="   remover_campo btn btn-danger active shadow botaoRemoverContactoForm botaoContactoReAdd " \
     type = "button"   style="height:30px; width:40px;"> <i class="fa fa-close"> </i></button></div ><br><br></div>')


});

//fim adicionarcaracterisicas


//adicionar caracteriticas2

$(".adicionar-Caracteristicas2").click( function(){




    $('.elementosCaracterisitcas2').append(' <div  class="form-row col-md-12">\
      <div class="col-sm-12 col-md-10">\
        <input  class="form-control" type="text" name="Caracteristicas2[]">\
     </div>\
         &nbsp;<button class="   remover_campo2 btn btn-danger active shadow botaoRemoverContactoForm botaoContactoReAdd " \
     type = "button"   style="height:30px; width:40px;"> <i class="fa fa-close"> </i></button></div ><br><br></div>');
});

// fim caracterticas 2

$(".botaoModal").click( function(){
$(".Categoria_id").val($(this).attr('idconponent'));


//$('[name="Categoria_produto_tipo"]').val();
$(".Categoria_produto_tipo").html('Registo Tipo de'+" "+$(this).attr('title'));
});


// remover caracterisiticas 1

$('.elementosCaracterisitcas').on("click", ".remover_campo", function(e) {
    e.preventDefault();
    $(this).parent('div').remove();
    x--;
});

//remover caractericas 2


$('.elementosCaracterisitcas2').on("click", ".remover_campo2", function(e) {
    e.preventDefault();
    $(this).parent('div').remove();
    x--;
});

//fim remover caracteriticas 1 2

})
