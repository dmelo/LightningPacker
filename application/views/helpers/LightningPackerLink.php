<?php

require_once('LightningPacker.php');

class Zend_View_Helper_LightningPackerLink extends Zend_View_Helper_HeadLink
{
    public function toString($indent = null)
    {
        $this->getContainer()->ksort();
	$bag = array();

	foreach($this as $item) {
	    $item = (array) $item;
	    $bag[] = $item['href'];
	}

	return lightningPacker($bag, 'css');
    }


    public function lightningPackerLink(array $attributes = null, $placement = Zend_View_Helper_Placeholder_Container_Abstract::APPEND) 
    {
	parent::headLink($attributes, $placement);
	return $this;
    }
}
