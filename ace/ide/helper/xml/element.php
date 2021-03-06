<?php

namespace xml;

class element extends \SimpleXMLElement {

	public function addChild($name, $value = null, $namespace = null) {
		return parent::addChild($name, html($value), $namespace);
	}

	//TODO: don't work with namespaces e.g. xsl
	//TODO: render attributes (don't forget about root node) - not necessary now
	//TODO: render value which is midst childs - not necessary now
	public function asNiceXML($element = null, $level = 1) {

		$xml = '';
		if(is_null($element)) $element = $this;

		foreach ($element->children() as $node){
			$indent = str_repeat("\t", $level);
			$nodeXml = '';

			if($node->count()){
				$nodeXml .= $this->asNiceXML($node, $level + 1);
				$nodeXml .= "\n" . $indent;
			} else {
				$nodeXml .= htmlspecialchars($node);
			}

			if($nodeXml === ''){
				$nodeXml = '<' . $node->getName() . '/>';
			} else {
				$nodeXml = '<' . $node->getName() . '>' . $nodeXml . '</' . $node->getName() . '>';
			}

			$xml .= "\n" . $indent . $nodeXml;
		}

		//add root element
		if($level === 1){
			$name = $element->getName();
			$xml = "<?xml version=\"1.0\"?>\n<$name>$xml\n</$name>";
		}

		return $xml;
	}

	public function insertXmlElement($xmlElem, $tagName = null){
		if ($xmlElem->children()->count() > 0) {
			$node = $this->addChild($tagName ?: $xmlElem->getName());
			foreach($xmlElem->children() as $child) {
				$node->insertXmlElement($child);
			}
		} else {
			$node = $this->addChild($xmlElem->getName(), $xmlElem);
		}
		foreach($xmlElem->attributes() as $name => $value) $node->addAttribute($name, $value);
		return $node;
	}

	public function insertXmlString($xml, $replaceRootTag = null){
		//don't use __CLASS__ coz it may contain parent value instead of $this if class is extended
		$class = get_class($this);
		$xmlElem = new $class($xml);
		return $this->insertXmlElement($xmlElem, $replaceRootTag);
	}

	public function insertXmlFile($filename, $replaceRootTag = null){
		$xml = file_get_contents($filename);
		return $this->insertXmlString($xml, $replaceRootTag);
	}

	public function insertArray($name, $array, $currNode = null) {
		if(is_null($currNode)) $currNode = $this;
		$arrayNode = $currNode->addChild($name);
		foreach ($array as $key => $value) {
			// is_numeric($key) - may be it is better to check if first symbol is digit?
			$arrayTag = is_numeric($key) ? "item$key" : $key;
			if($value instanceof \ArrayObject || gettype($value) == 'array') {
				$currNode->insertArray($arrayTag, $value, $arrayNode);
			} else {
				$arrayNode->addChild($arrayTag, $value);
			}
		}
	}

}