<?php
ob_start();
require './backend/database.php';
fb('start', FIREPHP::INFO);

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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projeto 1 - CRUD Produtos</title>
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
              <h2>CRUD <b>Produtos</b></h2>
            </div>
            <div><a href="../index.php" target="_self" title="RETORNAR">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/>
                </svg>
              </a></div>
            <div class="col-sm-6">
              <a href="#novoProdutoModal" class="btn btn-success" data-toggle="modal">
                <i class="material-icons"></i> <span>Novo Produto</span>
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
$result = mysqli_query($conn, 'SELECT * FROM rbmweb.produtos ORDER BY categoria, nome;');
//fb(totable($result) ,'result', FirePHP::TABLE);
$i = 1;
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
  $i++;
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

  </body>
</html>


