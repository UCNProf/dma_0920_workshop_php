<?php
//print_r($_SERVER);
header('Content-type: application/json; charset=UTF-8');

// headers enabling CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
if(array_key_exists('HTTP_ACCESS_CONTROL_REQUEST_HEADERS', $_SERVER))
  header('Access-Control-Allow-Headers: '.$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']);

// if the request has a body it will be assigned to $request_data as JSON
$input = file_get_contents('php://input');
$request_data = json_decode($input);

// db connection
$conn = new PDO('mysql:host=database;dbname=website01;charset=utf8', 'website01', 'eLow8yBSp34wXx');

// the initial object $obj
$obj = (object)[];
$obj->action = 'error';

// the function will be called when the script shuts down
function shutdown($obj){
  echo json_encode($obj);
}
// the shutdown function is registered as a shotdown function
register_shutdown_function('shutdown', $obj);

// array for the endpoint that is requested
$path = array();

if(array_key_exists('path', $_GET)){
  $path = explode('/', $_GET['path']);
}

// if anything is in the path array require the file
if(count($path) > 0){
  if(file_exists($_SERVER['DOCUMENT_ROOT'].'/api/'.$path[0].'.php')){
    require_once($_SERVER['DOCUMENT_ROOT'].'/api/'.$path[0].'.php');
  }
}
?>
