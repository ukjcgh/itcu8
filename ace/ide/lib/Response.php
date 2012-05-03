<?php

class Response {

	public function __toString(){
		global $request;

		if($request->isAjax()){
			$responseData = array('data'=>$this->data);
			if(isset($this->handler)) $responseData['handler'] = $this->handler;
			if(isset($this->error)) $responseData['error'] = $this->error;
			return json_encode($responseData);
		} else {
			return (string)$this->data;
		}
	}

	public function send($exit = true){
		//TODO: log and clean output from ob
		global $request;

		if(!isset($this->data)){
			trigger_error('Nothing to send in response.', E_USER_ERROR);
		}

		if($request->isAjax()){
			header('Content-type: text/json');
		}

		echo $this;

		if($exit) exit;
	}

}
