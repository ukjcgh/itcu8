<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
//header('Content-type: text/plain');

define('ACE_DIR', '../../ace/');
define('TEMPLATE_DIR', ACE_DIR.'templates/');
define('XSLT_DIR', ACE_DIR.'xslt/');

require_once ACE_DIR.'AceXMLElement.php';
require_once ACE_DIR.'lib/functions.php';

$model = 'areas.xml';
$data = new AceXMLElement('<data/>');
$modelConfig = new AceXMLElement(ACE_DIR.'ide/'.$model, 0, true);
$data->insertXmlElement($modelConfig->grid);
$data->insertXmlFile(ACE_DIR.$model, 'items');

echo templateXSL('areas.xsl', $data);

//how to escape in xsl