<?php
require_once('C:/bin/php/includes/firephp-core-master/lib/FirePHPCore/fb.php');
$servername = "localhost";
$username = "serverman";
$password = "r1cKsn4K3//123//";
$dbname = "rbmweb";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

/* formata dados em tabela para o FIREPHP-debugger */
function totable($param) {
  $values = mysqli_fetch_all($param,MYSQLI_ASSOC);
  $keys[0] = array_combine(array_keys($values[0]),array_keys($values[0]));
  $result = array_merge($keys, $values);  
  mysqli_data_seek($param, 0);
  return $result;
}