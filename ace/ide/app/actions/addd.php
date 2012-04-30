<?php

$response = array('data'=>array(1,2,3));

if(!$_POST['actionIsLoaded']){
	$response['handler'] = file_get_contents(dirname(__FILE__).'/addd.js');
}

echo json_encode($response);
