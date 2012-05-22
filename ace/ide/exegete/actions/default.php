<?php

// structure
$page = object('blocks\page');
$page->head = object('blocks\page\head');
$page->body = object('blocks\grid');

// content
$page->doctype = 'html';
$page->head->title = "TTITLEE";

$page->head->styles = array(
		'styles.css',
		'popup.css',
);
$page->head->scripts = array(
		'base.js',
		'checkua.js',
		'server.js',
		'popup.js',
		'grid.js',
);

$response->html = $page;