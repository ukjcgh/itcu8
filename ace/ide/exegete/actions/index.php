<?php

// structure
$page = object('blocks\page');
$page->head = object('blocks\page\head');
//$page->body = object('blocks\grid');

// content
$page->doctype = 'html';
$page->head->title = "Exegete";

$page->head->styles = array(
		'styles.css',
		'popup.css',
);
$page->head->scripts = array(
		'checkua.js',
		'lib/base.js',
		'lib/server.js',
		'lib/xml.js',
		'popup.js',
		'grid.js',
		'index.js',
);

$response->html = $page;