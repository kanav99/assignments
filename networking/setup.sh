#!/bin/bash
file = $1
if [[ file == "my_server.c" ]]; then
	gcc -o server my_server.c
fi
if [[ file == "server.go" ]]; then
	go build -o server server.go
fi
