<?php

$client = new SoapClient('http://localhost:3000/bookws/book?wsdl', array('cache_wsdl' => WSDL_CACHE_NONE) );

var_dump($client->__getFunctions());
//var_dump($client->searchBook("the+shining"));
var_dump($client->getBookDetail("8VnJLu3AvvQC"));
//$query = "\"Horror\"";
//$query_bersih = urlencode($query);
//$client->setBookRating('1', 5.0);

//var_dump($client->getRecommendedBooks("funny,science"));

?>
