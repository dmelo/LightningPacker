<?php

class Zend_View_Helper_Download extends Zend_View_Helper_Abstract
{
    public function download($files)
    {
	$info = array();
	$ret = '<table><thead><tr class="topic"><th>File</th><th>Date</th><th>md5</th></tr></thead><tbody>';
	foreach($files as $file) {
	    $path = $file['path'];
	    $filename = $file['filename'];
	    $filepath = "${path}/${filename}";
	    $info['md5'] = md5_file($filepath);
	    $info['name'] = $filename;
	    $info['date'] = date('Y-m-d H:i:s', filemtime($filepath));
	    $info['href'] = $filepath;

	    $ret .= '<tr><td><a href="' . $info['href'] . '">' . $info['name'] . '</a></td><td>' . $info['date'] . '</td><td>' . $info['md5'] . '</td></tr>';
	}

	$ret .= '</tbody></table>';

	return $ret;
    }
}
