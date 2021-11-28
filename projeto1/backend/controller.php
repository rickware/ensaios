<?php

FILTER_NULL_ON_FAILURE;
$operacao = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT);

if ($operacao) {
  include './database.php';
  $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
  $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING);

  switch ($operacao) {
    case 1:  //inserir
      $sql = "INSERT INTO `clientes`( `nome`, `email`,`celular`) VALUES ('$nome','$email','$celular')";
      if (mysqli_query($conn, $sql)) {
        echo json_encode(array("statusCode" => 200));
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
      mysqli_close($conn);
      break;

    case 2: //atualizar
      $sql = "UPDATE `clientes` SET `nome`='$nome',`email`='$email',`celular`='$celular' WHERE id=$id";
      if (mysqli_query($conn, $sql)) {
        echo json_encode(array("statusCode" => 200));
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
      mysqli_close($conn);
      break;

    case 3: //remove um registro
      $sql = "DELETE FROM clientes WHERE id=$id ";
      if (mysqli_query($conn, $sql)) {
        echo $id;
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
      mysqli_close($conn);
      break;

    case 4: //remove varios
      $sql = "DELETE FROM clientes WHERE id in ($id)";
      if (mysqli_query($conn, $sql)) {
        echo $id;
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
      mysqli_close($conn);
  }
}  