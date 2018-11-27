package com.rattlesnake.methods;

import com.rattlesnake.models.Book;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.HashMap;

public class JSONMethod {

    public static Book[] parseBookList(String response) {
        // convert to json
        JSONObject jsonResponse = new JSONObject(response);

        // get item list
        JSONArray items = jsonResponse.getJSONArray("items");
        int totalItems = items.length();

        // create list of book
        Book[] bookList = new Book[totalItems];

        // parse list of books
        for (int i = 0; i < totalItems; i++) {
            JSONObject item = items.getJSONObject(i);

            bookList[i] = parseBook(item);
        }

        return bookList;
    }

    public static Book parseBook(String response) {
        // parse json object
        JSONObject item = new JSONObject(response);

        // construct book
        Book book = new Book();

        // assign id
        String id = item.getString("id");
        book.setId(id);

        // assign title
        String title = item.getJSONObject("volumeInfo").getString("title");
        book.setTitle(title);

        // assign author
        String author = item.getJSONObject("volumeInfo").getJSONArray("authors").getString(0);
        book.setAuthor(author);

        // assign image
        String image = item.getJSONObject("volumeInfo").getJSONObject("imageLinks").getString("thumbnail");
        book.setImage(image);

        // assign genre
        String genre = item.getJSONObject("volumeInfo").getJSONArray("categories").getString(0);
        book.setGenre(genre);

        // assign description
        String description = item.getJSONObject("volumeInfo").getString("description");
        book.setDescription(description);

        // assign price and rating
        HashMap<String, Number> result = DBMethod.getBookInfo(id);

        if (result != null) {
            book.setPrice(result.get("price").longValue());
            book.setRating(result.get("rating").doubleValue());
            book.setRatingCount(result.get("rating_count").intValue());
        }

        return book;
    }

    public static Book parseBook(JSONObject item) {
        // construct book
        Book book = new Book();

        // assign id
        String id = item.getString("id");
        book.setId(id);

        // assign title
        String title = item.getJSONObject("volumeInfo").getString("title");
        book.setTitle(title);

        // assign author
        String author = item.getJSONObject("volumeInfo").getJSONArray("authors").getString(0);
        book.setAuthor(author);

        // assign image
        String image = item.getJSONObject("volumeInfo").getJSONObject("imageLinks").getString("thumbnail");
        book.setImage(image);

        // assign genre
        String genre = item.getJSONObject("volumeInfo").getJSONArray("categories").getString(0);
        book.setGenre(genre);

        // assign description
        String description = item.getJSONObject("volumeInfo").getString("description");
        book.setDescription(description);

        // assign price and rating
        HashMap<String, Number> result = DBMethod.getBookInfo(id);

        if (result != null) {
            book.setPrice(result.get("price").longValue());
            book.setRating(result.get("rating").doubleValue());
            book.setRatingCount(result.get("rating_count").intValue());
        }

        return book;
    }
}
