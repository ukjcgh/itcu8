<?php

define('IDE_DIR', __DIR__.'/');
define('APP_DIR', IDE_DIR . '../app/');
define('IDE_LIB_DIR', IDE_DIR . 'lib/');

require_once IDE_DIR . 'functions.php';

spl_autoload_register('aceAutoload');

require_once IDE_LIB_DIR . 'data.php';
require_once IDE_LIB_DIR . 'data/hand.php';
require_once IDE_LIB_DIR . 'object/property.php';
require_once IDE_LIB_DIR . 'AceXMLElement.php';
require_once IDE_LIB_DIR . 'Request.php';
require_once IDE_LIB_DIR . 'Response.php';

\blocks\master::$TPL_DIR = IDE_DIR . 'templates/';