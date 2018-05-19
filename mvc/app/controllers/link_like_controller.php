<?php
namespace Controller;
class LinkLikeController {
	public function get($slug) {
		if(!isset($_SESSION['user']))
			header("Location: /discuss/".$slug);
		else
		{
			$user = $_SESSION['user'];
			\Model\LinkLikesModel::like($user, $slug);
			header("Location: /discuss/".$slug);
		}
	}
}