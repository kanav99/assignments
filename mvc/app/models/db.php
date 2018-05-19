<?php
require "../config/database.php";
class DB
{
	private static $instance;
	public static function get_instance() 
	{
		GLOBAL $db_username;
		GLOBAL $db_password;
		if(!self::$instance) {
			self::$instance = new PDO("mysql:host=localhost;dbname=reredit", \Config::$db_username, \Config::$db_password);
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		return self::$instance;
	}
}