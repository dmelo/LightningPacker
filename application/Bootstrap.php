<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initView()
    {
	$fdomain = fopen('domain.txt', 'r');
	fscanf($fdomain, " %s ", $domain);
	fclose($fdomain);
	Zend_Registry::set('domain', $domain);
	$view = new Zend_View($this->getOptions());
	$view->addHelperPath('../application/views/helpers/', 'Zend_View_Helper');
	$view->doctype('HTML5');
	$view->headMeta()->setCharset('utf-8');
	$view->lightningPackerScript()->appendFile('http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js?a=b&c=d');
	$view->lightningPackerScript()->appendFile('https://raw.github.com/rafaelp/css_browser_selector/master/css_browser_selector.js');
	$view->lightningPackerScript()->appendFile('http://autobahn.tablesorter.com/jquery.tablesorter.min.js');
	$view->lightningPackerScript()->appendFile($domain . '/js/chili/jquery.chili-2.2.js');
	$view->lightningPackerScript()->appendFile($domain . '/js/chili/recipes.js');
	$view->lightningPackerScript()->appendFile($domain . '/js/jquery.shadow.js');
	$view->lightningPackerScript()->appendFile($domain . '/js/jquery.ifixpng.js');
	$view->lightningPackerScript()->appendFile($domain . '/js/jquery.fancyzoom.min.js');
	$view->lightningPackerScript()->appendFile($domain . '/js/jquery.tableofcontents.min.js');
	$view->lightningPackerScript()->appendFile($domain . '/js/jquery.jqtransform.js');
	$view->lightningPackerScript()->appendFile($domain . '/js/jquery.form.js');
	$view->lightningPackerScript()->appendFile('http://simplemodal.googlecode.com/files/jquery.simplemodal-1.4.1.js');
	$view->lightningPackerScript()->appendFile($domain . '/js/default.js');
	$view->lightningPackerLink()->appendStylesheet($domain . '/css/810.css');
	$view->lightningPackerLink()->appendStylesheet($domain . '/css/jqtransform.css');
	$view->lightningPackerLink()->appendStylesheet($domain . '/css/example-simplemodal.css');
	$view->lightningPackerLink()->appendStylesheet($domain . '/css/default.css');

	$this->bootstrap('frontController');
	$front = $this->getResource('frontController');
	$front->setRequest(new Zend_Controller_Request_Http());
	$request = $front->getRequest();
	$ajax = 0;
	if($request->isXmlHttpRequest() === true) {
	    $this->bootstrap('Layout');
	    $layout = $this->getResource('Layout');
	    $layout->disableLayout();
	    $ajax = 1;
	}
	Zend_Registry::set('ajax', $ajax);
    }

    protected function _initRouter()
    {
	$fc = Zend_Controller_Front::getInstance()->getRouter();
	$routeIndex = new Zend_Controller_Router_Route(':action',
	    array('controller' => 'index',

	    )
	);
	$fc->addRoute('index', $routeIndex);

    }


}

