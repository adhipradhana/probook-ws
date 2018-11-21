package com.rattlesnake.endpoint;

import javax.xml.ws.Endpoint;
import com.rattlesnake.ws.Books;
import com.rattlesnake.ws.Order;

//Endpoint publisher
public class BookWSPublisher {
	
	public static void main(String[] args) {
	   Endpoint.publish("http://localhost:9999/ws/books", new Books());
    }

}
