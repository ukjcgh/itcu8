<?php

define('ACE_TPL_DIR', ACE_IDE_DIR . 'templates/');
define('ACE_LIB_DIR', ACE_IDE_DIR . 'lib/');

require_once ACE_IDE_DIR . 'functions.php';

spl_autoload_register('aceAutoload');

require_once ACE_LIB_DIR . 'data.php';
require_once ACE_LIB_DIR . 'data/hand.php';
require_once ACE_LIB_DIR . 'object/property.php';
require_once ACE_LIB_DIR . 'AceXMLElement.php';
require_once ACE_LIB_DIR . 'Request.php';
require_once ACE_LIB_DIR . 'Response.php';