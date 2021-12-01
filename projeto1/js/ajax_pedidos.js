var backend = "./backend/controller.php";

$(document).on('click', '#btn-novo', function (e) {
  $('#nome').val($("#selcli option:selected").text());
  $('#idcliente').val($("#selcli option:selected").val());
});

$(document).on('click', '#btn-add', function (e) {
  var data =  serializa($("#add_form")[0]);
  $.ajax({
    data: data,
    type: "post",
    url: backend,
    success: function (dataResult) {
      var dataResult = JSON.parse(dataResult);
      if (dataResult.statusCode === 200) {
        var idPedido = dataResult.id;
        $('#novoPedidoModal').modal('hide');
        alert('Pedido Aberto, preencha os detalhes');
        location.href ='./crud_detalhes.php?idcliente='+$("#selcli option:selected").val()+'&idpedido=0&idpedido='+idPedido;
      } else if (dataResult.statusCode === 201) {
        alert(dataResult);
      }
    }
  });
});

$(document).on('click', '.update', function (e) {
  var id = $(this).attr("data-id");
  var cat = $(this).attr("data-categoria");
  var nome = $(this).attr("data-nome");
  var unidade = $(this).attr("data-unidade");
  var preco = $(this).attr("data-preco");
  var valor = $(this).attr("data-valor");
  $('#id_u').val(id);
  $('#categoria_u').val(cat);
  $('#nome_u').val(nome);
  $('#unidade_u').val(unidade);
  $('#preco_u').val(preco);
  $('#valor_u').val(valor);
});

function carregadadosCliente() {
	id_cliente = $("#selcli option:selected").val();
	var request = './backend/controller.php?acao=carregapedidoscliente&idcliente=' + id_cliente;
	$('#tabelaPedidos > tbody').empty();
    
	const xhttp = new XMLHttpRequest();
    
	xhttp.onload = function () {
		var result = JSON.parse(this.responseText);
		if (result.length > 0) {
			for (i = 0, len = result.length; i < len; i++) {
              var id = result[i][0];
              var acaoCell = '<a href="crud_detalhes.php?idpedido='+id+'&idcliente=' + id_cliente +'" class="edit">'+
                        '<i class="material-icons update" data-toggle="tooltip" title="Editar"></i></a>'+
                        '<a href="#excluiPedidoModal" class="delete" data-id="'+id+'" data-toggle="modal">'+
                        '<i class="material-icons" data-toggle="tooltip" title="Excluir"></i></a>';

              var linha = '<tr><td>'+result[i][0]+'</td><td>'+result[i][1]+'</td><td>'+result[i][2]+'</td><td>'+acaoCell+'</td></tr>';

              $('#tabelaPedidos > tbody').append(linha);
			}
		}
	};
	xhttp.open("GET", request, true);
	xhttp.send();
};

function serializa(form){
  if(!form||form.nodeName!=="FORM"){return;}
  var i,j,q=[];
  for(i=form.elements.length-1;i>=0;i=i-1){
    if(form.elements[i].name===""){continue}
    switch(form.elements[i].nodeName){
      case"INPUT":
        switch(form.elements[i].type){
          case"text":
          case"unidade":
          case"hidden":
          case"password":
          case"button":
          case"reset":
          case"submit":
            q.push(form.elements[i].name+"="+encodeURIComponent(form.elements[i].value));
            break;
          case"checkbox":
          case"radio":
            if(form.elements[i].checked){
              q.push(form.elements[i].name+"="+encodeURIComponent(form.elements[i].value));
            }
            break;
          case"file":
            break
        }
        break;
      case"TEXTAREA":
        q.push(form.elements[i].name+"="+encodeURIComponent(form.elements[i].value));
        break;
      case"SELECT":
        switch(form.elements[i].type){
          case"select-one":q.push(form.elements[i].name+"="+encodeURIComponent(form.elements[i].value));
            break;
          case"select-multiple":
            for(j=form.elements[i].options.length-1;j>=0;j=j-1){
              if(form.elements[i].options[j].selected){
                q.push(form.elements[i].name+"="+encodeURIComponent(form.elements[i].options[j].value));
              }
            }
            break
        }
        break;
      case"BUTTON":
        switch(form.elements[i].type){
          case"reset":
          case"submit":
          case"button":
            q.push(form.elements[i].name+"="+encodeURIComponent(form.elements[i].value));
            break
        }
        break
    }
  }
  return q.join("&");
};

$(document).on("click", ".delete", function () {
  var id = $(this).attr("data-id");
  $('#id_d').val(id);

});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: backend,
    type: "POST",
    cache: false,
    data: {
      crud: 'produto',
      tipo: 3,
      id: $("#id_d").val()
    },
    success: function (dataResult) {
      $('#excluiPedidoModal').modal('hide');
      $("#" + dataResult).remove();

    }
  });
});

$(document).on("click", "#delete_multiple", function () {
  var user = [];
  $(".cliente_checkbox:checked").each(function () {
    user.push($(this).data('user-id'));
  });
  if (user.length <= 0) {
    alert("Selecione algum.");
  } else {
    WRN_PROFILE_DELETE = "Está certo que deseja eliminar estes registros? ";
    var checked = confirm(WRN_PROFILE_DELETE);
    if (checked === true) {
      var selected_values = user.join(",");
      console.log(selected_values);
      $.ajax({
        type: "POST",
        url: backend,
        cache: false,
        data: {
          crud: 'produto',
          tipo: 4,
          id: selected_values
        },
        success: function (response) {
          var ids = response.split(",");
          for (var i = 0; i < ids.length; i++) {
            $("#" + ids[i]).remove();
          }
        }
      });
    }
  }
});

$(document).ready(function () {
  carregadadosCliente();
  
  $('[data-toggle="tooltip"]').tooltip();
  var checkbox = $('table tbody input[type="checkbox"]');
  
  $("#selectAll").click(function () {
    if (this.checked) {
      checkbox.each(function () {
        this.checked = true;
      });
    } else {
      checkbox.each(function () {
        this.checked = false;
      });
    }
  });
  checkbox.click(function () {
    if (!this.checked) {
      $("#selectAll").prop("checked", false);
    }
  });
});