#!/bin/bash

#mvn clean install
#cp target/bookws-1.0.war /usr/local/Cellar/tomcat/9.0.12/libexec/webapps/bookws.war
#brew services restart tomcat

javac -d build src/com/rattlesnake/ws/*.java src/com/rattlesnake/endpoint/*.java
cd build
echo "Running on port 9999"
java com.rattlesnake.endpoint.BookWSPublisher

