<?php

/**
 * Helper for gathering JS scripts.
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

class Zend_View_Helper_LightningPackerScript extends Zend_View_Helper_HeadScript
{
    public function toString($indent = null)
    {
        $this->getContainer()->ksort();
        $items = array();

	foreach($this as $item)
	    $bag[] = $item->attributes['src'];

	return lightningPacker($bag, 'js');
    }


    public function lightningPackerScript($mode = Zend_View_Helper_HeadScript::FILE, $spec = null, $placement = 'APPEND', array $attrs = array(), $type = 'text/javascript') 
    {
	parent::headScript($mode, $spec, $placement, $attrs, $type);
	return $this;
    }
}
