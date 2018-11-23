<?php

$client = new SoapClient('http://localhost:3000/service/book?wsdl', array('cache_wsdl' => WSDL_CACHE_NONE) );

var_dump($client->__getFunctions());
var_dump($client->searchBook("earth+mankind"));
var_dump($client->getBookDetail("s5xrAwAAQBAJ"));

?>