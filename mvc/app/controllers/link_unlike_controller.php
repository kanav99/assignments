<?php
namespace Controller;
class LinkUnlikeController {
	public function get ($slug) {
		if(!isset($_SESSION['user']))
			header("Location: /discuss/".$slug);
		else
		{
			$user = $_SESSION['user'];
			\Model\LinkLikesModel::unlike($user, $slug);
			header("Location: /discuss/".$slug);
		}
	}
}