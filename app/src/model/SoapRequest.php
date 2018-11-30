<?php
class SoapRequest {
    private $book_url;
    private $client;

    public function __construct() {
        $this->book_url = "http://" . $_ENV['BOOK_URL'];
        try {
            $this->client = new SoapClient($this->book_url, array('cache_wsdl' => WSDL_CACHE_NONE) );
        } catch (SoapFault $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function purchaseBook($cardNumber, $bookId, $quantity, $otp) {
        $status = $this->client->purchaseBook($cardNumber, $bookId, $quantity, $otp);
        return $status;
    }

    public function getBookDetail($id) {
        return $this->client->getBookDetail($id);
    }

    public function searchBook($query) {
        return $this->client->searchBook($query)->item;
    }

    public function getRecommendedBook($genre) {
        return $this->client->getRecommendedBook($genre);
    }

    public function setBookRating($bookId,$rating) {
        return $this->client->setBookRating($bookId,$rating);
    }
}
