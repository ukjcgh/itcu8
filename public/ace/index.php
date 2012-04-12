<?php

define('ACE_DIR', '../../ace/');
define('TEMPLATE_DIR', ACE_DIR.'templates/');

require_once ACE_DIR.'AceXMLElement.php';
require_once ACE_DIR.'lib/functions.php';

$model = 'areas.xml';
$modelConfig = simplexml_load_file(ACE_DIR.'ide/'.$model, 'AceXMLElement');
$modelData = simplexml_load_file(ACE_DIR.$model, 'AceXMLElement');

echo template('areas.phtml', array('config'=>$modelConfig, 'data'=>$modelData));

