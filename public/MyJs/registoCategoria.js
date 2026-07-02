
$(document).ready(function(){


// registo de categoria
  $('.guardarCategoria').click(function(){
    $.ajax({
        url:urlGuardarCategoria,
type:'POST',

data:{_token:token,
    Descricao:$("#nomeCategoria").val()},
    dataType:'json',
    success:function(data){

      $('.CategoriaColuna').find(".select2-selection__rendered").attr('title',data['Descricao']);
      $('.CategoriaColuna').find(".select2-selection__rendered").text(data['Descricao']);

$(".CategoriaElementosOPt").before("<option   value="+data['id']+" selected >"+data['Descricao']+"</option>");
    }

});

  });





    });
