<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
//header('Content-type: text/plain');

define('DS', DIRECTORY_SEPARATOR);
define('ACE_DIR', realpath('..'.DS.'..'.DS.'ace').DS);
define('TPL_DIR', ACE_DIR.'ide'.DS.'templates'.DS);

require_once ACE_DIR.'ide'.DS.'lib'.DS.'functions.php';
require_once ACE_DIR.'ide'.DS.'lib'.DS.'AceXMLElement.php';

require_once ACE_DIR.'ide'.DS.'app'.DS.'router.php';
