<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
//header('Content-type: text/plain');

define('DS', DIRECTORY_SEPARATOR);
define('ACE_DIR', realpath('..' . DS . '..' . DS . 'ace') . DS);
define('IDE_DIR', ACE_DIR . 'ide' . DS);
define('TPL_DIR', IDE_DIR . 'templates' . DS);
define('LIB_DIR', IDE_DIR . 'lib' . DS);

require_once LIB_DIR . 'functions.php';
require_once LIB_DIR . 'AceXMLElement.php';
require_once LIB_DIR . 'Request.php';

require_once IDE_DIR . 'app' . DS . 'dispatch.php';
