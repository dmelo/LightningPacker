<?php

class Zend_View_Helper_LightningPackerLink extends Zend_View_Helper_HeadLink
{
    public function toString($indent = null)
    {
	$domain = Zend_Registry::get('domain');
        $items = array();
        $this->getContainer()->ksort();
	$ret = $domain . '/packit.php?type=css';
	$first  = true;
	foreach ($this as $item) {
	    $item = (array) $item;
	    $ret .= "&obj[]=" . $item['href'];
	}

	return "<link href=\"$ret\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\" />";
    }


    public function lightningPackerLink(array $attributes = null, $placement = Zend_View_Helper_Placeholder_Container_Abstract::APPEND) 
    {
	parent::headLink($attributes, $placement);
	return $this;
    }
}
