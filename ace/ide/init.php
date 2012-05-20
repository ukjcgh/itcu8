<?php

define('IDE_DIR', __DIR__.'/');

require_once IDE_DIR . 'functions.php';

set_include_path(
		get_include_path()
		. PATH_SEPARATOR . IDE_DIR . 'exegete'
		. PATH_SEPARATOR . IDE_DIR . 'helper'
);

spl_autoload_register(function($className){
	include str_replace('\\', '/', $className . '.php');
});

\blocks\master::$TPL_DIR = IDE_DIR . 'config/templates/';

define('APP_DIR', realpath(IDE_DIR . '../app').'/');
