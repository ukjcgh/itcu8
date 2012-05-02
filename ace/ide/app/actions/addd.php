<?php

$response = new stdClass();

$request = new Request;

if(!$request->data->actionIsLoaded){
	$response->handler = file_get_contents(dirname(__FILE__).'/addd.js');
}

$response->data = array(1,2,3);

echo json_encode($response);
