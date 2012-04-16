<?php

function templateXSL($xslFile, $xmlElem){
	$xslProc = new XSLTProcessor();
	//simplexml_load_string coz faster
	$xsltElem = simplexml_load_string(file_get_contents(XSLT_DIR . $xslFile), 'AceXMLElement');
	$xslProc->importStylesheet($xsltElem);
	return $xslProc->transformToXml($xmlElem);
}