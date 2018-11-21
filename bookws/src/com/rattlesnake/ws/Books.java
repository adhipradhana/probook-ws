package com.rattlesnake.ws;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;

import java.util.List;
import java.util.ArrayList;

import com.rattlesnake.ws.Book;

@WebService
@SOAPBinding(style = Style.RPC)
public class Books {
	
	Book[] books = new Book[4];

	@WebMethod
	public Book getBookName() {
		Book book = new Book();

		return book;
	}
}
