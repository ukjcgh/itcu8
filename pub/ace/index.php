<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
//header('Content-type: text/plain');

define('DS', DIRECTORY_SEPARATOR);
define('ACE_DIR', realpath('..' . DS . '..' . DS . 'ace') . DS);
define('IDE_DIR', ACE_DIR . 'ide' . DS);
define('TPL_DIR', IDE_DIR . 'templates' . DS);

require_once IDE_DIR . 'lib' . DS . 'functions.php';
require_once IDE_DIR . 'lib' . DS . 'AceXMLElement.php';

require_once IDE_DIR . 'app' . DS . 'dispatch.php';
