<?php

class Response {

	public function __toString(){
		//TODO: log and clean output from ob
		global $request;

		if(!isset($this->data)){
			trigger_error('Nothing to send in response.', E_USER_ERROR);
		}

		if($request->isAjax()){
			$responseData = array('data'=>$this->data);
			if(isset($this->handler)) $responseData['handler'] = $this->handler;
			return json_encode($responseData);
		} else {
			return (string)$this->data;
		}
	}

	public function send($exit = true){
		global $request;

		if($request->isAjax()){
			header('Content-type: text/json');
			$responseData = array('data'=>$this->data);
			if(isset($this->handler)) $responseData['handler'] = $this->handler;
			echo json_encode($responseData);
		} else {
			echo $this->data;
		}

		if($exit) exit;
	}

}
