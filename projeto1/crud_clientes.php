<?php
ob_start();
$referer =substr(pathinfo(__FILE__, PATHINFO_FILENAME), 5) ;
$ureferer = ucwords($referer);
require_once './backend/config.php';
require_once './backend/database.php';
if($debug){fb('start', FIREPHP::INFO);}

// o referer define o crud a ser manipulado
if($debug){fb($referer, 'PATHINFO_FILENAME',FIREPHP::INFO);}
if($debug){fb($titulocampos, '$titulocampos',FIREPHP::INFO);}
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
              for ($x = 0; $x <= count($titulocampos); $x++) {  // monta o cabecario
                if($x > 0){echo '<th>'.$titulocampos[$x].'</th>';} // ignora a coluna 0 - ID
              } 
              ?>
            </tr>
          </thead>
          <tbody>

            <?php
            //if($debug){fb(totable($result) ,'result', FirePHP::TABLE);
            while ($row = mysqli_fetch_array($result,MYSQLI_BOTH)) {
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
                    <i class="material-icons update" data-toggle="tooltip" title="Editar" <?php 
                      for ($x = 0; $x < count($titulocampos); $x++) {echo ' data-'.$titulocampos[$x].'= "'.$row[$x].'" ';} ?>></i>
                  </a>
                  <a href="#excluiModal" class="delete" data-id="<?php echo $row['id']; ?>" data-toggle="modal">
                    <i class="material-icons" data-toggle="tooltip" title="Excluir"></i>
                  </a>
                </td>
                <?php
                foreach ($fieldinfo as $val) {
                  $col = $val->name;
                  if($col != $idt) { echo '<td>'.$row[$col].'</td>'; } // ignora a coluna ID na tabela
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
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="add_form">
            <div class="modal-header">
              <h4 class="modal-title">Adicionar <?php echo $ureferer?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <?php for ($x = 0; $x <= count($titulocampos); $x++) {
                $campo = strtolower($titulocampos[$x]);
                $type  = getfieldType($tipocampos[$x]);
                $class = ($type == 'checkbox') ? 'form-check': 'form-group';
                $slass = ($type == 'checkbox') ? 'form-check-input': 'form-control';
                echo '
              <div class="'.$class.'">
                <label>'.$titulocampos[$x].':</label>
                <input type="'.$type.'" id="'.$campo.$x.'" name="'.$campo.'" class="'.$slass.'">
              </div>
              ';} ?>
            </div>
            <div class="modal-footer">
              <input type="hidden" value="<?php echo $referer?>" name="crud">
              <input type="hidden" value="1" name="tipo">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-success" id="btn-add">INSERIR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Edita HTML -->
    <div id="editaClienteModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Editar dados do <?php echo $ureferer?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <form id="update_form">
            <div class="modal-body">
              <input type="hidden" id="id_u" name="id" class="form-control" required>
              <div class="form-group">
                <label>Nome:</label>
                <input type="text" id="nome_u" name="nome" class="form-control" required>
              </div>
              <div class="form-group">
                <label>E-mail:</label>
                <input type="email" id="email_u" name="email" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Celular:</label>
                <input type="celular" id="celular_u" name="celular" class="form-control" required>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" value="<?php echo $referer?>" name="crud">
              <input type="hidden" value="2" name="tipo">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCELAR">
              <button type="button" class="btn btn-info" id="btn-update">ATUALIZAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Exclui HTML -->
    <div id="excluiClienteModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="delete_form">
            <div class="modal-header">
              <h4 class="modal-title">Excluir Cliente</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id_d" name="id" class="form-control">
              <p>Está certo que deseja continuar?</p>
              <p class="text-warning"><small>ESTA AÇÃO NÃO PODE SER DESFEITA.</small></p>
            </div>
            <div class="modal-footer">
              <input type="hidden" value="cliente" name="crud">
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
