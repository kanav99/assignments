<?php
namespace Controller;
class UnfollowController {
	public function get ($slug) {
		if(!isset($_SESSION['user'])) {
			header("Location: /user/".$slug);
		}
		else {
			$user = $_SESSION['user'];
			\Model\FollowModel::unfollow($user,$slug);
			header("Location: /user/".$slug);
		}
	}
}