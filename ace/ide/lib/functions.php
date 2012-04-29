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
	$xsltElem = simplexml_load_string(file_get_contents(XSLT_DIR . $xslFile), 'AceXMLElement');

	$outputNode = $xsltElem->addChild('output');
	$outputNode->addAttribute('method', 'html');
	// 	$outputNode->addAttribute('omit-xml-declaration', 'yes');
	// 	$outputNode->addAttribute('indent', 'no');

	$xslProc->importStylesheet($xsltElem);

	return $xslProc->transformToXml($xmlElem);

}

function aceAutoload($className){
	include ACE_DIR.'ide/'.str_replace('_', '/', $className . '.php');
}

spl_autoload_register('aceAutoload');

