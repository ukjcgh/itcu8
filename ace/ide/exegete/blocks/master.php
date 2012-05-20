<?php

namespace blocks;

class master extends \data\hand {

	public static $TPL_DIR;

	public function __toString() {
		return $this->transform($this->getTemplateFileName(), $this->getXslData());
	}

	public function getTemplateFileName(){
		$className = get_class($this);
		$blockName = substr($className, strpos($className, '\\') + 1);
		$blockPath = str_replace('\\', '/', $blockName);
		return $blockPath . '.xsl';
	}

	public function getXslData(){
		$data = new \XmlElement('<data/>');
		foreach ($this->data() as $key => $value) {
			if($value instanceof \ArrayObject || gettype($value) == 'array') {
				$data->insertArray($key, $value);
			} elseif($value instanceof \SimpleXMLElement) {
				$data->insertXmlElement($value, $key);
			} else {
				$data->$key = (string)$value;
			}
		}
		return $data;
	}

	public function transform($xslFile, $xmlElem = null) {

		if(is_null($xmlElem)) $xmlElem = new \XmlElement('<data/>');

		$xslProc = new \XSLTProcessor();

		// use simplexml_load_string coz faster
		$xsltElem = simplexml_load_string(file_get_contents($this::$TPL_DIR . $xslFile), 'XmlElement');

		$outputNode = $xsltElem->addChild('output');
		$outputNode->addAttribute('method', 'html');

		$xslProc->importStylesheet($xsltElem);

		return $xslProc->transformToXml($xmlElem);

	}

}
