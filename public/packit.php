<?php

$start = microtime(true);

define('DEFAULT_EXPIRATION', 2 * 24 * 60 * 60);
define('CACHE_DELIMITER', '#####');
define('CACHE_DIR', 'tmp/');

function setCache($key, $value, $expiration = DEFAULT_EXPIRATION)
{
    $ret = false;
    if(($fd = fopen(CACHE_DIR . md5($key), 'w')) != false) {
	$ret = true;
	fwrite($fd, time() . CACHE_DELIMITER . $expiration . CACHE_DELIMITER . $value);
	fclose($fd);
    }

    return $ret;
}

function getCache($key) 
{
    $log = fopen("/tmp/log.txt", "a");
    fwrite($log, "1" . $key . PHP_EOL);
    $filename = CACHE_DIR . md5($key);
    fwrite($log, "2" . $filename . PHP_EOL);
    $ret = null;
    fwrite($log, "3" . PHP_EOL);
    if(file_exists($filename)) {
	fwrite($log, "4" . PHP_EOL);
	$str = file_get_contents($filename);
	fwrite($log, "5" . $str . PHP_EOL);
	$info = explode(CACHE_DELIMITER, $str, 3);
	fwrite($log, "6" . var_export($info, true) . PHP_EOL);
	$timestamp = (int) $info[0];
	fwrite($log, "7" . PHP_EOL);
	$expiration = (int) $info[1];
	fwrite($log, "8" . PHP_EOL);
	if(time() > $timestamp + $expiration) { // expired
	    unlink($filename);
	}
	else {
	    $ret = $info[2];
	}
    }

    fclose($log);

    return $ret;
}

function getFile($file)
{
    if(($str = getCache($file)) !== null) {
	$ret = $str;
    }
    else {
	$ret = file_get_contents($file);
	setCache($file, $ret);
    }

    return $ret;
}


function getFileSet($fileSet) 
{
    $key = implode('', $fileSet);
    if(($str = getCache($key)) !== null) {
	$ret = $str;
    }
    else {
	$ret = '';
	foreach($fileSet as $file)
	    $ret .= getFile($file) . PHP_EOL;
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

    $str = getFileSet($objs);

    header($header);
    echo $str;

    $end = microtime(true);
    $fd = fopen(CACHE_DIR . 'log.txt', 'a');
    fwrite($fd, implode('', $objs) . ' '. ($end - $start) . PHP_EOL);
    fclose($fd);
}


