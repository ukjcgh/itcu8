<?php

class Request {
	
	public function __construct(){
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			$requestData = isset($_POST['requestData']) ? $_POST['requestData'] : null;
			$this->data = json_decode($requestData);
		} else {
			$this->data = $_POST;
		}
	}
	
}
