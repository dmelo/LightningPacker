<?php

/**
 * Gather all scripts on a html tag to call the proper LightningPacker script.
 *
 * @param $obj Array with the scripts names.
 * @param $type Script type, can be either 'js' or 'css'.
 * @param $retType Determines the returning variable, 0 - html include of the script, 1 - build package url, 2 - get package url, 3 - just the hash string.
 *
 * @return Returns the html tag to call the script package.
 *
 * Copyright (C) 2011  Diogo Oliveira de Melo
 *
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *  
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>. 
 */

function _plainTextParams($params)
{
    $ret = '';
    foreach($params as $key => $value)
	$ret .= "${key}=\"${value}\" ";

    return $ret;
}

function getDomain()
{
    $domain = '';
    if(file_exists('domain.txt')) {
	$fdomain = fopen('domain.txt', 'r');
	fscanf($fdomain, " %s ", $domain);
	fclose($fdomain);
    }
    else
	$domain = 'http://lightningpacker.net';

    return $domain;
}


function lightningPacker($obj, $type, $retType = 0, $params = array())
{
    $domain = getDomain();
    $hash = md5(implode('', $obj));
    $filename = "/tmp/${hash}-lp";
    if(!file_exists($filename) || 1 === $retType) {
	$urlBuild = "${domain}/packit.php?type=${type}";
	foreach($obj as $src)
	    $urlBuild .= '&obj[]=' . urlencode($src);
	file_get_contents($urlBuild);
	$fd = fopen($filename, 'w');
	fclose($fd);
    }

    $urlGet = "${domain}/get.php?hash=${hash}&type=${type}";
    if(0 === $retType) {
	if('css' === $type) {
	    if(!array_key_exists('rel', $params))
		$params['rel'] = 'stylesheet';
	    if(!array_key_exists('type', $params))
		$params['type'] = 'text/css';
	    $params['href'] = $urlGet;
	    $plainParams = _plainTextParams($params);
	    $ret = "<link $plainParams />";
	}
	elseif('js' === $type) {
	    if(!array_key_exists('type', $params))
		$params['type'] = 'text/javascript';
	    $params['src'] = $urlGet;
	    $plainParams = _plainTextParams($params);
	    $ret = "<script $plainParams></script>";
	}
    }
    elseif(1 === $retType)
	$ret = $urlBuild;
    elseif(2 === $retType)
	$ret = $urlGet;
    elseif(3 === $retType)
	$ret = $hash;

    return $ret;
}
