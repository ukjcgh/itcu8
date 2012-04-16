<?php

function templateXSL($xslFile, $xmlElem) {
	
	$xslProc = new XSLTProcessor();
	
	//use simplexml_load_string coz faster
	$xsltElem = simplexml_load_string(file_get_contents(XSLT_DIR . $xslFile), 'AceXMLElement');
	
	$outputNode = $xsltElem->addChild('output');
	$outputNode->addAttribute('method', 'html');
	$outputNode->addAttribute('indent', 'no');
	
	$xslProc->importStylesheet($xsltElem);
	
	return $xslProc->transformToXml($xmlElem);
	
}