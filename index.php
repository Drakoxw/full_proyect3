<?php

class Server{
	public function serve(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers");
		header('Content-Type: application/json');
		$method = $_SERVER['REQUEST_METHOD'];

		if ($method == "OPTIONS") {
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers");
			header("HTTP/1.1 200 OK");
			exit();
		}

		require_once "funciones/func_archivos.php";
		$uri = $_SERVER['REQUEST_URI'];
		$paths = explode('/', $this->paths($uri));
		array_shift($paths);
		$resource = array_shift($paths);

		switch ($resource) {
			case 'archivo':
			   require_once "modulos/archivos.php";
			   break;
			case 'productos':
				require_once "modulos/$resource.php";
				break;
				
			default:
				header('HTTP/1.1 404 Not Found');
				break;
		}
	}

	public function paths($url){
		$uri = parse_url($url);
		return $uri['path'];
	} 
}

$server = new Server;
$server->serve();
