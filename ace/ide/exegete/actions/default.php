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
$page->head->scripts[] = 'base.js';
$page->head->scripts[] = 'checkua.js';
$page->head->scripts[] = 'server.js';
$page->head->scripts[] = 'popup.js';
$page->head->scripts[] = 'grid.js';

$response->html = $page;