<?php

namespace blocks;

class master extends \data\hand {

	public function __toString() {
		return $this->transform();
	}

	public function getXslFileName(){
		$className = get_class($this);
		$blockName = substr($className, strpos($className, '\\') + 1);
		$blockPath = str_replace('\\', '/', $blockName);
		return $blockPath . '.xsl';
	}

	public function getXmlElemement(){
		$data = new \xml\element('<data/>');
		foreach ($this->data() as $key => $value) {
			if($value instanceof \ArrayObject || gettype($value) == 'array'
					|| (is_object($value) && get_class($value) == 'stdClass')) {
				$data->insertArray($key, $value);
			} elseif($value instanceof \SimpleXMLElement) {
				$data->insertXmlElement($value, $key);
			} elseif($value instanceof \data and $value->hand() instanceof \blocks\master) {
				$xmlElem = new \xml\element("<$key>" . $value->transform(false) . "</$key>");
				$data->insertXmlElement($xmlElem);
			} else {
				$data->$key = (string)$value;
			}
		}
		return $data;
	}

	public function transform($html = true) {

		$xslProc = new \XSLTProcessor();

		// use simplexml_load_string coz faster
		$xsltElem = simplexml_load_string(file_get_contents(IDE_DIR.'config/templates/'.$this->getXslFileName()), 'xml\element');

		$outputNode = $xsltElem->addChild('output');
		$outputNode->addAttribute('indent', 'yes');
		if($html){
			$outputNode->addAttribute('method', 'html');
		} else {
			$outputNode->addAttribute('method', 'xml');
			$outputNode->addAttribute('omit-xml-declaration', 'yes');
		}

		$xslProc->importStylesheet($xsltElem);

		return $xslProc->transformToXml($this->getXmlElemement());

	}

}
