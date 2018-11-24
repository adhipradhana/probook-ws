package com.rattlesnake.ws;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;

import com.rattlesnake.methods.JSONMethod;
import org.json.*;

import com.rattlesnake.methods.HTTPMethod;
import com.rattlesnake.methods.DBMethod;
import com.rattlesnake.models.Book;

import java.util.HashMap;
import java.util.Random;

@WebService
@SOAPBinding(style = Style.RPC)
public class BookService {

    private final String BOOK_API_KEY = "AIzaSyAmKiuIzrY3aUGm6nh5MjVq7gaio0xobv8";
    private final String BASE_URL = "https://www.googleapis.com/books/v1/volumes";

    @WebMethod
    public Book[] searchBook(String searchTitle) {
        String targetURL = BASE_URL + "?q=intitle:" + searchTitle + "&key=" + BOOK_API_KEY;
        Book[] bookList;

        // return null if error
        String response = HTTPMethod.executeGet(targetURL);
        if (response == null) {
            bookList = new Book[1];

            return bookList;
        }

        // parse response
        bookList = JSONMethod.parseBookList(response);

        return bookList;
    }

    @WebMethod
    public Book getBookDetail(String id) {
        // target url
        String targetURL = BASE_URL + "/" + id + "?key=" + BOOK_API_KEY;

        // return null if error
        String response = HTTPMethod.executeGet(targetURL);
        if (response == null) {
            return new Book();
        }

        // parse book
        Book book = JSONMethod.parseBook(response);

        return book;
    }

    @WebMethod
    public boolean setBookRating(String id, double rating) {
        boolean result = DBMethod.changeRating(id, rating);

        return result;
    }

    @WebMethod
    public Book getRecommendedBook(String subject) {
        // get book id
        String id = DBMethod.getRecommendedBook(subject);

        if (id != null) {
            return getBookDetail(id);
        }

        // target url
        String targetURL = BASE_URL + "?q=subject:" + subject + "&key=" + BOOK_API_KEY;

        // return null if error
        String response = HTTPMethod.executeGet(targetURL);
        if (response == null) {
            return new Book();
        }

        // parse json object
        JSONObject jsonResponse = new JSONObject(response);

        // get item list
        JSONArray items = jsonResponse.getJSONArray("items");
        int totalItems = items.length();

        // get random item
        Random rand = new Random();
        int index = rand.nextInt(totalItems);

        // get random json object
        JSONObject item = items.getJSONObject(index);

        // parse book
        Book book = JSONMethod.parseBook(item);

        return book;
    }

}
