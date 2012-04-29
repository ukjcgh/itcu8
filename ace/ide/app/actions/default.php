<?php

//struct
$page = new block_page;
$page->head = new block_page_head;
$page->body = new block_grid;

//filling
$page->doctype = 'html';
$page->head->title = "TTITLEE";
$page->head->styles[] = 'styles.css';
$page->head->styles[] = 'popup.css';
$page->head->scripts[] = 'jquery-1.7.2.min.js.invalid';
$page->head->scripts[] = 'ace.js';
$page->head->scripts[] = 'popup.js';
$page->head->scripts[] = 'grid.js';

echo $page;