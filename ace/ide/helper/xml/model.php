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
		$probe = $this->probeSave($data);
		$this->_save($probe);
		return $this;
	}

	public function probeSave($data = null){
		$data = is_null($data) ? $this->data() : $data;
		if(!isset($data->code)){
			error('Can\'t save "'.$this->entity.'". Code is not specified');
		}
		$probe = array('data' => $data);
		if($item = $this->getItem($data->code)){
			$probe['item'] = $item;
		}
		return $probe;
	}

	protected function _save($probe){
		if(isset($probe['item'])){
			$this->_update($probe);
		} else {
			$this->_insert($probe);
		}
	}

	public function insert($data = null){
		$probe = $this->probeInsert($data);
		$this->_insert($probe);
		return $this;
	}

	public function probeInsert($data = null){
		$data = is_null($data) ? $this->data() : $data;
		if(!isset($data->code)){
			error('Can\'t insert into "'.$this->entity.'". Code is not specified');
		}
		if($this->getItem($data->code)){
			error('Can\'t insert into "'.$this->entity.'". Item code="'.$data->code.'" already exists');
		}
		return array('data'=>$data);
	}

	protected function _insert($probe){
		$item = $this->getSource()->addChild('item');
		foreach($this->getConfig()->forms->add->fields->children() as $field=>$stuff) {
			if(isset($probe['data']->$field)){
				$item->$field = $probe['data']->$field;
			} else {
				//TODO: default value from config
				$item->$field = '';
			}
		}
	}

	public function update($data = null){
		$probe = $this->probeUpdate($data);
		$this->_update($probe);
		return $this;
	}

	public function probeUpdate($data = null){
		$data = is_null($data) ? $this->data() : $data;
		if(!isset($data->code)){
			error('Can\'t insert to "'.$this->entity.'". Code is not specified');
		}
		if(!($item = $this->getItem($data->code))){
			error('Can\'t update "'.$this->entity.'". Item code="'.$data->code.'" doesn\'t exists');
		}
		return array('data'=>$data, 'item'=>$item);
	}

	protected function _update($probe){
		foreach($this->getConfig()->forms->edit->fields->children() as $field=>$stuff) {
			if(isset($probe['data']->$field)){
				$probe['item']->$field = $probe['data']->$field;
			}
		}
	}

	public function delete($code = null){
		$probe = $this->probeDelete($code);
		$this->_delete($probe);
		return $this;
	}

	public function probeDelete($code = null){
		$data = $this->data();
		$code = is_null($code) ? (isset($data->code) ? $data->code : null) : $code;
		if(is_null($code)){
			error('Can\'t detele item from "'.$this->entity.'". Code is not specified');
		}
		if(($position = $this->getItemPosition($code)) === false){
			error('Can\'t detele item "'.$code.'" from "'.$this->entity.'", not found');
		}
		return array('position' => $position);
	}

	protected function _delete($probe){
		unset($this->getSource()->item[$probe['position']]);
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
