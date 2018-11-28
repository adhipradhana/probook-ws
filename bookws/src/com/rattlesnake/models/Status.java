package com.rattlesnake.models;

import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;
import javax.xml.bind.annotation.XmlAccessType;

@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "Status")
public class Status {

    @XmlElement(name = "status")
    private String status;

    @XmlElement(name = "message")
    private String message;

    public Status(String status, String message) {
        this.status = status;
        this.message = message;
    }

    public Status() {
        this.status = "error";
        this.message = "null";
    }

}
