<?php
/*
 * titulo da tabela CRUD
 */
$imgtoBack= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
<path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/>
</svg>';

?>
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h2>CRUD <b><?php echo $Ucrud?></b></h2>
            </div>
            <div class="col-sm-6">
              <a href="../index.php" target="_self" title="RETORNAR">

              </a>
              <a href="#novoModal" class="btn btn-success" data-toggle="modal" id="opennovo">
                <i class="material-icons"></i> <span>Novo <?php echo $Ucrud?></span>
              </a>
              <a href="JavaScript:void(0);" class="btn btn-danger" id="delete_multiple">
                <i class="material-icons"></i> <span>Remover</span>
              </a>
            </div>
          </div>
        </div>
