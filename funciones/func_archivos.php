<?php
  require_once "funciones/func_sql.php";
  $mysqli = new mysqli("localhost", "root", "", "aveo_dev");

  function GuardarArchivo ($mysqli,$payload) {
    $payload['name'] =  NombreRamd();
    $ext = $payload['ext'];
    $rutaImagenSalida = "C:/xampp/htdocs/archivos/{$payload['name']}.$ext";
    $base64= explode(",",$payload['base']);
    $convertido = base64_decode($base64[1]);
    if (file_put_contents($rutaImagenSalida, $convertido)){
      $payload['base'] = $base64[0];
      $payload['path'] = $rutaImagenSalida;
      unset($payload['base']);
      $postId = InsertData($mysqli, $payload, 'archivos');
      $id = array('id' => $postId);
    return $id;
    } else {
      $error = array('Error' => "no se pudo guardar el archivo");
      echo json_encode($error);
      header('HTTP/1.1 406 Not Acceptable');
    }
   
  }

  function LeerArchivo ($mysqli,$id) {
    $data = GetDataRow($mysqli,"SELECT * FROM archivos where id='$id'");
    $data2 = file_get_contents( $data['path']);
    if ($data2) {
      $data['base'] = base64_encode($data2);
      unset($data['id']);
      unset($data['path']);
      if (isset($data2)) {
        //echo json_encode($data);
        return $data;
      } 
      
    }
   
  }

  function NombreRamd(){
    $caracteresPosibles = "0123456789abcdef";
    $azar = '';
    for($i=0; $i<16; $i++){
      $azar .= $caracteresPosibles[rand(0,strlen($caracteresPosibles)-1)];
    }
    return $azar;
  }