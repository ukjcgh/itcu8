<?php

class AceXMLElement extends SimpleXMLElement {

	//TODO: <emptyNode/>, attributes
	public function asNiceXML($element = null, $level = 1) {

		$xml = '';
		if(is_null($element)) $element = $this;
		foreach ($element as $node){
			$indent = str_repeat("\t", $level);
			$xml .= "\n$indent<" . $node->getName() . '>';
			if($node->count()){
				$xml .= $this->asNiceXML($node, $level + 1);
				$xml .= "\n$indent";
			} else {
				$xml .= htmlspecialchars($node);
			}
			$xml .= '</' . $node->getName() . '>';
		}

		//wrap
		if($level === 1){
			$xml = "<?xml version=\"1.0\"?>\n<ace>$xml\n</ace>";
		}

		return $xml;
	}

	public function addChild($name, $value = null, $namespace = null) {
		if ($value instanceof AceXMLElement) {
			if ($value->children()->count() > 0) {
				$node = parent::addChild($name);
				foreach($value->children() as $child) {
					$node->addChild($child->getName(), $child);
				}
			} else {
				$node = parent::addChild($value->getName(), $value);
			}
			foreach($value->attributes() as $n => $v) $node->addAttribute($n, $v);
			return $node;
		} else {
			return parent::addChild($name, $value, $namespace);
		}
	}

}