<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
//header('Content-type: text/plain');

define('ACE_DIR', '../../ace/');
define('TEMPLATE_DIR', ACE_DIR.'templates/');
define('XSLT_DIR', ACE_DIR.'xslt/');

require_once ACE_DIR.'AceXMLElement.php';
require_once ACE_DIR.'lib/functions.php';

// $model = 'areas.xml';
// $modelConfig = simplexml_load_file(ACE_DIR.'ide/'.$model, 'AceXMLElement');
// $modelData = simplexml_load_file(ACE_DIR.$model, 'AceXMLElement');

// echo template('areas.phtml', array('config'=>$modelConfig, 'data'=>$modelData));

$model = 'areas.xml';
$data = simplexml_load_string('<data/>');
//$data->addChild('items', simplexml_load_file(ACE_DIR.$model));
// print_r(new SimpleXMLElement(file_get_contents(ACE_DIR.$model))); exit;
// $data->itemsss = new SimpleXMLElement(file_get_contents(ACE_DIR.$model));
//$data->itemsss = new SimpleXMLElement('');
 $data = simplexml_load_file(ACE_DIR.$model, 'AceXMLElement');
var_dump($data);
$testNode = new AceXMLElement(file_get_contents(ACE_DIR.$model));
$data->addChild($testNode->getName(), $testNode);
var_dump($data->asXml());
exit;

echo templateXSL('areas.xsl', $data);