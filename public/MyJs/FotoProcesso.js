
$(document).ready(function(){
    $(".botao_File").click(function(){

        $(".file-upload").trigger("click");

    });


    //slecionar image
    var fileListArray = [];
    $(".file-upload").change( function(e){
        e.preventDefault();

         var imagesize = $(".file-upload ")[0].files.length;
         var x = document.getElementById("file-upload");
          var imagensSelect = x.files;


            for (i = 0; i < imagesize; i++) {
                var xa = window.URL.createObjectURL(imagensSelect[i]);

                fileListArray.push(imagensSelect[i].name);


                $("#file-Elemento").append("<div  posicao='"+i+"' class='card carato-foTo'  style='margin:5px;'>"+
                "<div class='card-body' style='width:200px; height:200px;'>"+
                "  <img style='width:100%;height:100%;' class='border rounded' src='" + xa + "'/>"+
                "</div><i style='color:rgb(244,22,22);padding:10px' indiceremove='"+i+"' class='fa fa-trash-o border shadow Apagar-Foto' >Tirar da Lista</i><input class='' type='checkbox'  name=fotoperfil  value=" + imagensSelect[i].name +
                    " id='' /> Slecionar para Perfil<div/>");
            }
            $("#listaInputFile").val(fileListArray);
    });

    // tirar da lista
     $('#file-Elemento').on("click", ".Apagar-Foto", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            fileListArray.splice($(this).attr('indiceremove'),1);

            //document.getElementById('listaInputFile').innerHTML=fileListArray;
          $("#listaInputFile").val(fileListArray);
            x--;
        });
    })




