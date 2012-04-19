<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
//header('Content-type: text/plain');

define('ACE_DIR', '../../ace/');
define('XSLT_DIR', ACE_DIR.'ide/xslt/');

require_once ACE_DIR.'lib/functions.php';
require_once ACE_DIR.'lib/AceXMLElement.php';

//struct
$page = new block_page;
$page->head = new block_page_head;
$page->body = new block_grid;

//filling
$page->doctype = 'html';
$page->head->title = "TTITLEE";
$page->head->styles[] = 'styles.css';
$page->head->scripts[] = 'grid.js';

echo $page;