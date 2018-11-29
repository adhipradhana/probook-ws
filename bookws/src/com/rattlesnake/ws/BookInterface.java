package com.rattlesnake.ws;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;

import com.rattlesnake.models.Book;
import com.rattlesnake.models.Status;

@WebService
@SOAPBinding(style = Style.RPC)
public interface BookInterface {

    @WebMethod
    Book[] searchBook(@WebParam(name = "searchTitle") String searchTitle);

    @WebMethod
    Book getBookDetail(@WebParam(name = "bookID") String id);

    @WebMethod
    Status setBookRating(@WebParam(name = "bookID") String id, @WebParam(name = "rating") double rating);

    @WebMethod
    Book[] getRecommendedBook(@WebParam(name = "genre") String genres);

    @WebMethod
    Status purchaseBook(@WebParam(name = "cardNumber") String cardNumber, @WebParam(name = "bookID") String bookID,
                    @WebParam(name = "bookAmount") int bookAmount, @WebParam(name = "totpCode") String totpCode);

}