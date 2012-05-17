<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
//header('Content-type: text/plain');

define('DS', DIRECTORY_SEPARATOR);
define('PUB_DIR', __DIR__ . DS);
define('ACE_DIR', realpath(PUB_DIR . '..' . DS . '..' . DS . 'ace') . DS);
define('ACE_IDE_DIR', ACE_DIR . DS . 'ide' . DS);

require_once ACE_IDE_DIR . 'init.php';

require_once ACE_IDE_DIR . 'router' . DS . 'dispatch.php';
