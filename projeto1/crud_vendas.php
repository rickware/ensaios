<?php
ob_start();
require './backend/database.php';
fb('start', FIREPHP::INFO);

function monta_select_cliente ($link){
  $resultcli = mysqli_query($link, "select id, nome from clientes");
  $resposta  = '<select name="selcli" id="selcli" class="form-control" onchange="carregar()">';
  while ($row = mysqli_fetch_assoc($resultcli)){
    $resposta .= '<option value="'.$row["id"].'">'.$row["nome"].'</option>';
  }
  $resposta .='</select>';
  return $resposta;
}

$select_categoria = '
<select name="categoria" id="categoria" class="form-control" required>
  <option value="Bebidas">Bebidas</option>
  <option value="Cereais">Cereais</option>
  <option value="Condimentos">Condimentos</option>
  <option value="Conservas">Conservas</option>
  <option value="Doces">Doces</option>
  <option value="Enlatados Carne">Enlatados Carne</option>
  <option value="Enlatados Frutas">Enlatados Frutas</option>
  <option value="Grao">Grao</option>
  <option value="Lanches">Lanches</option>
  <option value="Laticinios">Latic&iacute;nios</option>
  <option value="Massas">Massas</option>
  <option value="Molhos">Molhos</option>
  <option value="Oleos">Oleos</option>
  <option value="Padaria">Padaria</option>
  <option value="Sopas">Sopas</option>
  <option value="Variados">Variados</option>
</select>
';

$select_cliente = monta_select_cliente ($conn);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projeto 1 - CRUD VENDAS</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="./js/ajax.js"></script>
  </head>
  <body>
    <div class="container">
      <p id="success"></p>
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h5 style="text-align: right;">Selecione o Cliente &Rightarrow;</h5>
              <h2>CRUD <b>PEDIDOS</b></h2>
            </div>
            <div class="col-sm-6">
              <form id="seleciona_cliente" style="margin-bottom: 5px;">
                <?php echo $select_cliente; ?>
              </form>
              <a href="../index.php" target="_self" title="RETORNAR">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/>
                </svg>
              </a>
              <a href="#novoProdutoModal" class="btn btn-success" data-toggle="modal">
                <i class="material-icons"></i> <span>Novo Pedido</span>
              </a>
              <a href="JavaScript:void(0);" class="btn btn-danger" id="delete_multiple">
                <i class="material-icons"></i> <span>Remover</span>
              </a>
            </div>
          </div>
        </div>

        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>
                <span class="custom-checkbox">
                  <input type="checkbox" id="selectAll">
                  <label for="selectAll"></label>
                </span>
              </th>
              <th>ID</th>
              <th>CATEGORIA</th>
              <th>NOME</th>
              <th>UNIDADE</th>
              <th>PRE&Ccedil;O</th>
              <th>ESTOQUE</th>
              <th>AÇÃO</th>
            </tr>
          </thead>
          <tbody>

<?php
$result = mysqli_query($conn, 'SELECT * FROM rbmweb.pedidos ORDER BY categoria, nome;');
//fb(totable($result) ,'result', FirePHP::TABLE);

while ($row = mysqli_fetch_assoc($result)) {
  //fb($row, FirePHP::DUMP);
  ?>
              <tr id="<?php echo $row["id"]; ?>">
                <td>
                  <span class="custom-checkbox">
                    <input type="checkbox" class="cliente_checkbox" data-user-id="<?php echo $row["id"]; ?>">
                    <label for="checkbox2"></label>
                  </span>
                </td>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["categoria"]; ?></td>
                <td><?php echo $row["nome"]; ?></td>
                <td><?php echo $row["unidade"]; ?></td>
                <td><?php echo $row["preco"]; ?></td>
                <td><?php echo $row["estoque"]; ?></td>
                <td>
                  <a href="#editaProdutoModal" class="edit" data-toggle="modal">
                    <i class="material-icons update" data-toggle="tooltip"
                       data-id="<?php echo $row["id"]; ?>"
                       data-categoria="<?php echo $row["categoria"]; ?>"
                       data-nome="<?php echo $row["nome"]; ?>"
                       data-unidade="<?php echo $row["unidade"]; ?>"
                       data-preco="<?php echo $row["preco"]; ?>"
                       data-estoque="<?php echo $row["estoque"]; ?>"
                       title="Editar"></i>
                  </a>
                  <a href="#excluiProdutoModal" class="delete" data-id="<?php echo $row["id"]; ?>" data-toggle="modal">
                    <i class="material-icons" data-toggle="tooltip" title="Excluir"></i>
                  </a>
                </td>
              </tr>
  <?php
}
?>
          </tbody>
        </table>

      </div>
    </div>

    <!-- Modal Novo HTML -->
    <div id="novoProdutoModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="add_form">
            <div class="modal-header">
              <h4 class="modal-title">Adicionar Produto</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>CATEGORIA:</label>
								<?php echo $select_categoria; ?>
              </div>
              <div class="form-group">
                <label>NOME:</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
              </div>
              <div class="form-group">
                <label>UNIDADE:</label>
                <input type="text" id="unidade" name="unidade" class="form-control" required>
              </div>
              <div class="form-group">
                <label>PRE&Ccedil;O:</label>
                <input type="text" id="preco" name="preco" class="form-control" required>
              </div>
              <div class="form-group">
                <label>ESTOQUE:</label>
                <input type="text" id="estoque" name="estoque" class="form-control" required>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" value="1" name="tipo">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-success" id="btn-add">INSERIR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Edita HTML -->
    <div id="editaProdutoModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Editar dados do Produto</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <form id="update_form">
            <div class="modal-body">
              <input type="hidden" id="id_u" name="id" class="form-control" required>
              <div class="form-group">
                <label>Categoria:</label>
                <?php echo $select_categoria; ?>
              </div>
              <div class="form-group">
                <label>Nome:</label>
                <input type="text" id="nome_u" name="nome" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Unidade:</label>
                <input type="text" id="unidade_u" name="unidade" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Pre&ccedil;o:</label>
                <input type="text" id="preco_u" name="preco" class="form-control" required>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" value="2" name="tipo">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-info" id="btn-update">ATUALIZAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Exclui HTML -->
    <div id="excluiProdutoModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="delete_form">
            <div class="modal-header">
              <h4 class="modal-title">Excluir Produto</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id_d" name="id" class="form-control">
              <p>Está certo que deseja continuar?</p>
              <p class="text-warning"><small>ESTA AÇÃO NÃO PODE SER DESFEITA.</small></p>
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-danger" id="delete">EXCLUIR</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- nice -->
    <section class="u-clearfix u-section-1" id="sec-d5f2">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-clearfix u-expanded-width u-gutter-0 u-layout-wrap u-layout-wrap-1">
          <div class="u-layout" style="">
            <div class="u-layout-row" style="">
              <div class="u-align-left u-container-style u-layout-cell u-size-38 u-layout-cell-1">
                <div class="u-container-layout u-container-layout-1">
                  <div class="u-form u-form-1">
                    <form action="#" method="POST" class="u-clearfix u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="form" style="padding: 10px;">
                      <input type="hidden" id="siteId" name="siteId" value="1152421542">
                      <input type="hidden" id="pageId" name="pageId" value="10243587">
                      <div class="u-form-group u-form-select u-form-group-1">
                        <label for="select-48d9" class="u-form-control-hidden u-label u-label-1"></label>
                        <div class="u-form-select-wrapper">
                          <select id="select-48d9" name="seleccategoria" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                            <option value="categoria1">categoria1</option>
                            <option value="categoria2">categoria2</option>
                            <option value="categoria3">categoria3</option>
                          </select>
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
                        </div>
                      </div>
                      <div class="u-form-group u-form-select u-form-group-2">
                        <label for="select-21ee" class="u-form-control-hidden u-label"></label>
                        <div class="u-form-select-wrapper">
                          <select id="select-21ee" name="selectproduto" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                            <option value="Item 1">Item 1</option>
                            <option value="Item 2">Item 2</option>
                            <option value="Item 3">Item 3</option>
                          </select>
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
                        </div>
                      </div>
                      <div class="u-form-group u-form-group-3">
                        <label for="text-cba5" class="u-form-control-hidden u-label"></label>
                        <input type="text" placeholder="Quantidade" id="text-cba5" name="text" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                      </div>
                      <div class="u-align-left u-form-group u-form-submit">
                        <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                        <input type="submit" value="submit" class="u-form-control-hidden">
                      </div>
                      <div class="u-form-send-message u-form-send-success"> Thank you! Your message has been sent. </div>
                      <div class="u-form-send-error u-form-send-message"> Unable to send your message. Please fix errors then try again. </div>
                      <input type="hidden" value="" name="recaptchaResponse">
                    </form>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="u-clearfix u-section-2" id="sec-057c">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-table u-table-responsive u-table-1">
          <table class="u-table-entity">
            <colgroup>
              <col width="38.7%">
              <col width="14.3%">
              <col width="13.2%">
              <col width="13.8%">
              <col width="20%">
            </colgroup>
            <thead class="u-palette-1-light-2 u-table-header u-table-header-1">
              <tr style="height: 50px;">
                <th class="u-border-1 u-border-grey-dark-1 u-table-cell">PRODUTO</th>
                <th class="u-border-1 u-border-grey-dark-1 u-table-cell">QUANTIDADE</th>
                <th class="u-border-1 u-border-grey-dark-1 u-table-cell">VALOR</th>
                <th class="u-border-1 u-border-grey-dark-1 u-table-cell">SUB-TOTAL</th>
                <th class="u-border-1 u-border-grey-dark-1 u-table-cell">ACAO</th>
              </tr>
            </thead>
            <tbody class="u-table-body">
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">AGUA</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">3</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">5,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">50,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">EDITAR&nbsp; &nbsp;REMOVER</td>
              </tr>
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">FEIJAO</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">2</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">5,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">10,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell"></td>
              </tr>
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">ARROZ</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">1</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">10,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">10,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell"></td>
              </tr>
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">BOLO</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">2</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">15.00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">30,00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell"></td>
              </tr>
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">SAL</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">1</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">8.00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell">8.00</td>
                <td class="u-border-1 u-border-grey-dark-1 u-table-cell"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
    <script>
      function carregar() {
        var id_cliente = $("#selcli option:selected").val();
        var planeta = $('#planeta option:selected').val();
        var request = './' + planeta;

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
          var dataResult = JSON.parse(this.responseText);
          $("#nome").text(dataResult.name);
          $("#dia").text(dataResult.rotation_period+" horas");
          $("#ano").text(dataResult.orbital_period+" dias");
          $("#diametro").text(dataResult.diameter+ " Km");
          $("#clima").text(dataResult.climate);
          $("#gravidade").text(dataResult.gravity);
        };
        xhttp.open("GET", request, true);
        xhttp.send();
      }

      ;
    </script>

  </body>
</html>


