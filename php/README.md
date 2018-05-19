# titbits
Pastebin Clone

Usage:
1. Make a database named ```titbits```.
2. Make two tables - ```userlist```, ```bit_table``` as-
	```
		CREATE TABLE `bit_table` (
		  `id` varchar(20) NOT NULL,
		  `title` varchar(500) NOT NULL,
		  `paste` varchar(10000) NOT NULL,
		  `private` tinyint(1) NOT NULL,
		  `owner` varchar(100) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		CREATE TABLE `userlist` (
		  `name` varchar(100) NOT NULL,
		  `username` varchar(100) NOT NULL,
		  `password` varchar(100) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
	```
3. Run the server.