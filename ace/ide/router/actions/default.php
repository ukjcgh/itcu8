<?php

//struct
$page = newBlock('\blocks\page');
$page->head = newBlock('\blocks\page\head');
$page->body = newBlock('\blocks\grid');

//filling
$page->doctype = 'html';
$page->head->title = "TTITLEE";
$page->head->styles[] = 'styles.css';
$page->head->styles[] = 'popup.css';
$page->head->scripts[] = 'jquery-1.7.2.min.js';
$page->head->scripts[] = 'aceHelper.js';
$page->head->scripts[] = 'aceMain.js';
$page->head->scripts[] = 'ace.js';
$page->head->scripts[] = 'popup.js';
$page->head->scripts[] = 'grid.js';

$response->html = $page;