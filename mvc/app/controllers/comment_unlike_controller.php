<?php
namespace Controller;
class CommentUnlikeController {
	public function get ($s1 , $s2) {
		if(!isset($_SESSION['user']))
			header("Location: /discuss/".$s2);
		else
		{
			$user = $_SESSION['user'];
			\Model\CommentLikesModel::unlike($user, $s1);
			header("Location: /discuss/".$s2);
		}
	}
}