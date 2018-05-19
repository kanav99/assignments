<?php
namespace Controller;
class LogoutController {
	public static function get () {
		session_destroy();
		header("Location: /");
	}
}