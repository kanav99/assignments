<?php
namespace Controller;
class FollowController {
	public function get ($slug) {
		if(!isset($_SESSION['user'])) {
			header("Location: /user/".$slug);
		}
		else {
			$user = $_SESSION['user'];
			\Model\FollowModel::follow($user,$slug);
			header("Location: /user/".$slug);
		}
	}
}