package main

import (
	"fmt"
	"log"
	"net"
	"os"
)

const (
	connType = "tcp"
	host     = "127.0.0.1"
	port     = "11022"
)

func main() {
	l, err := net.Listen(connType, host+":"+port)
	if err != nil {
		log.Panic("Error listening:", err)
		fmt.Println("Error listening:", err)
		os.Exit(1)
	}
	defer l.Close()
	log.Info("Listening on " + CONN_HOST + ":" + CONN_PORT)
	for {
		conn, err := l.Accept()
		if err != nil {
			fmt.Println("Error accepting: ", err.Error())
			os.Exit(1)
		}
		go handleRequest(conn)
	}
}

func handleRequest(conn net.Conn) {
	buf := make([]byte, 1024)
	bytesRead, err := conn.Read(buf)
	if err != nil {
		fmt.Println(err.Error())
	}
	fd, err := os.Open("public/index.html")
	if err {
		fmt.Println(err.Error())
		return
	}
	bytesRead, err = fd.Read(buf)
	conn.Write([]byte("HTTP/1.1 STATUS OK" + buf))
	conn.Close()
}
