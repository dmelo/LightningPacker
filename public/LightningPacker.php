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
function lightningPacker($obj, $type, $retType = 0)
{
    $hash = md5(implode('', $obj));
    $filename = "/tmp/${hash}-lp";
    if(!file_exists($filename) || 1 === $retType) {
	$urlBuild = "http://lightningpacker.net/packit.php?type=${type}";
	foreach($obj as $src)
	    $urlBuild .= '&obj[]=' . urlencode($src);
	file_get_contents($urlBuild);
	$fd = fopen($filename, 'w');
	fclose($fd);
    }

    $urlGet = "http://lightningpacker.net/get.php?hash=${hash}&type=${type}";
    if(0 === $retType) {
	if('css' === $type) 
	    $ret = "<link rel=\"stylesheet\" type=\"text/css\" href=\"${urlGet}\" />";
	elseif('js' === $type)
	    $ret = "<script type=\"text/javascript\" src=\"${urlGet}\"></script>";
    }
    elseif(1 === $retType)
	$ret = $urlBuild;
    elseif(2 === $retType)
	$ret = $urlGet;
    elseif(3 === $retType)
	$ret = $hash;

    return $ret;
}
