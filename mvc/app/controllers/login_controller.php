<?php
namespace Controller;
class LoginController {
	public function get() {
		if(!isset($_SESSION['user']))
			echo \View\Loader::make()->render('templates/login.twig',array( "message" => ""));
		else
			header("Location: /");
	}
	public function post() {
		$user = $_POST['user'];
		$pass = $_POST['pwd'];
		if($user === "")
			header("Location: /login");
		$bool = \Model\UserModel::exists($user);
		if ($bool) {
			echo \View\Loader::make()->render('templates/login.twig',array( "message" => "User Already exists!"));
		}
		else {
			\Model\UserModel::register($user, $pass);
			$_SESSION['user'] = $user;
			header("Location: /home/");
		}
	}
}