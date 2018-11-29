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
        if (!jsonResponse.has("items")) {
            return new Book[1];
        }

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
        if (item.getJSONObject("volumeInfo").has("authors")) {
            String author = item.getJSONObject("volumeInfo").getJSONArray("authors").getString(0);
            book.setAuthor(author);
        } else {
            book.setAuthor("Various authors");
        }

        // assign image
        if (item.getJSONObject("volumeInfo").has("imageLinks")) {
            String image = item.getJSONObject("volumeInfo").getJSONObject("imageLinks").getString("thumbnail");
            book.setImage(image);
        } else {
            book.setImage("https://upload.wikimedia.org/wikipedia/en/thumb/9/99/Question_book-new.svg/512px-Question_book-new.svg.png");
        }

        // assign genre
        if (item.getJSONObject("volumeInfo").has("categories")) {
            JSONArray genres = item.getJSONObject("volumeInfo").getJSONArray("categories");
            StringBuilder genreString = new StringBuilder();

            for (int i = 0; i < genres.length(); i++) {
                String genre = genres.getString(i);

                if (i == 0) {
                    genreString.append(genre);
                } else {
                    genreString.append(",");
                    genreString.append(genre);
                }
            }

            System.out.println(genreString.toString());
            book.setGenre(genreString.toString());
        } else {
            book.setGenre("Unknown");
        }

        // assign description
        if (item.getJSONObject("volumeInfo").has("description")) {
            String description = item.getJSONObject("volumeInfo").getString("description");
            book.setDescription(description);
        } else {
            book.setDescription("No description found.");
        }

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
        System.out.println(id);

        // assign title
        String title = item.getJSONObject("volumeInfo").getString("title");
        book.setTitle(title);
        System.out.println(title);

        // assign author
        if (item.getJSONObject("volumeInfo").has("authors")) {
            String author = item.getJSONObject("volumeInfo").getJSONArray("authors").getString(0);
            book.setAuthor(author);
        } else {
            book.setAuthor("Various authors");
        }

        // assign image
        if (item.getJSONObject("volumeInfo").has("imageLinks")) {
            String image = item.getJSONObject("volumeInfo").getJSONObject("imageLinks").getString("thumbnail");
            book.setImage(image);
        } else {
            book.setImage("https://upload.wikimedia.org/wikipedia/en/thumb/9/99/Question_book-new.svg/512px-Question_book-new.svg.png");
        }

        // assign genre
        if (item.getJSONObject("volumeInfo").has("categories")) {
            JSONArray genres = item.getJSONObject("volumeInfo").getJSONArray("categories");
            StringBuilder genreString = new StringBuilder();

            for (int i = 0; i < genres.length(); i++) {
                String genre = genres.getString(i);

                if (i == 0) {
                    genreString.append(genre);
                } else {
                    genreString.append(",");
                    genreString.append(genre);
                }
            }

            System.out.println(genreString.toString());
            book.setGenre(genreString.toString());
        } else {
            book.setGenre("Unknown");
        }

        // assign description
        if (item.getJSONObject("volumeInfo").has("description")) {
            String description = item.getJSONObject("volumeInfo").getString("description");
            book.setDescription(description);
        } else {
            book.setDescription("No description found.");
        }

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
