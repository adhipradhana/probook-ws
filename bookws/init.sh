#!/bin/bash

mvn clean install
cp target/bookws-1.0.war /usr/local/Cellar/tomcat/9.0.12/libexec/webapps/bookws.war
brew services restart tomcat
