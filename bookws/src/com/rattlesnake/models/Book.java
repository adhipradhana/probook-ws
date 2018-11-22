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

    @XmlElement(name = "image")
    private String image;

    @XmlElement(name = "description")
    private String description;

    @XmlElement(name = "rating")
    private double rating;

    @XmlElement(name = "price")
    private long price;

    public Book(String id, String title, String image, String description, double rating, long price) {
        this.id = id;
        this.title = title;
        this.image = image;
        this.description = description;
        this.rating = rating;
        this.price = price;
    }

    public Book() {
        this.id = "0";
        this.title = "Tayo the Creator";
        this.image = "tayo.com";
        this.description = "Tayo huyu emang";
        this.rating = 5.0;
        this.price = 30000;
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
}