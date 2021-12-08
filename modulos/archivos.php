
<?php
require_once "funciones/func_archivos.php";
$id = array_shift($paths);

if (empty($id)){
  switch ($method){
    
    case 'POST':
      echo ('POST ok');
      header('HTTP/1.1 200 OK');
      break;

    default:
      header('HTTP/1.1 405 Method Not Allowed');
      header('Allow: POST');
      break;
  }
} else {

  switch ($method) {

    case 'GET':
      echo ('GET ok');
      header('HTTP/1.1 200 OK');
      break;
      
    case 'PATCH':
      echo ('PATCH ok');
      header('HTTP/1.1 200 OK');
      break;

    case 'DELETE':
      echo ('DEL ok');
      break;

    default:
      header('HTTP/1.1 405 Method Not Allowed');
      header('Allow: GET, DELETE, PATCH');
      break;
  }

}