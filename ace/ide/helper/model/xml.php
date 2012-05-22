<?php

namespace model;

class xml extends \data\hand {

	protected $source;

	public function setSource($source){
		$this->source = $source;
	}

	public function load($code){
		$xmlElem = new \XmlElement($this->source, 0, true);
		$result = $xmlElem->xpath('item[./code=' . $this->escape_xpath_var($code) . ']');
		if(count($result)){
			$data = array();
			foreach($result[0] as $k=>$v) $data[$k] = (string)$v;
			$this->data()->import($data);
			return true;
		}
		return false;
	}

	public function save(){

	}

	public function escape_xpath_var($var){
		if(strpos($var, '"') !== false) {
			$escaped = preg_replace('~("+)~', '",\'$1\',"', $var);
			$escaped = 'concat("' . $escaped . '")';
		} else {
			$escaped = "'$var'";
		}
		return $escaped;
	}

}
