<?php


function html($str){ return htmlspecialchars($str); }

function template($templateFile, $vars = array()){
	extract($vars);
	ob_start();
	include TEMPLATE_DIR . $templateFile;
	return ob_get_clean();
}

function templateXSL($xslFile, $xmlElem){
	$xslProc = new XSLTProcessor();
	$xsltElem = new AceXMLElement(XSLT_DIR . $xslFile, 0, true);
	$xslProc->importStylesheet($xsltElem);
	return $xslProc->transformToXml($xmlElem);
}