<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
header('Content-type: text/plain');

define('ACE_DIR', '../../ace/');
define('TEMPLATE_DIR', ACE_DIR.'templates/');
define('XSLT_DIR', ACE_DIR.'xslt/');

require_once ACE_DIR.'AceXMLElement.php';
require_once ACE_DIR.'lib/functions.php';
require_once ACE_DIR.'XslFastLoader.php';


$model = 'areas.xml';
$data = new AceXMLElement('<data/>');
$modelConfig = new AceXMLElement(ACE_DIR.'ide/'.$model, 0, true);
$data->insertXmlElement($modelConfig->grid);
$data->insertXmlFile(ACE_DIR.$model, 'items');
$xslProc = new XSLTProcessor();
$fileContent = file_get_contents(XSLT_DIR . 'areas.xsl');
$xsltElem = simplexml_load_string($fileContent);
$start = microtime(true);
for($i = 0; $i<200000; $i++){
	//$echo = templateXSL('areas.xsl', $data);
	//$xsltElem = new AceXMLElement(XSLT_DIR . 'areas.xsl', 0, true);
	//$xsltElem = simplexml_load_file(XSLT_DIR . 'areas.xsl', 'AceXMLElement');

	//$xsltElem = new DOMDocument; $xsltElem->loadXML($fileContent);
	//$xslLoader = new XslFastLoader;	$xsltElem = $xslLoader->load(XSLT_DIR.'areas.xsl');
	//$xslProc->importStylesheet($xsltElem);
	//$fileContent = file_get_contents(XSLT_DIR . 'areas.xsl');
	$xsltElem = simplexml_load_string($fileContent);
	
	//$xslProc->transformToXml($data);
	
}
echo microtime(true)-$start;
//5.47 without file loading
//12.8 with file loading
//*/

/*
$model = 'areas.xml';
$modelData = new AceXMLElement(ACE_DIR.$model, 0 , true);
$modelConfig = new AceXMLElement(ACE_DIR.'ide/'.$model, 0 , true);

$templateFile = 'areas_test.phtml';
$vars = array('data'=>$modelData, 'config'=>$modelConfig);
extract($vars);
$tplCode = file_get_contents(TEMPLATE_DIR . $templateFile);
$start = microtime(true);
$file_load_time = 0;
for($i = 0; $i<20000; $i++){
	//$echo = template('areas_test.phtml', array('data'=>$modelData, 'config'=>$modelConfig));
	ob_start();
	//$tplCode = file_get_contents(TEMPLATE_DIR . $templateFile);
	//include TEMPLATE_DIR . $templateFile;
	eval('?'.'>'.$tplCode);
	$return =  ob_get_clean();
}
echo microtime(true)-$start;
//2.09 without file loading
//9.27 with file loading (the same if use include)
//*/



//how to escape in xsl
//is xsl faster than php?
//check php vs xslt speen on linux

/*
 * XSL: safe, supported by browser and server, possible output raw xml
 * but: slower, not convenient
 */


