<?php

abstract class block_abstract {

	public function __toString() {
		return templateXSL($this->getTemplateFileName(), $this->getXslData());
	}

	public function getTemplateFileName(){
		$className = get_class($this);
		$blockName = substr($className, strpos($className, '_') + 1);
		$blockPath = str_replace('_', '/', $blockName);
		return $blockPath . '.xsl';
	}

}
