<?php
// NOT FASTER!!!
class XslFastLoader {
	protected $xmlElem = false;
	protected $parents = array();

	public function load($filename){
		$xp = xml_parser_create();
		xml_parser_set_option($xp, XML_OPTION_CASE_FOLDING, false);
		xml_set_element_handler($xp, array($this, 'start_element'), array($this, 'end_element'));
		//xml_set_character_data_handler($xp, array($this, 'element_content'));
		$xml = file_get_contents($filename);
		xml_parse($xp, $xml);
		xml_parser_free($xp);
		return $this->xmlElem;
	}

	protected function start_element($parser, $name, $attribs){
		if($this->xmlElem === false){
			$this->parents[] = $this->xmlElem = new AceXMLElement('<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://nons.com"/>');
		} else {
			$parent = end($this->parents)->addChild($name, null, strpos($name, ':') === false ? 'http://nons.com' : 'http://www.w3.org/1999/XSL/Transform');
			foreach($attribs as $k=>$v)	$parent->addAttribute($k, $v);
			$this->parents[] = $parent;
		}
	}
	function end_element($parser, $name){
		array_pop($this->parents);
	}

	// 	function element_content($parser, $text){}
}
