<?php

$client = new SoapClient('http://localhost:3000/bookws/book?wsdl', array('cache_wsdl' => WSDL_CACHE_NONE) );

var_dump($client->__getFunctions());
//var_dump($client->searchBook("power+system+analysis"));
//var_dump($client->getBookDetail("s5xrAwAAQBAJ"));

?>
