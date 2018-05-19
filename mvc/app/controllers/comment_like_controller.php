<?php
namespace Controller;
class CommentLikeController {
	public function get ($s1 , $s2) {
		if(!isset($_SESSION['user']))
			header("Location: /discuss/".$s2);
		else
		{
			$user = $_SESSION['user'];
			\Model\CommentLikesModel::like($user, $s1);
			header("Location: /discuss/".$s2);
		}
	}
}