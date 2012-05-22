<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
//header('Content-type: text/plain');

require_once '../../ace/ide/init.php';

single('router')->dispatch();
