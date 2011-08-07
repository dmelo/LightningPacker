<?php

class Zend_View_Helper_LightningPackerScript extends Zend_View_Helper_HeadScript
{
    public function toString($indent = null)
    {
        $this->getContainer()->ksort();
        $items = array();

	foreach($this as $item)
	    $bag[] = $item->attributes['src'];

	return lightningPacker($bag, 'js');
    }


    public function lightningPackerScript($mode = Zend_View_Helper_HeadScript::FILE, $spec = null, $placement = 'APPEND', array $attrs = array(), $type = 'text/javascript') 
    {
	parent::headScript($mode, $spec, $placement, $attrs, $type);
	return $this;
    }
}
