<?php

namespace xml;

class model extends \data\hand {

	protected $entity;

	protected $config;
	protected $configFile;
	protected $source;
	protected $sourceFile;

	public function init($entity){
		$this->entity = $entity;
		if(preg_match('~[^a-zA-Z/]~', $this->entity)){
			error('Invalid entity name "' . $this->entity . '"');
		}
		$this->configFile = IDE_DIR.'config/models/'.$this->entity.'.xml';
		$this->sourceFile = APP_DIR.$this->entity.'.xml';
		$this->config = $this->source = null;
		return $this;
	}

	public function getItem($code){
		$result = $this->getSource()->xpath('item[./code=' . $this->escape_xpath_var($code) . ']');
		return count($result) ? $result[0] : false;
	}

	public function load($code = null){
		$code = is_null($code) ? $this->data()->code : $code;
		if($item = $this->getItem($code)){
			$data = array();
			foreach($item as $k=>$v) $data[$k] = (string)$v;
			$this->data()->import($data);
			return true;
		}
		return false;
	}

	// insert or update
	public function save($data = null){
		$data = is_null($data) ? $this->data() : $data;
		if(!isset($data->code)){
			error('Can\'t save "'.$this->entity.'". Code is not specified');
		}
		$item = $this->getItem($data->code);
		if(!$item){
			$this->_insert($data);
		} else {
			$this->_update($data, $item);
		}
		return $this;
	}

	public function insert($data = null){
		$data = is_null($data) ? $this->data() : $data;
		if(!isset($data->code)){
			error('Can\'t insert into "'.$this->entity.'". Code is not specified');
		}
		if(!($item = $this->getItem($data->code))){
			$this->_insert($data);
		} else {
			error('Can\'t insert into "'.$this->entity.'". Item code="'.$data->code.'" already exists');
		}
		return $this;
	}

	protected function _insert($data){
		$item = $this->getSource()->addChild('item');
		foreach($this->getConfig()->forms->add->fields->children() as $field=>$stuff) {
			if(isset($data->$field)){
				$item->$field = $data->$field;
			} else {
				//TODO: default value from config
				$item->$field = '';
			}
		}
	}

	public function update($data = null){
		$data = is_null($data) ? $this->data() : $data;
		if(!isset($data->code)){
			error('Can\'t insert to "'.$this->entity.'". Code is not specified');
		}
		if($item = $this->getItem($data->code)){
			$this->_update($data, $item);
		} else {
			error('Can\'t update "'.$this->entity.'". Item code="'.$data->code.'" doesn\'t exists');
		}
		return $this;
	}

	protected function _update($data, $item){
		foreach($this->getConfig()->forms->edit->fields->children() as $field=>$stuff) {
			if(isset($data->$field)){
				$item->$field = $data->$field;
			}
		}
	}

	public function delete($code = false){
		$data = $this->data();
		$code = $code !== false ? $code : (isset($data->code) ? $data->code : false);
		if($code === false){
			error('Can\'t detele item from "'.$this->entity.'". Code is not specified');
		}
		if(($position = $this->getItemPosition($code)) !== false){
			unset($this->getSource()->item[$position]);
		} else {
			error('Can\'t detele item "'.$code.'" from "'.$this->entity.'", not found');
		}
		return $this;
	}

	public function getItemPosition($code){
		$i = 0;
		foreach ($this->getSource()->item as $item){
			if($item->code == $code){
				$position = $i;
				return $i;
			}
			$i++;
		}
		return false;
	}

	public function commit(){
		file_put_contents($this->sourceFile, $this->getSource()->asNiceXml());
		$this->source = null;
		return $this;
	}

	public function getConfig(){
		if(!$this->config) $this->config = new \xml\element($this->configFile, 0, true);
		if(!$this->config) {
			error('Can\'t load config of "' . $this->entity . '"');
		}
		return $this->config;
	}

	public function getSource(){
		if(!$this->source) $this->source = new \xml\element($this->sourceFile, 0, true);
		if(!$this->source) {
			error('Can\'t load source of "' . $this->entity . '"');
		}
		return $this->source;
	}

	public function getConfigFile(){
		return $this->configFile;
	}

	public function getSourceFile(){
		return $this->sourceFile;
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
