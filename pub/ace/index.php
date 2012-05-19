<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
//header('Content-type: text/plain');

define('PUB_DIR', __DIR__.'/');
define('ACE_DIR', realpath(PUB_DIR.'../../ace').'/');
define('ACE_IDE_DIR', ACE_DIR . '/ide/');

require_once ACE_IDE_DIR . 'init.php';

require_once ACE_IDE_DIR . 'router/dispatch.php';
