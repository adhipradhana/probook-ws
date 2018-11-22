package com.rattlesnake.models;

import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;
import javax.xml.bind.annotation.XmlAccessType;

@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "Book")
public class Book {

    @XmlElement(name = "id")
    private String id;

    @XmlElement(name = "title")
    private String title;

    @XmlElement(name = "author")
    private String author;

    @XmlElement(name = "image")
    private String image;

    @XmlElement(name = "description")
    private String description;

    @XmlElement(name = "rating")
    private double rating;

    @XmlElement(name = "price")
    private long price;

    public Book(String id, String title, String author, String image, String description, double rating, long price) {
        this.id = id;
        this.title = title;
        this.image = image;
        this.author = author;
        this.description = description;
        this.rating = rating;
        this.price = price;
    }

    public Book() {
        this.id = "0";
        this.title = "Default Title";
        this.author = "Anonymous";
        this.image = "null";
        this.description = "null";
        this.rating = 0.0;
        this.price = 0;
    }

    // getter
    public String getId() {
        return this.id;
    }

    public String getTitle() {
        return this.title;
    }

    public String getImage() {
        return this.image;
    }

    public String getDescription() {
        return this.description;
    }

    public double getRating() {
        return this.rating;
    }

    public long getPrice() {
        return this.price;
    }

    // setter
    public void setId(String id) {
        this.id = id;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public void setImage(String image) {
        this.image = image;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public void setRating(double rating) {
        this.rating = rating;
    }

    public void setPrice(long price) {
        this.price = price;
    }

    public String getAuthor() {
        return this.author;
    }

    public void setAuthor(String author) {
        this.author = author;
    }
}