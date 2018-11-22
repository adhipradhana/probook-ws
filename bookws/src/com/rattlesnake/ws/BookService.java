package com.rattlesnake.ws;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;
import org.json.*;

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

        // return null if error
        String response = HTTPMethod.executeGet(targetURL);
        if (response == null) {
            Book[] bookList = new Book[1];

            return bookList;
        }

        // parse json object
        JSONObject jsonResponse = new JSONObject(response);

        // get item list
        JSONArray items = jsonResponse.getJSONArray("items");
        int totalItems = items.length();

        Book[] bookList = new Book[totalItems];
        for (int i = 0; i < totalItems; i++) {
            // get item
            JSONObject item = items.getJSONObject(i);

            // construct book
            bookList[i] = new Book();

            // assign id
            String id = item.getString("id");
            bookList[i].setId(id);

            // assign title
            String title = item.getJSONObject("volumeInfo").getString("title");
            bookList[i].setTitle(title);

            // assign author
            if (item.getJSONObject("volumeInfo").has("authors")) {
                String author = item.getJSONObject("volumeInfo").getJSONArray("authors").getString(0);
                bookList[i].setAuthor(author);
            }

            // assign image
            if (item.getJSONObject("volumeInfo").has("imageLinks")) {
                String image = item.getJSONObject("volumeInfo").getJSONObject("imageLinks").getString("thumbnail");
                bookList[i].setImage(image);
            }

            // assign description
            if (item.getJSONObject("volumeInfo").has("description")) {
                String description = item.getJSONObject("volumeInfo").getString("description");
                bookList[i].setDescription(description);
            }

            // TODO : assign rating from db
            // TODO : assign price from db
        }

        return bookList;
    }

}
