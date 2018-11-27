package com.rattlesnake.endpoint;

import javax.xml.ws.Endpoint;
import com.rattlesnake.ws.BookService;

//Endpoint publisher
public class ServicePublisher {

    public static void main(String[] args) {
        System.out.println("Running on port 3000");
        Endpoint.publish("http://localhost:3000/bookws/book", new BookService());
    }

}
