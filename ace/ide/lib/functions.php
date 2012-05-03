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
	// 	$outputNode->addAttribute('omit-xml-declaration', 'yes');
	// 	$outputNode->addAttribute('indent', 'no');

	$xslProc->importStylesheet($xsltElem);

	return $xslProc->transformToXml($xmlElem);

}

function aceAutoload($className){
	include ACE_DIR.'ide'.DS.str_replace('\\', DS, $className . '.php');
}

function ace_json($data, $options = null){
	//convert objects to string
	if($data instanceof \blocks\master){
		$data4json = (string)$data;
	} elseif(is_array($data)) {
		$data4json = array();
		foreach ($data as $k => $v){
			if($v instanceof \blocks\master) $v = (string)$v;
			$data4json[$k] = $v;
		}
	} else {
		return json_encode($data, $options);
	}
	return json_encode($data4json, $options);
}

spl_autoload_register('aceAutoload');

