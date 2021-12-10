
<?php

require_once "funciones/func_archivos.php";
$id_archivo = array_shift($paths);

if (empty($id_archivo)) {
  switch ($method) {

    case 'POST':
      $data = json_decode(file_get_contents('php://input'), true);
      $id2 = $data['referencia'];
      unset($data['referencia']);
      $id = GuardarArchivo($mysqli, $data);
      if ($id){
        $data_ref = array('ruta_imagen' => $id['id']);
        $id_patch = UpdateData($mysqli, $data_ref, 'productos', $id2);
        echo json_encode($id_patch);
        header('HTTP/1.1 201 Created');
        break;
      }

    default:
      header('HTTP/1.1 400 Bad Request');
      header('Allow: POST');
      break;
  }

} else {
  switch ($method){
    case 'GET':
      $resp = LeerArchivo ($mysqli,$id_archivo);
      $resp['base'] = "data:".$resp['tipo'].";base64,".$resp['base'];
      $resp['name'] = $resp['name'].".".$resp['ext'];
      unset($resp['ext']);
      header('HTTP/1.1 200 OK');
      echo json_encode($resp);
      break;

    case 'DELETE':
      $query = "SELECT * FROM archivos WHERE id=$id_archivo ";
      $data=GetData($mysqli,$query);
      if ($data) {
        $data = $data[$id_archivo];
        $ruta = $data['path'];
        $resp = unlink($ruta);
        if ($resp) {
          $query = "DELETE FROM archivos where id=$id_archivo";
          $r = $mysqli->query($query);
          if ($r) {
            $r = array("message" => "Delete All Id: $id_archivo");
            header('HTTP/1.1 200 OK');
            echo json_encode($r);
            break;
          }
        }
      } else {
        header('HTTP/1.1 404 Not Found');
        break;
      }
    default:
      header('HTTP/1.1 400 Bad Request');
      header('Allow: GET, DELETE');
      break;
  }

}