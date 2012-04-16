<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

define('ACE_DIR', '../../ace/');
define('XSLT_DIR', ACE_DIR.'ide/xslt/');

require_once ACE_DIR.'lib/functions.php';
require_once ACE_DIR.'lib/AceXMLElement.php';

$model = 'areas.xml';
$data = new AceXMLElement('<data/>');
$modelConfig = new AceXMLElement(ACE_DIR.'ide/'.$model, 0, true);
$data->insertXmlElement($modelConfig->grid);
$data->insertXmlFile(ACE_DIR."engine/$model", 'items');

echo templateXSL('areas.xsl', $data);