<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

define('ACE_DIR', '../../ace/');
define('XSLT_DIR', ACE_DIR.'xslt/');

require_once ACE_DIR.'lib/AceXMLElement.php';
require_once ACE_DIR.'lib/functions.php';

$model = 'areas.xml';
$data = new AceXMLElement('<data/>');
$modelConfig = new AceXMLElement(ACE_DIR.'ide/'.$model, 0, true);
$data->insertXmlElement($modelConfig->grid);
$data->insertXmlFile(ACE_DIR.$model, 'items');

echo templateXSL(XSLT_DIR.'areas.xsl', $data);