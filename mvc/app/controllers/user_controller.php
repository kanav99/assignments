<?php
namespace Controller;
class UserController {
	public function get ($slug) {
		if(isset($_SESSION['user']))
			$user = $_SESSION['user'];
		else
			$user = "";
		$posts = \Model\LinkModel::getByUser($slug);
		$comments = \Model\CommentsModel::getByUser($slug);
		$rating = \Model\UserModel::rating($slug);
		$followers = \Model\FollowModel::followers($slug);
		$check = \Model\FollowModel::check($user,$slug);
		
		echo \View\Loader::make()->render('templates/user.twig',array('user' => $user, 'comments' => $comments , 'posts' => $posts, 'rating' => $rating, 'profile' => $slug,"followers" => $followers,"check" => $check,));		
	}
}