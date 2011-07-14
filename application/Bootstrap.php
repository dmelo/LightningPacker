<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initView()
    {
	$config = new Zend_Config_Ini('../application/configs/application.ini', APPLICATION_ENV);
	Zend_Registry::set('config', $config);
	$view = new Zend_View($this->getOptions());
	$view->addHelperPath('../application/views/helpers/', 'Zend_View_Helper');
	$view->doctype('HTML5');
	$view->headMeta()->setCharset('utf-8');
	$view->lightningPackerScript()->appendFile('http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js');
	$view->lightningPackerScript()->appendFile('http://autobahn.tablesorter.com/jquery.tablesorter.min.js');
	$view->lightningPackerScript()->appendFile($config->domain . '/js/default.js');
	$view->lightningPackerLink()->appendStylesheet($config->domain . '/css/810.css');
	$view->lightningPackerLink()->appendStylesheet($config->domain . '/css/default.css');
    }

}

