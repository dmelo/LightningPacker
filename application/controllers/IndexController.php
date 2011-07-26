<?php

include('LightningPacker.php');

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function aboutAction()
    {
        // action body
    }

    public function docsAction()
    {
        // action body
	$this->view->table = array(
		array('type', 'Determine wheter the package is JS or CSS. May assume just the values "js" or "css".', 'js'),
		array('obj[]', 'Contains the list of objects. For each script, add the url into the obj array.', 'obj[]=http://example.com/a.js&obj[]=http://example.com/b.js'),
	    );

	$this->view->table2 = array(
		array('type', 'Determine wheter the package is JS or CSS. May assume just the values "js" or "css".', 'js'),
		array('hash', 'The md5 of the concatenation of all "obj" parameters. The php code to produce this parameter would be something like md5(implode(\'\', $obj)).', '85e8c81c98b46b90f80cd9b80b5066fb'),
	    );

    }

    public function examplesAction()
    {
        // action body
    }

    public function quickstartAction()
    {
        // action body
    }

    public function packagemanagerAction()
    {
	$request = $this->getRequest();
	if($request->isPost()) {
	    $type = strtolower($request->getPost('type'));
	    $url = $request->getPost('url');
	    $this->view->html = lightningPacker($url, $type);
	    $this->view->build = lightningPacker($url, $type, 1);
	    $this->view->get = lightningPacker($url, $type, 2);
	    $this->view->hash = lightningPacker($url, $type, 3);
	}
    }


}











