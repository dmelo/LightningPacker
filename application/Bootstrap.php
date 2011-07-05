<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initView()
    {
	$view = new Zend_View($this->getOptions());
	$view->doctype('HTML5');
	$view->headMeta()->setCharset('utf-8');
	//$view->headScript()->appendFile($view->baseUrl() . '/js/jquery.js');
	$view->headLink()->appendStylesheet($view->baseUrl() . '/css/810.css');
	$view->headLink()->appendStylesheet($view->baseUrl() . '/css/default.css');
    }

}

