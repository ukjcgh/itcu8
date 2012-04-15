<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/plain');

define('ACE_DIR', '../../ace/');
define('XSLT_DIR', ACE_DIR.'xslt/');
ini_set('max_execution_time',300);

require_once ACE_DIR.'AceXMLElement.php';
require_once ACE_DIR.'XslFastLoader.php';


// $xslLoader = new xslFastLoader;
//$xmlElem = $xslLoader->load(XSLT_DIR.'areas.xsl');
// echo $xmlElem->asXml();

function genXmlElem($xmlObj, $curr = null, $parentName = null){
	static $newXmlElem;
	if(is_null($newXmlElem)) $curr = $newXmlElem = new SimpleXMLElement('<data/>');
	
	foreach($xmlObj as $prop=>$value){
		if(is_object($value)){
			genXmlElem($value, $curr->addChild($parentName ?: $prop));
		} elseif(is_array($value)){
			genXmlElem($value, $curr, $prop);
		} else {
			$curr->addChild($parentName ?: $prop, htmlspecialchars($value));
		}
	}
	$res = $newXmlElem;
	$newXmlElem = null;
	return $res;
}




$fileContent = file_get_contents(ACE_DIR.'ide/areas.xml');
$xmlElem = simplexml_load_string($fileContent);

$xmlObj = json_decode(json_encode($xmlElem));
$fileContent2 = serialize($xmlObj);
$xmlElem = genXmlElem(unserialize($fileContent2));


$start = microtime(true);
for($i = 0; $i<560000; $i++){
	//10sec for ide/areas.xml
	//$xsltElem = simplexml_load_string($fileContent);
	
	//100sec
	//$xmlElem = genXmlElem(unserialize($fileContent2));
}
echo microtime(true)-$start;



