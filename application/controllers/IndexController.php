<?php

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
		array('expire', 'Time for which the cache must be kept, in seconds. This parameter is optional and the default value is 172800, which is the equivalent to two days.', '3600'),
	    );

    }

    public function examplesAction()
    {
        // action body
    }


}







