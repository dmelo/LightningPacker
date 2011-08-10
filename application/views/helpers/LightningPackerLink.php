<?php

/**
 * Helper for gathering CSS scripts.
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

require_once('LightningPacker.php');

class Zend_View_Helper_LightningPackerLink extends Zend_View_Helper_HeadLink
{
    public function toString($indent = null)
    {
        $this->getContainer()->ksort();
	$bag = array();

	foreach($this as $item) {
	    $item = (array) $item;
	    $bag[] = $item['href'];
	}

	return lightningPacker($bag, 'css');
    }


    public function lightningPackerLink(array $attributes = null, $placement = Zend_View_Helper_Placeholder_Container_Abstract::APPEND) 
    {
	parent::headLink($attributes, $placement);
	return $this;
    }
}
