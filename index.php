<?php
/*require "../db_connect.php";
require "./verify_librarian.php";
require "header_librarian.php";
fb($_SESSION['type'], 'Session type', FirePHP::INFO);*/
?>
<!DOCTYPE html>
<html>
  <head>
    <title>RBMWeb - Ricardo</title>
    <link rel="stylesheet" type="text/css" href="projeto1/css/style.css" />
  </head>
  <body>
    <div id="menu1">
      <a href="./projeto1/crud_clientes.php">
        <input type="button" value="CRUD - Clientes" />
      </a><br />
      <a href="./projeto1/crud_produtos.php">
        <input type="button" value="CRUD - Produtos" />
      </a><br />
      <a href="./projeto1/crud_pedidos.php">
        <input type="button" value="CRUD - Pedidos" />
      </a><br />
      <a href="./projeto1/relatorios.php">
        <input type="button" value="Relat&oacute;rios" />
      </a><br />      
      <br />
    </div>
  </body>
</html>