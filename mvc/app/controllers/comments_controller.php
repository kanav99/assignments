<?php
namespace Controller;
class CommentsController {
	public static function post($slug) {
		\Model\CommentsModel::addComment( $_SESSION['user'], $slug, $_POST['text']);
		header("Location: /discuss/".$slug);
	}
}