<?php

/**
 * Packs the given script accordenly with specified parameters and cache it for further use.
 *
 * @author Diogo Oliveira de Melo
 */

error_reporting(E_ALL);
$start = microtime(true);

define('DEFAULT_EXPIRATION', 2 * 24 * 60 * 60);
define('CACHE_DELIMITER', '#####');
define('CACHE_DIR', 'tmp/');
$fdomain = fopen('domain.txt', 'r');
fscanf($fdomain, " %s ", $domain);
fclose($fdomain);

function setCache($key, $value, $expire = DEFAULT_EXPIRATION)
{
    $ret = true;
    $str = time() . CACHE_DELIMITER . $expire . CACHE_DELIMITER . $value;

    // Set cache on disk.
    if(($fd = fopen(CACHE_DIR . md5($key), 'w')) != false) {
	$ret = true;
	fwrite($fd, $str);
	fclose($fd);
    }

    // Set cache on apc.
    $ret &= apc_store(md5($key), $str);

    return $ret;
}

function deleteCache($key)
{
    unlink(CACHE_DIR . md5($key));

    apc_delete(md5($key));
}

function getCache($key, $expRequested) 
{
    $expRequested = max($expRequested, 0);

    // checks apc.
    $success = false;
    $str = apc_fetch(md5($key), $success);
    if($success === false) {
	// checks disk.
	$filename = CACHE_DIR . md5($key);
	$ret = false;
	if(file_exists($filename)) {
	    $str = file_get_contents($filename);
	}
    }

    if($str !== false) {
	$info = explode(CACHE_DELIMITER, $str, 3);
	$timestamp = (int) $info[0];
	$expire = (int) $info[1];
	$newExpiration = $timestamp + $expire - time();
	if(time() > $timestamp + $expire || time() + $expRequested <= $timestamp + $expire) { // expired
	    $ret = false;
	    deleteCache($filename);
	}
	else {
	    $ret = array($info[2], $newExpiration);
	}
    }
    else
	$ret = false;


    return $ret;
}

function getFile($file, $expire)
{
    if(($ret = getCache($file, $expire)) === false) {
	$ret = array(file_get_contents($file), $expire);
	setCache($file, $ret[0], $expire);
    }

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
function getFileSet($fileSet, $type = 'js', $expire) 
{
    global $domain;

    $key = implode('', $fileSet);
    if(($ret = getCache($key, $expire)) === false) {
	$ret = '';
	$newExpiration = null;
	foreach($fileSet as $file) {
	    $fileInfo = getFile($file, $expire);
	    if($newExpiration === null)
		$newExpiration = $fileInfo[1];
	    else
		$newExpiration = min($newExpiration, $fileInfo[1]);
	    if('js' === $type)
		$ret .= PHP_EOL . ';' . PHP_EOL . $fileInfo[0];
	    else
		$ret .= PHP_EOL . $fileInfo[0];
	}


	$filename = md5($key) . '---internal.' . $type;
	$fd = fopen(CACHE_DIR . $filename, 'w');
	fwrite($fd, $ret);
	fclose($fd);
	$ret = file_get_contents("${domain}/minify/index.php?k=//tmp/${filename}");
	//unlink(CACHE_DIR . $filename);

	setCache($key, $ret, $expire);
	system('cd ' . CACHE_DIR .  '; ln -s ' . md5($key) . ' ' . md5($key) . '.' . $type);
	$ret = array($ret, $expire);
    }

    return $ret;
}

if(!array_key_exists('type', $_GET) || !array_key_exists('obj', $_GET) || !in_array($_GET['type'], array('css', 'js'))) {
    echo 'Error: arguments missing. Consult the documentation and formulate a proper request.' . PHP_EOL;
}
else {
    $expire = array_key_exists('expire', $_GET) ? $_GET['expire'] : DEFAULT_EXPIRATION;
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

    list($str, $limit) = getFileSet($objs, $type, $expire);
    header("Content-type:  $header");
    header("Cache-Control: max-age=604800, must-revalidate");
    header("Expires: ".gmdate("D, d M Y H:i:s", time() + $limit)."GMT");
    echo $str;



    $end = microtime(true);
    $fd = fopen(CACHE_DIR . 'log.txt', 'a');
    fwrite($fd, implode('', $objs) . ' '. ($end - $start) . PHP_EOL);
    fclose($fd);
}
