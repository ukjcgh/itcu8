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

// $stringify_exceptions: add get_class($this) in __toString to avoid recursion, like in Response class
function ace_json($data, $stringify_exceptions = null, $options = null){
	// use stop_recursion coz php falls without error
	stop_recursion(__FUNCTION__, 6, 'Try to add exception by second parameter.');
	$stringify_exceptions = (array)$stringify_exceptions;
	stringify_objects($data, $stringify_exceptions);
	return json_encode($data, $options);
}

//convert objects to string
function stringify_objects(&$data, $exceptions){
	if(is_iterable($data)){
		if(is_callable(array($data, '__toString')) && !stringify_exception($data, $exceptions)){
			$data = (string)$data;
		} else {
			foreach ($data as $k=>&$v){
				stringify_objects($v, $exceptions);
			}
		}
	}
}

function stringify_exception($object, $exceptions){
	if($object instanceof \data\box) $object = $object->hand();
	return in_array(get_class($object), $exceptions);
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

//TODO: improve to work with class method
function stop_recursion($funcname, $limit, $msg = ''){
	$backtrace = debug_backtrace(false);
	$calls = 0;
	foreach ($backtrace as $point){
		if($point['function'] == $funcname){
			$calls++;
			if($calls > $limit){
				trigger_error('Recursion for "'.$funcname.'" detected (limit of '.$limit.' times is exceeded). '.$msg." File {$point['file']}, line {$point['line']}\n", E_USER_ERROR);
			}
		}
	}
}
