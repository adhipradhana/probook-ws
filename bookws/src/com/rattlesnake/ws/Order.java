package com.rattlesnake.ws;

import javax.jws.WebService;

@WebService(endpointInterface="com.rattlesnake.ws.OrderInterface")
public class Order implements OrderInterface {
	
	@Override
	public int getOrderNumber() {
        return 1;
    }
}
