<?php

define('LP_BASE', 'http://lighteningpacker.localhost/packit.php?type=css');

class Zend_View_Helper_LightningPackerLink extends Zend_View_Helper_HeadLink
{
    public function toString($indent = null)
    {
        $items = array();
        $this->getContainer()->ksort();
	$ret = LP_BASE;
	$first  = true;
	foreach ($this as $item) {
	    $ret .= "&obj[]=" . $item->attributes['src'];
	}

	return "<link href=\"$ret\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\" />";
    }


    public function lightningPackerLink(array $attributes = null, $placement = Zend_View_Helper_Placeholder_Container_Abstract::APPEND)
}