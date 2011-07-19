<?php

class Zend_View_Helper_LightningPackerScript extends Zend_View_Helper_HeadScript
{
    public function toString($indent = null)
    {
	$domain = Zend_Registry::get('domain');
        $items = array();
        $this->getContainer()->ksort();

	$concat = '';
	foreach($this as $item)
	    $concat .= $item->attributes['src'];
	$hash = md5($concat);
	$hashFile = '/tmp/' . $hash . '-lp';

	$ret = "<script type=\"text/javascript\" src=\"${domain}/get.php?hash=${hash}&type=js\"></script>";
	if(!file_exists($hashFile)) {
	    $buildUrl = $domain . '/packit.php?type=js';
	    $first  = true;
	    foreach ($this as $item) {
		$buildUrl .= "&obj[]=" . urlencode($item->attributes['src']);
	    }
	    file_get_contents($buildUrl);
	    echo '<!-- ' . $buildUrl . '-->';
	    $fd = fopen($hashFile, 'w');
	    fclose($fd);
	}

	return $ret;
    }


    public function lightningPackerScript($mode = Zend_View_Helper_HeadScript::FILE, $spec = null, $placement = 'APPEND', array $attrs = array(), $type = 'text/javascript') 
    {
	parent::headScript($mode, $spec, $placement, $attrs, $type);
	return $this;
    }
}
