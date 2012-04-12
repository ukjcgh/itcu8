<?php


function html($str){ return htmlspecialchars($str); }

function template($templateFile, $vars = array()){
	extract($vars);
	ob_start();
	include TEMPLATE_DIR . $templateFile;
	return ob_get_clean();
}