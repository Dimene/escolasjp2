var tabela = $('#listadosalunos').DataTable({

    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": false,
    "autoWidth": true,
    "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
    ],
    language: {
        "lengthMenu": "visualizar _MENU_ ",
        "zeroRecords": "Nada foi encontado",
        "info": "mostrara pagina por pagina",
        "processing": "processando..",
        "infoEmpty": "Nada tem ",
        "infoFiltered": "(filtered from _MAX_ total records)",
        "loadingRecords": "processando...",
        "search": "",
        "searchPlaceholder": "Pesquisar...",
        "paginate": {
            "first": "primera",
            "last": "ultima",
            "next": "proxima",
            "previous": " Anterior"
        },
    },

});


// quando estiver abrindo apagima

$(document).ready(function () {


    $classes = $('[name="classes"]').val();
    $anolectivo = $('[name="anolectivo"]').val();

    buscarDisciplinas($classes, $anolectivo);
     buscarDirecao($classes, $anolectivo);
});




// q8uando selecionado classe ou disciploina

$(document).on('change', '.selectcontroler', function () {
    $classes = $('[name="classes"]').val();
    $anolectivo = $('[name="anolectivo"]').val();
    buscarDisciplinas($classes, $anolectivo);
     buscarDirecao($classes, $anolectivo);
});


$(document).on('change', '.direcao', function () {
    jQuery.noConflict();
    $("#exampleModal").modal("show");
    $("#labelmodal").text("Adicione Nova Disciplina");
    $(".disciplinanome").val(' ');
    $(".butaoAccoes").addClass("guardarnovadisp");
    $(".butaoAccoes").removeClass("atualizardisp");
    $(".guardarnovadisp").val("Guardar");
    $(".disciplinanome").attr('disabled', false);
    $(".butaoAccoes").addClass("btn-primary");
    $(".butaoAccoes").removeClass("btn-danger")
    $(".butaoAccoes").removeClass("apagardisp");
    $(".disciplinanome").removeAttr('iddisp')


});



$(document).on('click', '.addnewdisciplina', function () {
    jQuery.noConflict();
    $("#exampleModal").modal("show");
    $("#labelmodal").text("Adicione Nova Disciplina");
    $(".disciplinanome").val(' ');
    $(".butaoAccoes").addClass("guardarnovadisp");
    $(".butaoAccoes").removeClass("atualizardisp");
    $(".guardarnovadisp").val("Guardar");
    $(".disciplinanome").attr('disabled', false);
    $(".butaoAccoes").addClass("btn-primary");
    $(".butaoAccoes").removeClass("btn-danger")
    $(".butaoAccoes").removeClass("apagardisp");
    $(".disciplinanome").removeAttr('iddisp')


});







$(document).on('click', '.editnomeDisciplina', function () {
    jQuery.noConflict();
    $("#disciplinanome").val($(this).attr('nomedisciplina'));
    $("#disciplinanome").attr('iddisp', $(this).attr('iddesp'));
    $("#disciplinSigla").val($(this).attr('sigla'));
    $("#disciplinanome").attr('disabled', false);

    $(".butaoAccoes").addClass("btn-primary");
    $(".butaoAccoes").removeClass("btn-danger");
    $(".butaoAccoes").val("Atualizar");
    $(".butaoAccoes").removeClass("guardarnovadisp");
    $(".butaoAccoes").addClass("atualizardisp");
    $(".butaoAccoes").removeClass("apagardisp");
    $(".butaoAccoes").val("Atualizar");

   // console.log($(this).attr('nomedisciplina'),$(this).attr('sigla'));
   let tipo = $(this).attr("tipodisciplina");
$("#tipoDesciplina option[value='" + tipo + "']").prop("selected", true);
$("#tipoDesciplina").prop("disabled", false);

    $("#labelmodal").text("Atualizar Nome da Disciplina");
      $("#exampleModal").modal("show");

})





$(document).on('click', '.apagardisplina', function () {
    jQuery.noConflict();
    $("#exampleModal").modal("show");
    $("#labelmodal").text("pretendes Apagar a disciplina de :");
    $(".disciplinanome").val($(this).attr('nomedisciplina'));
    $(".disciplinanome").attr('disabled', true);
    $(".disciplinanome").attr('iddisp', $(this).attr('iddesp'));

    $(".butaoAccoes").val("apagar");
    $(".butaoAccoes").removeClass("guardarnovadisp");
    $(".butaoAccoes").removeClass("btn-primary");
    $(".butaoAccoes").addClass("apagardisp");
    $(".butaoAccoes").addClass("btn-danger");
    $(".butaoAccoes").val("apagar");
})




$(document).on('click', '.guardarnovadisp', function () {
    jQuery.noConflict();

    const nomeDisciplina = $(".disciplinanome").val().trim();
    const siglaDisciplina = $(".disciplinSigla").val().trim();
    const classes = $('[name="classes"]').val();
    const anoLectivo = $('[name="anolectivo"]').val();
    const token = $('[name="_token"]').val();
   buscarDirecao(classes, anoLectivo);
    // Resetar estilos de erro
    $(".disciplinanome, .disciplinSigla").css("border-color", "");

    // Validação
    if (nomeDisciplina === "") {
        $(".disciplinanome").css("border-color", "#F90505").focus();
        return;
    }

    if (siglaDisciplina === "") {
        $(".disciplinSigla").css("border-color", "#F90505").focus();
        return;
    }
alert();
    // Chamada AJAX
    $.ajax({
        url: `/RegistoAcademico/notas/disciplinas/guardar/novas/${encodeURIComponent(nomeDisciplina)}/${encodeURIComponent(anoLectivo)}`,
        type: 'GET',
        dataType: 'json',
        data: {
            novadisp: nomeDisciplina,
            sigla: siglaDisciplina,
            classes: classes,
            anolectivo: anoLectivo,
            _token: token
        },
        success: function (data) {
            if (data.alert === "success") {
                $("#exampleModal").modal("hide");
                buscarDisciplinas(classes, anoLectivo);
                $(".disciplinanome, .disciplinSigla").val('');
            } else {
                alert("Erro ao guardar disciplina. Tente novamente.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Erro AJAX:", error);
            alert("Falha na comunicação com o servidor.");
        }
    });
});



$(document).on('click', '.atualizardisp', function () {
    jQuery.noConflict();

    const nomeDisciplina = $(".disciplinanome").val().trim();
    const siglaDisciplina = $(".disciplinSigla").val().trim();
    const classes = $('[name="classes"]').val();
    const anoLectivo = $('[name="anolectivo"]').val();
    const token = $('[name="_token"]').val();

    // Resetar estilos de erro
    $(".disciplinanome, .disciplinSigla").css("border-color", "");

    // Validação
    if (nomeDisciplina === "") {
        $(".disciplinanome").css("border-color", "#F90505").focus();
        return;
    }

    if (siglaDisciplina === "") {
        $(".disciplinSigla").css("border-color", "#F90505").focus();
        return;
    }

    // Chamada AJAX
    $.ajax({
        url: `/RegistoAcademico/notas/disciplinas/guardar/novas/${encodeURIComponent(nomeDisciplina)}/${encodeURIComponent(anoLectivo)}`,
        type: 'GET',
        dataType: 'json',
        data: {
            novadisp: nomeDisciplina,
            sigla: siglaDisciplina,
            classes: classes,
            anolectivo: anoLectivo,
            _token: token
        },
        success: function (data) {
            if (data.alert === "success") {
                $("#exampleModal").modal("hide");
                buscarDisciplinas(classes, anoLectivo);
                $(".disciplinanome, .disciplinSigla").val('');
            } else {
                alert("Erro ao guardar disciplina. Tente novamente.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Erro AJAX:", error);
            alert("Falha na comunicação com o servidor.");
        }
    });
});






// $(document).on('click', '.atualizardisp', function () {
//     jQuery.noConflict();

//      // console.log($(".disciplinanome").val());

//      if ($(".disciplinanome").val() == "") {
//          $(".disciplinanome").css("border-color", "#F90505");
//      } else {         $classes = $('[name="classes"]').val();
//   $anolectivo = $('[name="anolectivo"]').val();

//          $.ajax({
//              url: '/RegistoAcademico/notas/disciplinas/edit/novas/' + $classes + '/' +
//                  $anolectivo,
//             type: 'GET',
//              dataType: 'json',
//              data: {
//                  'novadisp': $(".disciplinanome").val(),
//                  'id': $(".disciplinanome").attr('iddisp'),
//                  '_token': $('[name="_token"]').val(),

//             },

//              success: function (data) {
//                  if (data.alert === "success") {

//                     $("#exampleModal").modal("hide");
//                      buscarDisciplinas($classes, $anolectivo);
//                      $(".disciplinanome").val('');
//                  }

//              }
//          });

//      }

//  })




// adicionar as disciplinas nova a classe
$(document).on('click', '.atualizar-btn-disp-lista', function () {
    jQuery.noConflict();

    // console.log($(".disciplinanome").val());
    const classes = $('[name="classes"]').val();
    const anoLectivo = $('[name="anolectivo"]').val();
GuadarbuscarDirecao(classes,anoLectivo);

    $.ajax({
        url: '/RegistoAcademico/notas/disciplinas/atualizardisplinas/novas/' + $classes + '/' +
            $anolectivo,
        type: 'POST',
        dataType: 'json',
        data: $('.formdata').serialize(),

        success: function (data) {
            if (data.alert == "") {
                $(".alertmash").show();
                $(".alertmash").addClass("alert-success");
                $(".mensagem").text("Guardado com sucesso");
                $(".alertmash").hide("slow");
            }
            else {
                $(".alertmash").show();
                $(".alertmash").addClass("alert-success");
                $html = "";
                data.forEach(function (e) { $html = "," + e + $html; });
                $(".mensagem").text("A Disciplinas de " + $html + "");
                $(".alertmash").hide("slow");

            }



        }
    });



})






$(document).on('click', '.apagardisp', function () {
    jQuery.noConflict();

    // console.log($(".disciplinanome").val());


    if ($(".disciplinanome").val() == "") {
        $(".disciplinanome").css("border-color", "#F90505");
    } else {
        $classes = $('[name="classes"]').val();
        $anolectivo = $('[name="anolectivo"]').val();



        $.ajax({
            url: '/RegistoAcademico/notas/disciplinas/delete/novas/' + $(".disciplinanome").attr(
                'iddisp') + '',
            type: 'GET',
            dataType: 'json',

            success: function (data) {
                if (data.alert === "success") {

                    $("#exampleModal").modal("hide");
                    buscarDisciplinas($classes, $anolectivo);
                    $(".disciplinanome").val('');
                } else if (data.alert === "arror") {

                    // $("#exampleModal").modal("hide");
                    //buscarDisciplinas($classes, $anolectivo);
                    // $(".disciplinanome").val('');
                    $("#labelmodal").html(
                        "<span class='alert alert-warning'> <i class='fa fa-fg fa-warning'></i>Nao e possivel apagar a disciplina:</span>"
                    );
                }

            }
        });

    }

})





function buscarDisciplinas($classes, $anolectivo) {

    $.ajax({
        url: '/RegistoAcademico/notas/config/disciplinas/' + $classes + '/' + $anolectivo,
        type: 'get',
        dataType: 'json',
        success: function (data) {

            var $html = '<ul class="list-group">';
            tabela.rows().remove().draw(false);

            data.naolecionadas.forEach(function (e) {
                //$html=$html+' <li class="list-group-item">'+e.Descricao+'</li>';

                // console.log(e);
            let letratipo = e.tipodisciplina.Descricao.charAt(0);
let nomediscipl = `${e.Descricao}(${letratipo})`;

                tabela.row.add([nomediscipl,
                '<span class="badge badge-primary float-rigth editnomeDisciplina"      Sigla="'+e.Sigla+'" nomedisciplina="' +
                e.disciplinas +

                '"iddesp="' + e.id +
                '" tipoDisciplina="'+e.tipodisciplina.Descricao.id+'"><i class="fa fa-lg fa-edit  "   aria-hidden= "true">' +
                '</i></span>&nbsp;<span class="badge badge-danger float-rigth apagardisplina"  nomedisciplina="' +
                e.Descricao +
                '"iddesp="' + e.id +
                '" ><i class=" fa fa-lg fa-trash  "  aria-hidden= "true"></i></span>' +
                '&nbsp;<span class="badge badge-primary addnogrupo float-rigth"  nomedisciplina="' +
                e.Descricao +
                '"iddesp="' + e.id +
                '"  tipoDisciplina="'+e.tipodisciplina.Descricao.id+'" ><i class=" fa fa-lg fa-caret-right  "  aria-hidden= "true"></i></span>'
                ]).draw(true);

            });

            $html = $html + '</ul>';
            //  $(".disciplinasporadd").html($html);




            var $html = '<ul class="list-group">';


            data.lecionadas.forEach(function (e) {
                $html = $html +
                    ' <li class="list-group-item"><input type="hidden" value="' + e.disciplina_id + '" name="dispnovasAdd[]"><span class="badge badge-primary removedalistadisp-lecionadas float-rigth"  nomedisciplina="' +
                    e.disciplinas +
                    '"iddesp="' + e.id +
                    '" ><i class=" fa fa-lg fa-caret-left  "  aria-hidden= "true"></i></span>' +
                    e.disciplinas +
                    '</li>';
            });
            $html = $html +
                '</ul><div class="row"><div class="col-md-10"></div><div class="btnadd col float-rigth" ></div></div>';
            $(".disciplinasadd").html($html);

        }


    })





}




$(document).on('click', '.addnogrupo', function () {
    tabela.row($(this).parents('tr')).remove().draw(false);


    $html =
        ' <li class="list-group-item"><input type="hidden" value="' + $(this).attr('iddesp') + '" name="dispnovasAdd[]"><span class="badge badge-primary removedalistadisp-lecionadas float-rigth"  nomedisciplina="' +
        $(this).attr('nomedisciplina') +
        '"iddesp="' + $(this).attr('iddesp') +
        '" ><i class=" fa fa-lg fa-caret-left  "  aria-hidden= "true"></i></span>' +
        $(this).attr('nomedisciplina') +
        '</li>';

    $htm = '<button class="btn btn-primary atualizar-btn-disp-lista float-rigth" type="button" >Atualizar</button>';
    if ($('.atualizar-btn-disp-lista').text() != "Atualizar") {
        $(".btnadd").html($htm);
    }


    $(".list-group").append($html);



});


function GuadarbuscarDirecao($classes, $anolectivo) {

const formData = {
        director_id: $('#diretor_id').val(),
        pedagogico_id: $('#diretor_adjunto_id').val()
    };

    $.ajax({
        url: '/RegistoAcademico/notas/config/direcao/classe/' + $classes + '/' + $anolectivo,
        type: 'get',
        dataType: 'json',
        data:formData,
        success: function (data) {
             // Atualiza o campo de diretor com base no valor retornado
    $('#diretor_id')
        .val(data.director_id)      // define o valor
        .trigger('change');         // dispara o evento change (caso tenha dependências)
console.log(data)
    // Se quiser também atualizar o campo de diretor adjunto:
    $('#diretor_adjunto_id')
        .val(data.pedagogico_id || '') // se existir no retorno
        .trigger('change');



        }
    }
    );
}

function buscarDirecao($classes, $anolectivo) {

const formData = {
        director_id: $('#diretor_id').val(),
        pedagogico_id: $('#diretor_adjunto_id').val()
    };

    $.ajax({
        url: '/RegistoAcademico/notas/config/direcao/selecionar/classe/' + $classes + '/' + $anolectivo,
        type: 'get',
        dataType: 'json',
        success: function (data) {
             // Atualiza o campo de diretor com base no valor retornado
    $('#diretor_id')
        .val(data.director_id)      // define o valor
        .trigger('change');         // dispara o evento change (caso tenha dependências)
console.log(data)
    // Se quiser também atualizar o campo de diretor adjunto:
    $('#diretor_adjunto_id')
        .val(data.pedagogico_id || '') // se existir no retorno
        .trigger('change');



        }
    }
    );
}


$(document).on('click', '.removedalistadisp-lecionadas', function () {
    $(this).parents('li').remove();
    $htm = '<button class="btn btn-primary atualizar-btn-disp-lista float-rigth" type="button" >Atualizar</button>';
    if ($('.atualizar-btn-disp-lista').text() != "Atualizar") {
        $(".btnadd").html($htm);
    }


    tabela.row.add([$(this).attr('nomedisciplina'),
    '<span class="badge badge-primary float-rigth editnomeDisciplina" nomedisciplina="' +
    $(this).attr('nomedisciplina') +
    '"iddesp="' + $(this).attr('iddesp') +
    '" ><i class="fa fa-lg fa-edit  "   aria-hidden= "true">' +
    '</i></span>&nbsp;<span class="badge badge-danger float-rigth apagardisplina"  nomedisciplina="' +
    $(this).attr('nomedisciplina') +
    '"iddesp="' + $(this).attr('iddesp') +
    '" ><i class=" fa fa-lg fa-trash  "  aria-hidden= "true"></i></span>' +
    '&nbsp;<span class="badge badge-primary addnogrupo float-rigth"  nomedisciplina="' +
    $(this).attr('nomedisciplina') +
    '"iddesp="' + $(this).attr('iddesp') +
    '"  ><i class=" fa fa-lg fa-caret-right  "  aria-hidden= "true"></i></span>'
    ]).draw(true);
});



