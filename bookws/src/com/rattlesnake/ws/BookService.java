package com.rattlesnake.ws;

import javax.jws.WebService;

import com.rattlesnake.methods.JSONMethod;
import org.json.*;

import com.rattlesnake.methods.HTTPMethod;
import com.rattlesnake.methods.DBMethod;
import com.rattlesnake.models.Book;

import java.util.Random;

@WebService(endpointInterface="com.rattlesnake.ws.BookInterface")
public class BookService implements BookInterface {

    private final String BOOK_API_KEY = "AIzaSyAmKiuIzrY3aUGm6nh5MjVq7gaio0xobv8";
    private final String BASE_URL = "https://www.googleapis.com/books/v1/volumes";
    private final String MERCHANT_SECRET = "DJJALIJALIKECEBONGKU";

    @Override
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

    @Override
    public Book getBookDetail(String id) {
        // target url
        String targetURL = BASE_URL + "/" + id + "?key=" + BOOK_API_KEY;

        // return null if error
        String response = HTTPMethod.executeGet(targetURL);
        if (response == null) {
            return new Book();
        }

        // parse book
        Book book = JSONMethod.parseBookResponse(response);

        return book;
    }

    @Override
    public boolean setBookRating(String id, double rating) {
        boolean result = DBMethod.changeRating(id, rating);

        return result;
    }

    @Override
    public Book getRecommendedBook(String genre) {
        // get book id
        String id = DBMethod.getRecommendedBook(genre);

        if (id != null) {
            return getBookDetail(id);
        }

        // target url
        String targetURL = BASE_URL + "?q=subject:" + genre + "&key=" + BOOK_API_KEY;

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

    @Override
    public boolean buyBook(String cardNumber, String bookID, int bookAmount, String totp) {
        // target url
        String targetURL = "http://localhost:5000/api/v1/charge";

        // get book info
        Book book = getBookDetail(bookID);

        // book not found
        if (book.getId().equals("0")) {
            return false;
        }

        // calculate book price
        long price = book.getPrice();
        long totalAmount = price * bookAmount;
        String genre = book.getGenre();

        // create and assign json
        JSONObject body = new JSONObject();
        body.put("secret", MERCHANT_SECRET);
        body.put("amount", totalAmount);
        body.put("cardNumber", cardNumber);
        body.put("totp", totp);

        // execute post request
        String response = HTTPMethod.executePost(targetURL, body);
        JSONObject jsonResponse = new JSONObject(response);

        // get response
        if (jsonResponse.getString("status").equals("error")) {
            return false;
        }

        // add sales record to database
        if (!DBMethod.updateSales(bookID, genre, bookAmount)) {
            return false;
        }

        return true;
    }

}
