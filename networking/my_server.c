#include<stdio.h>
#include<string.h>
#include<stdlib.h>
#include<unistd.h>
#include<sys/types.h>
#include<sys/stat.h>
#include<sys/socket.h>
#include<arpa/inet.h>
#include<netdb.h>
#include<signal.h>
#include<fcntl.h>
#define PACKET 1024
char ROOT[1000];
struct request
{
	char path[1000];
	char type[5];
};
struct request request_parser (char * req) {
	struct request x;
	int len;
	strcpy(x.path, ROOT);
	strcpy(x.type, strtok(req," \t"));
	strcat(x.path, strtok(NULL," \t"));
	len = strlen(x.path);
	if(x.path[len-1] == '/') {
		strcat(x.path, "index.html");
	}
	return x;
}
int listener,client;
void request_handler ( int client) {
	char req[10000],data[PACKET];
	int file,bytes;
	memset((void*) req, (int)'\0', 10000);
	recv(client, req, 10000, 0);
	struct request x = request_parser(req);
	printf("%s\n", x.path);
	if ((file=open(x.path, O_RDONLY))!=-1)
	{
		send(client, "HTTP/1.0 200 OK\n\n", 17, 0);
		while ((bytes = read(file, data, PACKET)) > 0 )
			write (client, data, bytes);
	}
	else
		write(client, "HTTP/1.0 404 Not Found\n", 23);
	close(client);
}
int start_server () {

	struct addrinfo hints, *res, *i;
	memset (&hints, 0, sizeof(hints));
	hints.ai_family = AF_INET;						//need to understand this part
	hints.ai_socktype = SOCK_STREAM;
	hints.ai_flags = AI_PASSIVE;
	getaddrinfo( NULL, "11022", &hints, &res);
	for (i = res; i != NULL; i = i->ai_next) {
		listener = socket (i->ai_family, i->ai_socktype, 0);
		if (listener == -1)
			continue;
		if (bind(listener, i->ai_addr, i->ai_addrlen) == 0) break;
	}
	freeaddrinfo(res);
	if(listen(listener, 100) == -1) {
		perror("listen");
		exit(3);
	}
	return listener;
}
int main(int argc, char const *argv[])
{
	getcwd(ROOT, sizeof(ROOT));
	strcat(ROOT, "/public");
	printf("Current Public Directory is : %s\n", ROOT);
	fd_set master, readfds;
	int fdmax,i;
	FD_ZERO(&master);
	FD_ZERO(&readfds);
	struct sockaddr_in client_addr;
	socklen_t client_len;
	client_len = sizeof(client_addr);
	int listener = start_server();
	printf("Server started on port 11022\n");
	FD_SET(listener, &master);
	fdmax = listener;
	while (1) {
		readfds = master;
		select(fdmax+1, &readfds, NULL, NULL, NULL);
		for(i = 0; i<=fdmax; i++) {
			if (FD_ISSET(i,&readfds))
			{
				if(i == listener) {
					client = accept(listener, (struct sockaddr *) &client_addr, &client_len);
					request_handler(client);
				}
				else {
					// Incoming data from user
				}
			}
		}
	}
	return 0;
}