<?php
namespace Controller;
class IndexController {
	public function get() {
		if(isset($_SESSION['user']))
			$user = $_SESSION['user'];
		else
			$user = "";

		$new = \Model\LinkModel::ten_new();
		$popular = \Model\LinkModel::ten_popular();
		echo \View\Loader::make()->render('templates/index.twig',array('new' => $new, 'user' => $user, "popular" => $popular,));
	}
} 