package com.rattlesnake.ws;

import javax.jws.WebService;
import org.json.*;

import com.rattlesnake.methods.JSONMethod;
import com.rattlesnake.methods.HTTPMethod;
import com.rattlesnake.methods.DBMethod;
import com.rattlesnake.models.Book;
import com.rattlesnake.models.Status;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.List;
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
        Book book = JSONMethod.parseBook(response);

        return book;
    }

    @Override
    public Status setBookRating(String id, double rating) {
        boolean result = DBMethod.changeRating(id, rating);

        if (result) {
            return new Status("success", "");
        } else {
            return new Status("error", "Unable to change rating");
        }
    }

    @Override
    public Book[] getRecommendedBook(String genres) {
        // split string into genre
        String[] genreList = genres.split(",");

        System.out.println("memek");
        System.out.println("Genres " + genres);
        for (int i = 0; i < genreList.length; i++) {
            System.out.println(i);
            System.out.println(genreList[i]);
        }

        // get book id
        List<String> idList = DBMethod.getRecommendedBook(genreList);

        // book array declaration
        Book[] bookList = new Book[1];

        if (idList != null) {
            bookList = new Book[idList.size()];
            for (int i = 0; i < bookList.length; i++) {
                bookList[i] = getBookDetail(idList.get(i));
            }

            return bookList;
        }

        // get random genre
        Random rand = new Random();
        int genreIndex = rand.nextInt(genreList.length);
        String genreString = genreList[genreIndex];

        System.out.println("Genre " + genreString) ;
        
        String urlGenre;
        try {
            urlGenre = URLEncoder.encode(genreString, "UTF-8");
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
            urlGenre = genreList[0];
        }

        // target url
        String targetURL = BASE_URL + "?q=subject:" + urlGenre + "&key=" + BOOK_API_KEY;

        // return null if error
        String response = HTTPMethod.executeGet(targetURL);
        if (response == null) {
            return bookList;
        }

        // parse json object
        JSONObject jsonResponse = new JSONObject(response);

        // handle null values
        if (!jsonResponse.has("items")) {
            bookList = new Book[1];

            return bookList;
        }

        // get item list
        JSONArray items = jsonResponse.getJSONArray("items");
        int totalItems = items.length() > 3 ? 3 : items.length();

        // get book
        bookList = new Book[totalItems];
        for (int i = 0; i < totalItems; i++) {
            bookList[i] = JSONMethod.parseBook(items.getJSONObject(i));
        }

        return bookList;
    }

    @Override
    public Status purchaseBook(String cardNumber, String bookID, int bookAmount, String totpCode) {
        // target url
        String targetURL = "http://localhost:5000/api/v1/charge";

        // get book info
        Book book = getBookDetail(bookID);

        // book not found
        if (book.getId().equals("0")) {
            return new Status("error", "Book not found");
        }

        // calculate book price
        long price = book.getPrice();
        long totalAmount = price * bookAmount;
        String genre = book.getGenre();

        // create and assign json
        JSONObject body = new JSONObject();
        body.put("apiKey", MERCHANT_SECRET);
        body.put("amount", totalAmount);
        body.put("cardNumber", cardNumber);
        body.put("totpCode", totpCode);

        // execute post request
        String response = HTTPMethod.executePost(targetURL, body);
        JSONObject jsonResponse = new JSONObject(response);
        System.out.println(jsonResponse.toString());

        // get response
        if (jsonResponse.getString("status").equals("failed")) {
            return new Status("error", jsonResponse.getString("message"));
        }

        // add sales record to database
        if (!DBMethod.updateSales(bookID, genre, bookAmount)) {
            return new Status("error", "Unable to add sales record to database");
        }

        return new Status("success", "");
    }

}
