<?php
namespace Controller;
class HomeController {
	public function get () {
		if(isset($_SESSION['user']) && $_SESSION['user'] != '') {
			$user = $_SESSION['user'];
			$followers_posts = \Model\FollowModel::fromFollowed ($user);
			echo \View\Loader::make()->render('templates/home.twig',array("user" => $user,"posts" => $followers_posts,));
		}
		else
			header("Location: /login/");
	}
	public function post () {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$exists = \Model\UserModel::auth($username,$password);
		if( $exists ) {
			$_SESSION['user'] = $username;
			echo \View\Loader::make()->render('templates/home.twig',array("user" => $username));
		}
		else {
			header("Location: /login");
		}
	}
}