package com.rattlesnake.ws;

import javax.jws.WebService;

@WebService(endpointInterface="com.rattlesnake.ws.BookInterface")
public class Book implements BookInterface {
	
	String[] books = {"ayam", "tempik", "memek"};

	@Override
	public String getBookName() {
		return books[0];
	}
}
