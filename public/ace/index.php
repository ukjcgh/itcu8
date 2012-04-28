<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
//header('Content-type: text/plain');

define('ACE_DIR', '../../ace/');
define('XSLT_DIR', ACE_DIR.'ide/xslt/');

require_once ACE_DIR.'lib/functions.php';
require_once ACE_DIR.'lib/AceXMLElement.php';


$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
	case 'edit':
		$form = new block_grid_form;
		$modelData = new AceXMLElement('<data/>');
		$modelData->insertXmlFile(ACE_DIR."engine/websites.xml", 'items');
		$itemCode = $_POST['code'];
		$result = $modelData->xpath('items/item[./code=' . xpath_escape_var($itemCode) . ']');
		$form->item = $result[0];
		
		$modelConfig = new AceXMLElement(ACE_DIR.'ide/websites.xml', 0, true);
		$form->config = $modelConfig->form;
// 		echo $form->getXslData()->asnicexml();
		echo $form;
		break;
		
	case 'save':
		$modelData = new AceXMLElement(file_get_contents(ACE_DIR."engine/websites.xml"));
		$itemCode = $_POST['code'];
		$result = $modelData->xpath('item[./code=' . xpath_escape_var($itemCode) . ']');
		$item = $result[0];
		
		$modelConfig = new AceXMLElement(ACE_DIR.'ide/websites.xml', 0, true);
		foreach($modelConfig->form->fields->children() as $field=>$stuff) {
 			$item->$field = $_POST[$field];
		}
		
		file_put_contents(ACE_DIR."engine/websites.xml", $modelData->asNiceXml());
		break;

	default:
		//struct
		$page = new block_page;
	$page->head = new block_page_head;
	$page->body = new block_grid;

	//filling
	$page->doctype = 'html';
	$page->head->title = "TTITLEE";
	$page->head->styles[] = 'styles.css';
	$page->head->styles[] = 'popup.css';
	$page->head->scripts[] = 'jquery-1.7.2.min.js';
	$page->head->scripts[] = 'ace.js';
	$page->head->scripts[] = 'popup.js';
	$page->head->scripts[] = 'grid.js';

	echo $page;
	break;
}

