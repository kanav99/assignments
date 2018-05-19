<?php
namespace Controller;
class NewController {
	public function get () {
		if(isset($_SESSION['user']) && $_SESSION['user'] != '')
			echo \View\Loader::make()->render('templates/new.twig',array("user" => $_SESSION['user']));
		else
			header("Location: /login/");
	}
	public function post () {
		if (isset($_SESSION['user'])) {
			$title = $_POST['title'];
			$url = $_POST['url'];
			$author = $_SESSION['user'];
			$tags = explode(',', $_POST['tags']);
			$id = \Model\LinkModel::add($author, $url, $title, $tags);
			header("Location: /discuss/".$id);
		}
	}
}