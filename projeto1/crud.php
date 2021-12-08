<?php
ob_start();
FILTER_NULL_ON_FAILURE;
$crud=filter_input(INPUT_GET, 'crud', FILTER_SANITIZE_STRING);

if (!$crud){  die('parametro de entrada necessario -> crud');}

$order=filter_input(INPUT_GET, 'order', FILTER_SANITIZE_STRING);

$Ucrud=ucwords($crud);
require './backend/config.php';

if ($debug) {fb('start', FIREPHP::INFO);}

if ($debug) {fb($titulocampos, '$titulocampos', FIREPHP::INFO);}
if ($debug) {fb($tipocampos, '$tipocampos', FIREPHP::INFO);}
?>
<!DOCTYPE html>
<html lang="en">
<?php include './backend/crud_head.html'; ?>

  <body>
    <div class="container">
      <p id="success"></p>
      <div class="table-wrapper">
        <?php include './backend/crud_title.php'; ?>

        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>
                  <span class="custom-checkbox">
                    <input type="checkbox" id="selectAll">
                    <label for="selectAll"></label>
                  </span>
                </th>
                <th>A&Ccedil;&Atilde;O</th>
              <?php
              for ($x=0; $x<= count($titulocampos); $x++) {  // monta o cabecario
                if ($x > 0) {echo '<th>'.$titulocampos[$x].'</th>';} // ignora a coluna 0 - ID
              }
              ?>
              </tr>
            </thead>
            <tbody>

<?php
//if($debug){fb(totable($result) ,'result', FirePHP::TABLE);
while ($row=mysqli_fetch_array($result, MYSQLI_BOTH)) {
  //if($debug){fb($row, FirePHP::DUMP)};
  ?>
                <tr id="<?php echo $row['id']; ?>">
                  <td>
                    <span class="custom-checkbox">
                      <input type="checkbox" class="left_checkbox" data-left-id="<?php echo $row['id']; ?>">
                      <label for="checkbox2"></label>
                    </span>
                  </td>
                  <td>
                    <a href="#editaModal" class="edit" data-toggle="modal">
                      <i class="material-icons update" data-toggle="tooltip" title="Editar" <?php for ($x=0; $x < count($titulocampos); $x++) {
                         echo ' data-'.$titulocampos[$x].'= "'.$row[$x].'" ';
                       } ?>></i>
                    </a>
                    <a href="#excluiModal" class="delete" data-id="<?php echo $row['id']; ?>" data-toggle="modal">
                      <i class="material-icons" data-toggle="tooltip" title="Excluir"></i>
                    </a>
                  </td>
                  <?php
                  foreach ($fieldinfo as $val) {
                    $col=$val->name;
                    if ($col!= $idt) {
                      echo '<td>'.$row[$col].'</td>';
                    } // ignora a coluna ID na tabela
                  }
                  ?>
                </tr>
  <?php
}
?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal Novo HTML -->
    <div id="novoModal" class="modal fade">
      <div class="modal-dialog">.
        <div class="modal-content">
          <form id="add_form">
            <div class="modal-header">
              <h4 class="modal-title">Adicionar <?php echo $Ucrud ?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <?php echo monta_campos_form('a',$titulocampos, $tipocampos); ?>
            </div>
            <div class="modal-footer">
              <input type="hidden" value="<?php echo $crud ?>" name="crud">
              <input type="hidden" value="1" name="tipo">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-success" id="btn-add">INSERIR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Edita HTML -->
    <div id="editaModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Editar dados: <?php echo $Ucrud ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <form id="update_form">
            <div class="modal-body">
              <?php echo monta_campos_form('u',$titulocampos, $tipocampos); ?>
            </div>
            <div class="modal-footer">
              <input type="hidden" value="<?php echo $crud ?>" name="crud">
              <input type="hidden" value="" name="id" id="id_u">
              <input type="hidden" value="2" name="tipo">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-info" id="btn-update">ATUALIZAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Exclui HTML -->
    <div id="excluiModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="delete_form">
            <div class="modal-header">
              <h4 class="modal-title">Excluir <?php echo $Ucrud ?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id_d" name="id" class="form-control">
              <p>Está certo que deseja continuar?</p>
              <p class="text-warning"><small>ESTA AÇÃO NÃO PODE SER DESFEITA.</small></p>
            </div>
            <div class="modal-footer">
              <input type="hidden" value="<?php echo $crud ?>" name="crud">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-danger" id="delete">EXCLUIR</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script type="text/javascript">
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
    </script>
    <script src="./js/ajax.js"></script>
  </body>
</html>
