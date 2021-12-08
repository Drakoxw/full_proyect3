<?php
require_once "funciones/func_sql.php";

$id = array_shift($paths);

if (empty($id)){
  switch ($method){

    case 'GET':
      $query = "SELECT * FROM productos ";
      $data = GetData($mysqli,$query);
      echo json_encode($data);
      header('HTTP/1.1 200 OK');
      break;

    case 'POST':
      $data = json_decode(file_get_contents('php://input'), true);
      if (isset($data['referencia'])) {
        unset($data['referencia']);
      }
      $postId = InsertData($mysqli, $data, 'productos');
      $res = array('ref' => $postId);
      echo json_encode ($res);
      header('HTTP/1.1 201 OK');
      break;

    default:
      header('HTTP/1.1 405 Method Not Allowed');
      header('Allow: GET, POST');
      break;
  }
} else {

  switch ($method) {

    case 'GET':
      $query = "SELECT * FROM productos WHERE referencia=$id ";
      $data = GetData($mysqli,$query);
      echo json_encode($data);
      header('HTTP/1.1 200 OK');
      break;
      
    case 'PATCH':
      $query = "SELECT * FROM productos WHERE referencia=$id ";
      $camp = GetData($mysqli,$query);
      if (array_key_exists($id, $camp)){
        $data = json_decode(file_get_contents('php://input'), true);
        unset($data['referencia']);
        $postId = UpdateData($mysqli, $data, 'productos',$id);
        header('HTTP/1.1 200 OK');
        echo json_encode($postId);
        break;
      } else {
        header('HTTP/1.1 204 No Content');
        break;
      }

    case 'DELETE':
      $res = DelData($mysqli, 'productos', $id );
      header('HTTP/1.1 200 OK');
      echo json_encode($res);
      break;

    default:
      header('HTTP/1.1 405 Method Not Allowed');
      header('Allow: GET, DELETE, PATCH');
      break;
  }

}

