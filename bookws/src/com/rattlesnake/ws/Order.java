package com.rattlesnake.ws;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;

@WebService
@SOAPBinding(style = Style.RPC)
public class Order {
    
    @WebMethod
	public int getOrderNumber() {
        return 1;
    }
}
