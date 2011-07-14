<?php

error_reporting(E_ALL);
$start = microtime(true);

define('DEFAULT_EXPIRATION', 2 * 24 * 60 * 60);
define('HOSTNAME', 'http://lightningpacker.localhost/');
define('CACHE_DELIMITER', '#####');
define('CACHE_DIR', 'tmp/');
$memcache = new Memcache();
$memcache->connect('localhost', 11211);

function setCache($key, $value, $expiration = DEFAULT_EXPIRATION)
{
    global $memcache;
    // Set cache on disk.
    $ret = false;
    if(($fd = fopen(CACHE_DIR . md5($key), 'w')) != false) {
	$ret = true;
	fwrite($fd, time() . CACHE_DELIMITER . $expiration . CACHE_DELIMITER . $value);
	fclose($fd);
    }

    // Set cache on memcache.
    $ret &= $memcache->set(md5($key), $value, 0, $expiration);

    return $ret;
}

function getCache($key) 
{
    global $memcache;
    // checks memcache.
    if(($ret = $memcache->get(md5($key))) === false) {
	// checks disk.
	$filename = CACHE_DIR . md5($key);
	$ret = false;
	if(file_exists($filename)) {
	    $str = file_get_contents($filename);
	    $info = explode(CACHE_DELIMITER, $str, 3);
	    $timestamp = (int) $info[0];
	    $expiration = (int) $info[1];
	    if(time() > $timestamp + $expiration) { // expired
		unlink($filename);
	    }
	    else {
		$ret = $info[2];
		$memcache->set(md5($key), $ret, 0, $expiration);
	    }
	}
    }

    return $ret;
}

function getFile($file)
{
    if(($str = getCache($file)) !== false) {
	$ret = $str;
    }
    else {
	$ret = file_get_contents($file);
	setCache($file, $ret);
    }

    return $ret;
}

function getFileSet($fileSet, $type = 'js') 
{
    $key = implode('', $fileSet);
    if(($str = getCache($key)) !== false) {
	$ret = $str;
    }
    else {
	$ret = '';
	foreach($fileSet as $file)
	    $ret .= getFile($file) . PHP_EOL;
	$filename = md5($key) . '---internal.' . $type;
	$fd = fopen(CACHE_DIR . $filename, 'w');
	fwrite($fd, $ret);
	fclose($fd);
	$ret = file_get_contents(HOSTNAME . 'minify/?k=//tmp/' . $filename);
	//unlink(CACHE_DIR . $filename);

	setCache($key, $ret);
    }

    return $ret;
}

if(!array_key_exists('type', $_GET) || !array_key_exists('obj', $_GET) || !in_array($_GET['type'], array('css', 'js'))) {
    echo 'Error: arguments missing. Consult the documentation and formulate a proper request.' . PHP_EOL;
}
else {
    $type = $_GET['type'];
    $header = '';
    switch($type) {
	case 'css':
	    $header = 'text/css';
	    break;
	case 'js':
	    $header = 'text/javascript';
	    break;
    }
    $objs = $_GET['obj'];
    $str = '';

    $str = getFileSet($objs, $type);
    header("Content-type:  $header");
    echo $str;



    $end = microtime(true);
    $fd = fopen(CACHE_DIR . 'log.txt', 'a');
    fwrite($fd, implode('', $objs) . ' '. ($end - $start) . PHP_EOL);
    fclose($fd);
}
