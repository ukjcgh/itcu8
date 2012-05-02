<?php

$request = new Request;

$action_filename = IDE_DIR . 'app' . DS . 'actions' . DS . $request->action . '.php';

if(is_readable($action_filename)) {
	include $action_filename;
} else {
	trigger_error('Action "' . $action_filename . '" Not Found', E_USER_ERROR);
}
