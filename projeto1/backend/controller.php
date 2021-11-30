<?php

FILTER_NULL_ON_FAILURE;
$origem = filter_input(INPUT_POST, 'crud', FILTER_SANITIZE_STRING); //define a origem

if ($origem) {
  include './database.php';
  $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
  $operacao = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT); // define o tipo de operacao

  switch ($origem) {
    case 'cliente':
      $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING);

      switch ($operacao) {
        case 1:  //inserir
          $sql = "INSERT INTO clientes( nome, email,celular) VALUES ('$nome','$email','$celular')";
          if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
          break;

        case 2: //atualizar
          $sql = "UPDATE clientes SET nome='$nome',email='$email',celular='$celular' WHERE id=$id";
          if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
          break;

        case 3: //remove um registro
          $sql = "DELETE FROM clientes WHERE id=$id ";
          if (mysqli_query($conn, $sql)) {
            echo $id;
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
          break;

        case 4: //remove varios
          $sql = "DELETE FROM clientes WHERE id in ($id)";
          if (mysqli_query($conn, $sql)) {
            echo $id;
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
      }
      break;

    case 'produto':
      $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
      $codigo = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
      $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
      $preco = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_NUMBER_FLOAT);
      $categoria = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
      $estoque = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_NUMBER_INT);

      switch ($operacao) {
        case 1:  //inserir
          $sql = "INSERT INTO produtos (codigo, nome, preco, unidade, categoria, estoque) "
                  . "VALUES ('$codigo', '$nome', '$preco, '$unidade', '$categoria', '$estoque'); ";
          if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
          break;

        case 2: //atualizar
          $sql = "UPDATE produtos SET "
                  . "codigo='$codigo',"
                  . "nome='$nome',"
                  . "preco='$preco',"
                  . "unidade='$unidade',"
                  . "categoria='$categoria',"
                  . "estoque='$estoque' "
                  . "WHERE id = $id;";
          if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
          break;

        case 3: //remove um registro
          $sql = "DELETE FROM produtos WHERE id=$id ";
          if (mysqli_query($conn, $sql)) {
            echo $id;
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }

          break;

        case 4: //remove varios
          $sql = "DELETE FROM produtos WHERE id in ($id)";
          if (mysqli_query($conn, $sql)) {
            echo $id;
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
      }
      break;

    case 'pedido':
      $cliente = filter_input(INPUT_POST, 'cliente', FILTER_SANITIZE_STRING);
      $data_do_pedido = filter_input(INPUT_POST, 'datap', FILTER_SANITIZE_STRING);
      
      switch ($operacao) {
        case 1:  //inserir
          $sql = "INSERT INTO pedidos(cliente_id, data_do_pedido) VALUES ('$cliente','$data_do_pedido')";
          if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
          break;

        case 2: //atualizar
          $sql = "UPDATE pedidos SET cliente_id='$cliente',data_do_pedido='$data_do_pedido' WHERE id=$id,";
          if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
          break;

        case 3: //remove um registro
          $sql = "DELETE FROM pedidos WHERE id=$id ";
          if (mysqli_query($conn, $sql)) {
            echo $id;
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
          break;

        case 4: //remove varios
          $sql = "DELETE FROM pedidos WHERE id in ($id)";
          if (mysqli_query($conn, $sql)) {
            echo $id;
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
      }
      break;
          case 'detalhe':
      $pedido_id = filter_input(INPUT_POST, 'cliente', FILTER_SANITIZE_NUMBER_INT);
      $produto_id = filter_input(INPUT_POST, 'datap', FILTER_SANITIZE_NUMBER_INT);
      $quantidade = filter_input(INPUT_POST, 'datap', FILTER_SANITIZE_NUMBER_FLOAT);
      
      switch ($operacao) {
        case 1:  //inserir
          $sql = "INSERT INTO pedido_detalhes(pedido_id, produto_id, quantidade) "
                . "VALUES ($pedido_id, $produto_id, $quantidade)";
          if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
          break;

        case 2: //atualizar
          $sql = "UPDATE pedido_detalhes SET "
                . "pedido_id=$pedido_id,"
                . "produto_id=$produto_id,"
                . "quantidade='$quantidade' "
                . "WHERE id = $id;";
          if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
          break;

        case 3: //remove um registro
          $sql = "DELETE FROM pedido_detalhes WHERE id=$id ";
          if (mysqli_query($conn, $sql)) {
            echo $id;
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
          break;

        case 4: //remove varios
          $sql = "DELETE FROM pedido_detalhes WHERE id in ($id)";
          if (mysqli_query($conn, $sql)) {
            echo $id;
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
      }
      break;
  }
  
  mysqli_close($conn);
}