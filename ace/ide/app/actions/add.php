<?php

$form = new block_grid_form;
$modelConfig = new AceXMLElement(ACE_DIR.'ide/config/websites.xml', 0, true);
$form->config = $modelConfig->forms->add;
echo $form;
