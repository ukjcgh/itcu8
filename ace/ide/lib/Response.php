<?php

class Response {

	use pubCollector;

	public function __toString(){
		global $request;

		if($request->isAjax()){
			return ace_json($this->_pub);
		} else {
			return (string)$this->_pub['data'];
		}
	}

	public function send($exit = true){
		//TODO: log and clean output from ob
		global $request;

		if($request->isAjax()){
			header('Content-type: text/json');
		}

		echo $this;

		if($exit) exit;
	}

}
