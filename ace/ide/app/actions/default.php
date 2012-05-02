<?php

//struct
$page = new \blocks\page;
$page->head = new \blocks\page\head;
$page->body = new \blocks\grid;

//filling
$page->doctype = 'html';
$page->head->title = "TTITLEE";
$page->head->styles[] = 'styles.css';
$page->head->styles[] = 'popup.css';
$page->head->scripts[] = 'jquery-1.7.2.min.js.invalid';
$page->head->scripts[] = 'aceHelper.js';
$page->head->scripts[] = 'aceMain.js';
$page->head->scripts[] = 'ace.js';
$page->head->scripts[] = 'popup.js';
$page->head->scripts[] = 'grid.js';

echo $page;