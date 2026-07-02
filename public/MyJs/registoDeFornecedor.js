$(document).ready(function(){


    $(".adicionar-Contacto").click(function(){
        $(".elementosContacto").append(' <div class="row"><div class="col-md-7 offset-3"><input class="form-control" required type="text" name="contacto[]" id="contacto" style="height: 30px;"'+
        ' placeholder=" Contac o do forncedor"  " > </div><span class="badge btn btn-danger  remover-Contacto" style="width:20px" ><i class="fa fa-minus">-</i></span></div><br>');
    });

    $(".elementosContacto").on('click','.remover-Contacto',function(){
        $(this).parent('Div').remove();
    })

    // guardar fonecedor
    $(".Guardar-fornecedor").click(function(){

if($("#NomeFornecedor").val()=="" || $("#endereco").val()==""||
     $("#Nuit").val()==""||$("#contacto").val()==""){

$(".AdicionarMessagremdeErro").html('<div class="alert-warning">os campos  sao de prenchimento obrigatorio</div>');
     }
     else{
                 $.ajax ({ url:urlstore,
     type:'POST',

     data:{_token:token,
     nome:$("#NomeFornecedor").val(),
     Endereco:$("#endereco").val(),
     Nuit:$("#Nuit").val(),
     contacto:$("#contacto").val()
     },
     dataType:'json',
      success: function (data, textStatus, jqXHR){

          if(data['nome']){
              $('.fornecedor-div').find(".select2-selection__rendered").attr('title', data['nome']);
              $('.fornecedor-div').find(".select2-selection__rendered").text(data['nome']);
              $(".FornecedorElementosOPt").before("<option   value='"+data['id']+"' selected>"+data['nome']+"</option>");
              $('#exampleModal').modal('hide');
              $("#NomeFornecedor").val()="";
              $("#endereco").val()="";
     $("#Nuit").val()="";
     $("#contacto").val()="";

alert(data);


            };
      },
      });
     }
    });

guadar_produto_funct();

});
