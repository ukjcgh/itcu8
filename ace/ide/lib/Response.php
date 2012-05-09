<?php

class Response {

	public function __toString(){
		global $request;

		if($request->isAjax()){
			return ace_json($this->box);
		} else {
			return (string)$this->html;
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
