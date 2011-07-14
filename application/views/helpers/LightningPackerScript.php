<?php

define('LP_BASE', 'http://lightningpacker.localhost/packit.php');

class Zend_View_Helper_LightningPackerScript extends Zend_View_Helper_HeadScript
{
    public function toString($indent = null)
    {
        $items = array();
        $this->getContainer()->ksort();
	$ret = LP_BASE . '?type=js';
	$first  = true;
	foreach ($this as $item) {
	    $ret .= "&obj[]=" . $item->attributes['src'];
	}

	return "<script type=\"text/javascript\" src=\"$ret\"></script>";
    }


    public function lightningPackerScript($mode = Zend_View_Helper_HeadScript::FILE, $spec = null, $placement = 'APPEND', array $attrs = array(), $type = 'text/javascript') 
    {
	parent::headScript($mode, $spec, $placement, $attrs, $type);
	return $this;
    }
}
