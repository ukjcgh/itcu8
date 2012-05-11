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
	if(!is_readable(ACE_DIR.'ide'.DS.str_replace('\\', DS, $className . '.php'))){
		var_dump(debug_backtrace(false)); exit;
	}
	include ACE_DIR.'ide'.DS.str_replace('\\', DS, $className . '.php');
}

function stringify_objects(&$data){
	if(is_iterable($data)){
		if(is_callable(array($data, '__toString'))){
			$data = (string)$data;
		} else {
			foreach ($data as $k=>&$v){
				stringify_objects($v);
			}
		}
	}
}

function is_iterable($var){
	return is_array($var) || is_object($var);
}

spl_autoload_register('aceAutoload');


function o($class){
	$o = new $class();
	if(is_a($o, 'data\hand')){
		/*
		 * data<->hand
		* - it is convenient to work directly with data using ->, especially in case of blocks
		* - no conflicts with internal class props
		* - better performance than magic methods
		*/
		return $o->data();
	}
	return $o;
}
