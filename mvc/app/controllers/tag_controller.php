<?php
namespace Controller;
class TagController {
	public function get ($slug) {

		if(isset($_SESSION['user']))
			$user = $_SESSION['user'];
		else
			$user = "";
		$posts = \Model\TagModel::getLinksByTag($slug);
		echo \View\Loader::make() -> render('templates/tag.twig' , array("user" => $user, "tag" => $slug, "rows" => $posts,));
	}
}