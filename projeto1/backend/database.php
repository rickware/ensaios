<?php
$params = parse_ini_file('./backend/config.ini');
if ($params){
  $path_to_debbuger = $params['debugPatch'];
  $servername = $params['dbHost'];
  $username   = $params['dbUser'];
  $password   = $params['dbpass'];
  $database   = $params['dbname'];
}
$path_to_debbuger = 'C:/bin/php/includes/firephp-core-master/lib/FirePHPCore/fb.php';

if (file_exists($path_to_debbuger)) {
require_once($path_to_debbuger);
$debug = true;
} else {
  $debug = false;
}

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {die("Conexao ao BD falhou: " . mysqli_connect_error());}

/* formata dados em tabela para o FIREPHP-debugger */
function totable($param) {
  $values = mysqli_fetch_all($param,MYSQLI_ASSOC);
  $keys[0] = array_combine(array_keys($values[0]),array_keys($values[0]));
  $result = array_merge($keys, $values);  
  mysqli_data_seek($param, 0);
  return $result;
}
