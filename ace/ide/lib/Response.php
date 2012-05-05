<?php

class Response {

	use propsCollector;

	public function __toString(){
		global $request;

		if($request->isAjax()){
			return ace_json($this->props());
		} else {
			return (string)$this->data;
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
