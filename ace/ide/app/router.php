<?php

$action = isset($_GET['action']) ? $_GET['action'] : 'default';
 
if(preg_match('~[^a-z]~', $action)){
	trigger_error('Invalid action name', E_USER_ERROR);
}

$action_filename = ACE_DIR.'ide'.DS.'app'.DS.'actions'.DS.$action.'.php';

if(is_readable($action_filename)) {
	include $action_filename;
} else {
	trigger_error('Action "'.$action_filename.'" Not Found', E_USER_ERROR);
}
