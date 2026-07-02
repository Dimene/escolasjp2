"use strict";

$(document).ready(function () {
  $dados = "";
  $(".addElemtoableT").click(function (e) {
    e.preventDefault();

    if ($(".data_validade").val() == "") {
      $(".data_validade").css('border-color', 'red');
    } else if ($(".data_validade").val() != "") {
      $(".data_validade").css('border', '2px solid #dee2e6');
    }

    if ($(".nomeGenerico").val() == "") {
      $(".nomeGenerico").css('border-color', 'red');
    } else if ($(".nomeGenerico").val() != "") {
      $(".nomeGenerico").css('border', '2px solid #dee2e6');
    }

    if ($(".lote").val() == "") {
      $(".lote").css('border-color', 'red');
    } else if ($(".lote").val() != "") {
      $(".lote").css('border', '2px solid #dee2e6');
    }

    if ($(".Categoria").val() == "") {
      $(".Categoria").css('border-color', 'red');
    }

    if ($(".Categoria").val() == "") {
      $(".Categoria").css('border-color', 'red');
    } else if ($("[name='Categoria[]']").val() != "") {
      $("[name='Categoria[]']").css('border', '2px solid #dee2e6');
    }

    if ($("[name='nome[]']").val() == "") {
      $("[name='nome[]']").css('border-color', 'red');
    } else if ($("[name='Nome[]']").val() != "") {
      $("[name='Nome[]']").css('border', '2px solid #dee2e6');
    }

    if ($("[name='formulacao[]']").val() == "") {
      $("[name='formulacao[]']").css('border-color', 'red');
    } else if ($("[name='formulacao[]']").val() != "") {
      $("[name='formulacao[]']").css('border', '2px solid #dee2e6');
    }

    if ($("[name='Quantidade[]']").val() == "") {
      $("[name='Quantidade[]']").css('border-color', 'red');
    } else if ($("[name='Quantidade[]']").val() != "") {
      $("[name='Quantidade[]']").css('border', '2px solid #dee2e6');
    }

    if ($("[name='Preco_unitario[]']").val() == "") {
      $("[name='Preco_unitario[]']").css('border-color', 'red');
    } else if ($("[name='Preco_unitario[]']").val() != "") {
      $("[name='Preco_unitario[]']").css('border', '2px solid #dee2e6');
    }

    if ($("[name='Temperatura_Conservacao[]']").val() == "") {
      $("[name='Temperatura_Conservacao[]']").css('border-color', 'red');
    } else if ($("[name='Temperatura_Conservacao[]']").val() != "") {
      $("[name='Temperatura_Conservacao[]']").css('border', '2px solid #dee2e6');
    }

    if ($("[name='Concentracao[]']").val() == "") {
      $("[name='Concentracao[]']").css('border-color', 'red');
    } else if ($("[name='Concentracao[]']").val() != "") {
      $("[name='Concentracao[]']").css('border', '2px solid #dee2e6');
    }

    if ($("[name='preco_venda[]']").val() == "") {
      $("[name='preco_venda[]']").css('border-color', 'red');
    } else if ($("[name='preco_venda[]']").val() != "") {
      $("[name='preco_venda[]']").css('border', '2px solid #dee2e6');
    }

    if ($("[name='Concentracao[]']").val() != "" && $("[name='Categoria[]']").val() != "" && $("[name='Temperatura_Conservacao[]']").val() != "" && $("[name='Preco_unitario[]']").val() != "" && $("[name='Quantidade[]']").val() != "" && $("[name='formulacao[]']").val() != "" && $("[name='Nome[]']").val() != "" && $("[name='preco_venda[]']").val() != "" && $("[name='lote[]']").val() != "" && $("[name='nomeGenerico[]']").val() != "" && $("[name='data_validade[]']").val() != "") {
      adicionarElemento();
      $(".Temperatura_Conservacao").val("");
      $(".Categoria").val("");
      $(".Concentracao").val("");
      $(".Preco_unitario").val("");
      $(".Quantidade").val("");
      $(".formulacao").val("");
      $(".nome").val("");
      $(".preco_venda").val("");
      $(".data_validade").val("");
      $(".idmaster").val("");
      $(".lote").val("");
      $(".nomeGenerico").val("");
    }
  });
  $('.tabeladeElemetos').on('click', '.table-remove', function () {
    $(this).parents('td,tr').remove();
  });
});

function adicionarElemento() {
  $('#tr_de_novo_produtos').append('<tr><td>' + ' <input   name="idproduto[]"  class="form-control"  required value="' + $(".idmaster").val() + '" type="hidden"><input name="Categoria[]"  required class="form-control"  value="' + $("[name='Categoria[]']").val() + '" ></td>' + '<td><input name="nomeGenerico[]" required  class="form-control"   value="' + $("[name='nomeGenerico[]']").val() + '" /></td>' + '<td><input name="nome[]"  required class="form-control"  value="' + $("[name='nome[]']").val() + '" /></td>' + '<td><input name="lote[]" required class="form-control" value="' + $("[name='lote[]']").val() + '" /></td>' + '<td><input name="Quantidade[]" required  class="form-control"  value="' + $("[name='Quantidade[]']").val() + '"></td>' + '<td><input name="formulacao[]" required  class="form-control" value="' + $("[name='formulacao[]']").val() + '"></td>' + '<td><input name="Preco_unitario[]" required class="form-control"  value="' + $("[name='Preco_unitario[]']").val() + '"></td>' + '<td><input name="Temperatura_Conservacao[]" required  class="form-control"  value="' + $("[name='Temperatura_Conservacao[]']").val() + '"></td>' + '<td><input name="Concentracao[]" required class="form-control" value="' + $("[name='Concentracao[]']").val() + '"></td>' + '<td><input name="preco_venda[]" required  class="form-control"  value="' + $("[name='preco_venda[]']").val() + '"></td>' + '<td><input name="data_validade[]" required class="form-control"  type="Date" value="' + $("[name='data_validade[]']").val() + '"></td>' + '<td><button class="btn btn-danger" type="button" ><i class="fa fa-minus remove-element  table-remove">remover</i></button></td></tr>');
  $('.CategoriaColuna').find(".select2-selection__rendered").attr('title', "");
  $('.CategoriaColuna').find(".select2-selection__rendered").text("");
}