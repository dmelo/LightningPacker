<?php

/**
 * Packs the given script accordenly with specified parameters and cache it for further use.
 *
 * @author Diogo Oliveira de Melo
 */

error_reporting(E_ALL);
$start = microtime(true);

define('CACHE_DIR', 'tmp/');
define('DEFAULT_EXPIRATION', 30 * 24 * 60 * 60);
$fdomain = fopen('domain.txt', 'r');
fscanf($fdomain, " %s ", $domain);
fclose($fdomain);

/**
 * Write content on disk for later use.
 *
 * @param $key File name or concatenation of the file names.
 * @param $value Content to be written.
 *
 * @return Return true if written occurs normally, false otherwise.
 */
function setCache($key, $value, $expire = DEFAULT_EXPIRATION)
{
    $ret = true;

    // Set cache on disk.
    if(($fd = fopen(CACHE_DIR . md5($key), 'w')) != false) {
	$ret = true;
	fwrite($fd, $value);
	fclose($fd);
    }
    else
	$ret = false;

    return $ret;
}

/**
 * Get the content that represents the file set given.
 *
 * @param $fileSet Set of files.
 * @param $type File type, it can be either js or css.
 *
 * @return Returns an array with the file set content as first argument and timestamp termination of it's cache as second argument
 */
function getFileSet($fileSet, $type = 'js') 
{
    global $domain;

    $key = implode('', $fileSet);
    $ret = '';
    foreach($fileSet as $file) {
	$fileInfo = file_get_contents($file);
	if('js' === $type)
	    $ret .= PHP_EOL . ';' . PHP_EOL . $fileInfo;
	else
	    $ret .= PHP_EOL . $fileInfo;
    }


    $filename = md5($key) . '---internal.' . $type;
    $fd = fopen(CACHE_DIR . $filename, 'w');
    fwrite($fd, $ret);
    fclose($fd);
    $ret = file_get_contents("${domain}/minify/index.php?k=//tmp/${filename}");

    setCache($key, $ret);
    system('cd ' . CACHE_DIR .  '; ln -s ' . md5($key) . ' ' . md5($key) . '.' . $type);

    return $ret;
}

if(!array_key_exists('type', $_GET) || !array_key_exists('obj', $_GET) || !in_array($_GET['type'], array('css', 'js'))) {
    echo 'Error: arguments missing. Consult the documentation and formulate a proper request.' . PHP_EOL;
}
else {
    switch($_GET['type']) {
	case 'css':
	    $header = 'text/css';
	    break;
	case 'js':
	    $header = 'text/javascript';
	    break;
    }

    header("Content-type:  $header");
    header("Cache-Control: max-age=604800, must-revalidate");
    header("Expires: ".gmdate("D, d M Y H:i:s", time() + DEFAULT_EXPIRATION)."GMT");
    echo getFileSet($_GET['obj'], $_GET['type']);
}
