package com.rattlesnake.ws;

import javax.jws.WebService;

@WebService(endpointInterface="com.rattlesnake.ws.BookInterface")
public class Book implements BookInterface {
	
	@Override
	public String getBookName(String str) {
		return str;
	}
}
