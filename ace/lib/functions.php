<?php


function html($str){ return htmlspecialchars($str); }

function template($templateFile, $vars = array()){
	extract($vars);
	ob_start();
	include TEMPLATE_DIR . $templateFile;
	return ob_get_clean();
}

function templateXSL($xsl, $xml){
	$xslProc = new XSLTProcessor();
	$xslt_string = new SimpleXMLElement(file_get_contents($xsl));
	$xslt->importStylesheet($xslt_string);
	
	$xml = new DOMDocument;
	$xml->load('xml.xml');
	
	return $xslProc->transformToXml($xml);
}