<?php
namespace Controller;

class ThreadController {
	public static function get ($slug) {

		if(isset($_SESSION['user']))
			$user = $_SESSION['user'];
		else
			$user = "";

		if (!isset($_GET['sort']))
			$sort = 0;
		else
			$sort = $_GET['sort'];

		$row = \Model\LinkModel::find($slug);
		
		if($row == NULL) {
			header("Location: ../");
		}
		else {
			if($sort == 0)
				$comments = \Model\CommentsModel::byURL($slug);
			else
				$comments = \Model\CommentsModel::byURL_likes($slug);

			$check = \Model\LinkLikesModel::check($user,$slug);
			for ($i=0; $i < sizeof($comments); $i++) { 
				$comments[$i]['liked'] = \Model\CommentLikesModel::check($user,$comments[$i]['id']);
			}
			$tags = \Model\TagModel::getTagsById($slug);
			echo \View\Loader::make() -> render('templates/discussion.twig' , array( "data" => $row, "comments" => $comments, "id" => $slug , "user" => $user, "check" => $check, "sort" => $sort,'tags' => $tags,));
		}
	}
}