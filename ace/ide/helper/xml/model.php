<?php

namespace xml;

class model extends \data\hand {

	protected $source;
	protected $sourceFile;
	protected $model;

	public function init($entity){
		$this->sourceFile = APP_DIR.$entity;
		$modelFile = IDE_DIR.'config/models/'.$entity;
		$this->source = new \xml\element($this->sourceFile, 0, true);
		$this->model = new \xml\element($modelFile, 0, true);
		return $this;
	}

	public function load($code){
		$result = $this->source->xpath('item[./code=' . $this->escape_xpath_var($code) . ']');
		if(count($result)){
			$data = array();
			foreach($result[0] as $k=>$v) $data[$k] = (string)$v;
			$this->data()->import($data);
			return true;
		}
		return false;
	}

	public function upload(){
		$data = $this->data();
		if(!isset($data->code)) trigger_error('Can\'t save. Code is not specified', E_USER_ERROR);
		$result = $this->source->xpath('item[./code=' . $this->escape_xpath_var($data->code) . ']');
		$item = count($result) ? $result[0] : $this->source->addChild('item');
		foreach($this->model->forms->edit->fields->children() as $field=>$stuff) {
			$item->$field = trim($data->$field);
		}
		$this->saveSource();
	}

	public function delete($code = false){
		$data = $this->data();
		$code = $code !== false ? $code : (isset($data->code) ? $data->code : false);
		if($code === false) trigger_error('Can\'t detele item. Code is not specified', E_USER_ERROR);

		$position = null;
		$i = 0;
		foreach ($this->source->item as $item){
			if($item->code == $code){
				$position = $i;
				break;
			}
			$i++;
		}

		if(isset($position)){
			unset($this->source->item[$position]);
			$this->saveSource();
		} else {
			trigger_error('Can\'t detele item "'.$code.'", not found', E_USER_ERROR);
		}
	}

	public function getConfig(){
		return $this->model;
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

	public function saveSource(){
		file_put_contents($this->sourceFile, $this->source->asNiceXml());
		$this->source = new \xml\element($this->sourceFile, 0, true);
	}

}
