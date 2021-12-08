<?php
  $mysqli = new mysqli("localhost", "root", "", "aveo_dev");

	function GetData ($mysqli,$query,$boolid=0) {
		if ($resultado = $mysqli->query($query)) {
			$data=[];
			while ($value = $resultado->fetch_array(MYSQLI_ASSOC)) {
				if ($boolid==0) {
					$data[$value['referencia']] = $value;  
				}else {
					$data[]= $value;
				}
			}
			return $data;
		} else {
			$error = array('Error' => $mysqli->error);
			echo json_encode($error);
			header('HTTP/1.1 406 Not Acceptable');
			exit();
		}
	}
 
  function InsertData($mysqli,$data,$table) {
    foreach($data as $param => $value) {
			$filterParams[] = "$param";
			$filterValues[] = "'$value'";
    }
    $params= "(".implode(", ", $filterParams).")";
    $values= "(".implode(", ", $filterValues).")";
    $query="INSERT INTO $table $params VALUES $values";
		$resultado = $mysqli->query($query);
    if ($resultado){
        return $mysqli->insert_id; 
    	} else {
        $error = array('Error' => $mysqli->error);
        echo json_encode($error);
        header('HTTP/1.1 406 Not Acceptable');
        exit();
    	}
  }

	function GetDataRow ($mysqli,$query){
		if ($resultado = $mysqli->query($query)) {
			return   $resultado->fetch_array(MYSQLI_ASSOC);
		} else {
			$error = array('Error' => $mysqli->error);
			echo json_encode($error);
			header('HTTP/1.1 406 Not Acceptable');
			exit();
		}
	}

	function UpdateData ($mysqli,$data,$table,$id){
		foreach($data as $param => $value){
			$filterParams[] = "$param='$value'";
		}
		$params= implode(", ", $filterParams);
		$query="UPDATE $table SET $params WHERE referencia='$id'";
		$resultado = $mysqli->query($query);
    if ($resultado){
			return  array('rows' => $mysqli->affected_rows); 
		} else {
			$error = array('Error' => $mysqli->error);
			echo json_encode($error);
			header('HTTP/1.1 406 Not Acceptable');
			exit();
		}
	}

	function DelData ($mysqli, $table, $id ) {
		$query = "DELETE FROM $table WHERE referencia=$id ";
    $r = $mysqli->query($query);
		if (!$r) {
			$error = array('Error' => "No existe ID");
			echo json_encode($error);
			header('HTTP/1.1 406 Not Acceptable');
			exit();
		} else {
			return array('Delete' => $r);
		}
	}

?>