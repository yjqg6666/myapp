#!/bin/sh
#reference http://wangye.org/blog/archives/732/
openssl genrsa -out ca.key 2048

openssl req -new -x509 -days 36500 -key ca.key -out ca.crt

openssl genrsa -out server.key 2048

openssl req -new -key server.key -out server.csr 

mkdir -p demoCA/newcerts && touch demoCA/index.txt && echo '01' > demoCA/serial

openssl ca -in server.csr -out server.crt -cert ca.crt -keyfile ca.key
