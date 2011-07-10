<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initView()
    {
	$view = new Zend_View($this->getOptions());
	$view->doctype('HTML5');
	$view->headMeta()->setCharset('utf-8');
	$view->headScript()->appendFile('http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js');
	$view->headScript()->appendFile('http://autobahn.tablesorter.com/jquery.tablesorter.min.js');
	$view->headScript()->appendFile($view->baseUrl() . '/js/default.js');
	$view->headLink()->appendStylesheet($view->baseUrl() . '/css/810.css');
	$view->headLink()->appendStylesheet($view->baseUrl() . '/css/default.css');
    }

}

