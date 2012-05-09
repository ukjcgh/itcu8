<?php

function html($str){
	return htmlspecialchars($str);
}

function xpath_escape_var($var){
	if(strpos($var, '"') !== false) {
		$escaped = preg_replace('~("+)~', '",\'$1\',"', $var);
		$escaped = 'concat("' . $escaped . '")';
	} else {
		$escaped = "'$var'";
	}
	return $escaped;
}

function templateXSL($xslFile, $xmlElem = null) {

	if(is_null($xmlElem)) $xmlElem = new AceXMLElement('<data/>');

	$xslProc = new XSLTProcessor();

	// use simplexml_load_string coz faster
	$xsltElem = simplexml_load_string(file_get_contents(TPL_DIR . $xslFile), 'AceXMLElement');

	$outputNode = $xsltElem->addChild('output');
	$outputNode->addAttribute('method', 'html');

	$xslProc->importStylesheet($xsltElem);

	return $xslProc->transformToXml($xmlElem);

}

function aceAutoload($className){
	include ACE_DIR.'ide'.DS.str_replace('\\', DS, $className . '.php');
}

function ace_json($data, $options = null){
	//convert objects to string
	ace_json_prepare_data($data);
	return json_encode($data, $options);
}

function ace_json_prepare_data(&$data){
	if(is_iterable($data)){
		if(is_block($data)){
			$data = (string)$data;
		} else {
			foreach ($data as $k=>&$v){
				ace_json_prepare_data($v);
			}
		}
	} else {
		$data = (string)$data;
	}
}

function is_block($obj){
	return ($obj instanceof \data\box && $obj->hand() instanceof \blocks\master);
}

function is_iterable($var){
	return is_array($var) || is_object($var);
}

spl_autoload_register('aceAutoload');

function box($handClass, $returnHand = false){
	$hand = new $handClass();
	if(!is_a($hand, 'data\hand')){
		trigger_error('Can\'t create box, "'.$handClass.'" should be an instance of \data\hand', E_USER_ERROR);
	}
	return $returnHand ? $hand : $hand->box();
}
