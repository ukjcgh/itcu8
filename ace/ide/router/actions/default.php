<?php

//struct
$page = o('blocks\page');
$page->head = o('blocks\page\head');
$page->body = o('blocks\grid');

//filling
$page->doctype = 'html';
$page->head->title = "TTITLEE";
$page->head->styles[] = 'styles.css';
$page->head->styles[] = 'popup.css';
$page->head->scripts[] = 'jquery-1.7.2.min.js';
$page->head->scripts[] = 'aceHelper.js';
$page->head->scripts[] = 'aceMain.js';
$page->head->scripts[] = 'ace.js';
$page->head->scripts[] = 'server.js';
$page->head->scripts[] = 'popup.js';
$page->head->scripts[] = 'grid.js';

$response->html = $page;