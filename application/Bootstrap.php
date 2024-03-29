<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initView()
    {
	$fdomain = fopen('domain.txt', 'r');
	fscanf($fdomain, " %s ", $domain);
	fclose($fdomain);

	$fdversion = fopen('../VERSION', 'r');
	fscanf($fdversion, " %s ", $version);
	fclose($fdversion);

	Zend_Registry::set('domain', $domain);
	Zend_Registry::set('version', $version);

	$view = new Zend_View($this->getOptions());
	$view->addHelperPath('../application/views/helpers/', 'Zend_View_Helper');
	$view->doctype('HTML5');
	$view->headMeta()->setCharset('utf-8');
	$view->headMeta()->setHttpEquiv('Content-Type', 'text/html;charset=utf-8');
	$view->headMeta()->appendName('description', 'LightningPacker aims to help your website to better delivery content to its users. Instead of make an awful amount of requisitions per page load, do just one for all your javascript content and another one for your css files.');
	$view->headMeta()->appendName('keywords', 'minify, online, website, performance, improvement, JS, Javascript, CSS');
	$view->lightningPackerScript()->appendFile('http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js');
	$view->lightningPackerScript()->appendFile('https://raw.github.com/rafaelp/css_browser_selector/master/css_browser_selector.js');
	$view->lightningPackerScript()->appendFile('http://autobahn.tablesorter.com/jquery.tablesorter.min.js');
	$view->lightningPackerScript()->appendFile("${domain}/js/chili/jquery.chili-2.2.js");
	//$view->lightningPackerScript()->appendFile("${domain}/js/jquery-ui-1.8.15.custom.min.js"); sortable
	$view->lightningPackerScript()->appendFile("${domain}/js/chili/recipes.js");
	$view->lightningPackerScript()->appendFile("${domain}/js/jquery.cookie.js");
	$view->lightningPackerScript()->appendFile("${domain}/js/jquery.shadow.js");
	$view->lightningPackerScript()->appendFile("${domain}/js/jquery.ifixpng.js");
	$view->lightningPackerScript()->appendFile("${domain}/js/jquery.fancyzoom.min.js");
	$view->lightningPackerScript()->appendFile("${domain}/js/jquery.tableofcontents.min.js");
	$view->lightningPackerScript()->appendFile("${domain}/js/jquery.jqtransform.js");
	$view->lightningPackerScript()->appendFile("${domain}/js/jquery.form.js");
	$view->lightningPackerScript()->appendFile("${domain}/js/jquery.anchor.js");
	$view->lightningPackerScript()->appendFile('http://simplemodal.googlecode.com/files/jquery.simplemodal-1.4.1.js');
	$view->lightningPackerScript()->appendFile("${domain}/js/default.js");
	$view->lightningPackerLink()->appendStylesheet("${domain}/css/810.css");
	$view->lightningPackerLink()->appendStylesheet("${domain}/css/jqtransform.css");
	$view->lightningPackerLink()->appendStylesheet("${domain}/css/example-simplemodal.css");
	$view->lightningPackerLink()->appendStylesheet("${domain}/css/default.css");

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

