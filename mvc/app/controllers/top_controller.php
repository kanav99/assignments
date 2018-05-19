<?php
namespace Controller;
class TopController {
	public function get () {
		if(isset($_SESSION['user']))
			$user = $_SESSION['user'];
		else
			$user = "";

		$rows = \Model\LinkModel::ten_liked();
		echo \View\Loader::make() -> render('templates/top.twig' , array( "rows" => $rows, "user" => $user,));
	}
}