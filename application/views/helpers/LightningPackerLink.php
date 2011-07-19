<?php

class Zend_View_Helper_LightningPackerLink extends Zend_View_Helper_HeadLink
{
    public function toString($indent = null)
    {
	$domain = Zend_Registry::get('domain');
        $items = array();
        $this->getContainer()->ksort();

	$concat = '';
	foreach($this as $item) {
	    $item = (array) $item;
	    $concat .= $item['href'];
	}
	$hash = md5($concat);
	$hashFile = '/tmp/' . $hash . '-lp';

	$ret = "<link rel=\"stylesheet\" type=\"text/css\" href=\"${domain}/get.php?hash=${hash}&type=css\"></script>";
	if(!file_exists($hashFile)) {
	    $buildUrl = $domain . '/packit.php?type=css';
	    $first  = true;
	    foreach ($this as $item) {
		$item = (array) $item;
		$buildUrl .= "&obj[]=" . urlencode($item['href']);
	    }
	    file_get_contents($buildUrl);
	    echo '<!-- ' . $buildUrl . '-->';
	    $fd = fopen($hashFile, 'w');
	    fclose($fd);
	}

	return $ret;




	$domain = Zend_Registry::get('domain');
        $items = array();
        $this->getContainer()->ksort();
	$ret = $domain . '/packit.php?type=css';
	$first  = true;
	foreach ($this as $item) {
	    $item = (array) $item;
	    $ret .= "&obj[]=" . urlencode($item['href']);
	}

	return "<link href=\"$ret\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\" />";
    }


    public function lightningPackerLink(array $attributes = null, $placement = Zend_View_Helper_Placeholder_Container_Abstract::APPEND) 
    {
	parent::headLink($attributes, $placement);
	return $this;
    }
}
