<?php

class AceXMLElement extends SimpleXMLElement {

	//TODO: <emptyNode/>, attributes
	public function asNiceXML($element = null, $level = 1){
		
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
	
}