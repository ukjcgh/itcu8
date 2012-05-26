<?php

namespace xml;

class model extends \data\hand {

	protected $config;
	protected $configFile;
	protected $source;
	protected $sourceFile;

	public function init($entity){
		if(preg_match('~[^a-zA-Z/]~', $entity)){
			trigger_error('Invalid entity name "' . $entity . '"', E_USER_ERROR);
		}
		$this->configFile = IDE_DIR.'config/models/'.$entity.'.xml';
		$this->sourceFile = APP_DIR.$entity.'.xml';
		$this->config = $this->source = null;
		return $this;
	}

	public function load($code){
		$result = $this->getSource()->xpath('item[./code=' . $this->escape_xpath_var($code) . ']');
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
		$result = $this->getSource()->xpath('item[./code=' . $this->escape_xpath_var($data->code) . ']');
		$item = count($result) ? $result[0] : $this->getSource()->addChild('item');
		foreach($this->getConfig()->forms->edit->fields->children() as $field=>$stuff) {
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
		foreach ($this->getSource()->item as $item){
			if($item->code == $code){
				$position = $i;
				break;
			}
			$i++;
		}

		if(isset($position)){
			unset($this->getSource()->item[$position]);
			$this->saveSource();
		} else {
			trigger_error('Can\'t detele item "'.$code.'", not found', E_USER_ERROR);
		}
	}

	public function getConfig(){
		if(!$this->config) $this->config = new \xml\element($this->configFile, 0, true);
		return $this->config;
	}

	public function getSource(){
		if(!$this->source) $this->source = new \xml\element($this->sourceFile, 0, true);
		return $this->source;
	}

	public function saveSource(){
		file_put_contents($this->sourceFile, $this->source->asNiceXml());
		$this->source = null;
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
