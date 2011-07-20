<?php

/**
 * Gather all scripts on a html tag to call the proper LightningPacker script.
 *
 * @param $obj Array with the scripts names.
 * @param $type Script type, can be either 'js' or 'css'.
 *
 * @return Returns the html tag to call the script package.
 */
function lightningPacker($obj, $type)
{
    $hash = md5(implode('', $obj));
    $filename = "/tmp/${hash}-lp";
    if(!file_exists($filename)) {
	$url = "http://lightningpacker.net/packit.php?type=${type}";
	foreach($obj as $src)
	    $url .= '&obj[]=' . urlencode($src);
	file_get_contents($url);
	$fd = fopen($filename, 'w');
	fclose($fd);
    }

    $url = "http://lightningpacker.net/get.php?hash=${hash}&type=${type}";
    if('css' === $type) 
	$ret = "<link rel=\"stylesheet\" type=\"text/css\" href=\"${url}\" />";
    elseif('js' === $type)
	$ret = "<script type=\"text/javascript\" src=\"${url}\"></script>";

    return $ret;
}
