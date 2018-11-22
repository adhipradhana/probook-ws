package com.rattlesnake.ws;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;
//import javax.json.*;

import com.rattlesnake.methods.HTTPMethod;
import com.rattlesnake.models.Book;

@WebService
@SOAPBinding(style = Style.RPC)
public class BookService {

    private final String BOOK_API_KEY = "AIzaSyAmKiuIzrY3aUGm6nh5MjVq7gaio0xobv8";
    private final String BASE_URL = "https://www.googleapis.com/books/v1/volumes?q=intitle:";

    @WebMethod
    public Book[] searchBook(String searchTitle) {
        String targetURL = BASE_URL + searchTitle + "&key=" + BOOK_API_KEY;
        Book[] bookList = new Book[1];

        // return null if error
        String response = HTTPMethod.executeGet(targetURL);
        if (response == null) {
            return bookList;
        }

//        JSONParser jsonResponse;

        // int elementLength = jsonResponse.getInt("totalItems");
        // Object item = jsonResponse.get("item");

        // System.out.println(item.toString());


        return bookList;
    }

}
