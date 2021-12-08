<?php

$iniFile=__DIR__.'/config.ini';
$params=parse_ini_file($iniFile);

if ($params) {
  $path_to_debbuger=$params['debugPatch'];
  $servername=$params['dbHost'];
  $username=$params['dbUser'];
  $password=$params['dbpass'];
  $database=$params['dbname'];
} else {
  die('Falta arquivo de parametros');
}

/* debug com o FIREPHP */
if (file_exists($path_to_debbuger)) {
  require_once($path_to_debbuger);
  $debug=true;
} else {
  $debug=false;
}

require __DIR__.'/database.php';

/* formata dados em tabela para o FIREPHP-debugger */
function totable($param) {
  $values=mysqli_fetch_all($param, MYSQLI_ASSOC);
  $keys[0]=array_combine(array_keys($values[0]), array_keys($values[0]));
  $result=array_merge($keys, $values);
  mysqli_data_seek($param, 0);
  return $result;
}

/* resolve o tipo de entrada no formulario [input type] com base no retorno da qyery */
function getfieldType($cod) {
  switch ($cod) {
    case 1: $fieldType='checkbox';
      break;
    case 3: $fieldType='number';
      break;
    default: $fieldType='text';
      break;
  }
  /*
    type        Codigo
    tinyint_    1
    boolean_    1
    smallint_    2
    int_        3
    float_        4
    double_        5
    real_        5
    timestamp_    7
    bigint_        8
    serial        8
    mediumint_    9
    date_        10
    time_        11
    datetime_    12
    year_        13
    bit_        16
    decimal_    246
    text_        252
    tinytext_    252
    mediumtext_    252
    longtext_    252
    tinyblob_    252
    mediumblob_    252
    blob_        252
    longblob_    252
    varchar_    253
    varbinary_    253
    char_        254
    binary_        254
   */
  return $fieldType;
}

function monta_campos_form($a,$titulos, $tipos) {
  $html_fields = '';
  $idcampo = ($a=='a')? '_a':'_u';

  for ($x=0; $x < count($titulos); $x++) {
    $campo=strtolower($titulos[$x]);
    if ($campo == 'id') {continue;} //id = autoincrement ignorada
    $type=getfieldType($tipos[$x]); //busca o tipo na tabela

    $class = ($type == 'checkbox')?'form-check':'form-group';
    $slass = ($type == 'checkbox')?'form-check-input':'form-control';

    $html_fields .= '
  <div class="'.$class.'">
    <label>'.$campo.':</label>
    <input type="'.$type.'" id="'.$campo.$idcampo.'" name="'.$campo.'" class="'.$slass.'">
  </div>
  ';
  }
  return $html_fields;
}
