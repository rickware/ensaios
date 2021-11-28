var backend = "./backend/save.php";

$(document).on('click', '#btn-add', function (e) {
  var data =  serializa($("#add_form")[0]);
  $.ajax({
    data: data,
    type: "post",
    url: backend,
    success: function (dataResult) {
      var dataResult = JSON.parse(dataResult);
      if (dataResult.statusCode === 200) {
        $('#novoClienteModal').modal('hide');
        alert('Adicionado com sucesso!');
        location.reload();
      } else if (dataResult.statusCode === 201) {
        alert(dataResult);
      }
    }
  });
});

$(document).on('click', '.update', function (e) {
  var id = $(this).attr("data-id");
  var name = $(this).attr("data-nome");
  var email = $(this).attr("data-email");
  var phone = $(this).attr("data-celular");
  $('#id_u').val(id);
  $('#nome_u').val(name);
  $('#email_u').val(email);
  $('#celular_u').val(phone);
});

function serializa(form){
  if(!form||form.nodeName!=="FORM"){return;}
  var i,j,q=[];
  for(i=form.elements.length-1;i>=0;i=i-1){
    if(form.elements[i].name===""){continue}
    switch(form.elements[i].nodeName){
      case"INPUT":
        switch(form.elements[i].type){
          case"text":
          case"email":
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

$(document).on('click', '#btn-update', function (e) {
  var form = $("#update_form");
  var data =  serializa(form[0]);
  $.ajax({
    data: data,
    type: "POST",
    url: backend,
    success: function (dataResult) {
      var dataResult = JSON.parse(dataResult);
      if (dataResult.statusCode === 200) {
        $('#editaClienteModal').modal('hide');
        alert('Atualizado com sucesso!');
        location.reload();
      } else if (dataResult.statusCode === 201) {
        alert(dataResult);
      }
    }
  });
});
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
      tipo: 3,
      id: $("#id_d").val()
    },
    success: function (dataResult) {
      $('#excluiClienteModal').modal('hide');
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