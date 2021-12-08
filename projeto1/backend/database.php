<?php
/*
 *  database management
 */
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {die("Conexao ao BD falhou: " . mysqli_connect_error());}
if($debug){fb($crud, 'rerefer',FIREPHP::INFO);}
if($debug){fb($order, '$order',FIREPHP::INFO);}

$sql_select = "SELECT * FROM $crud";

if($order) {$sql_select.= " ORDER BY $order;";}

$result = mysqli_query($conn, $sql_select);
$fieldinfo = mysqli_fetch_fields($result);

foreach ($fieldinfo as $i=>$val) {
  $titulocampos[$i] = strtoupper(substr($val->name,0)); // util caso a tabela possua campos extra_nomeados tipo: T01_campo
  if($i==0){ $idt = $val->name;} // refereincia da coluna id (chave primaria) inerente a tabela em uso. Usualmente a primeira coluna
  $tipocampos[$i] = $val->type;  // array dos tipos [text, int, ...]
}