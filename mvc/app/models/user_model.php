<?php
namespace Model;
class UserModel {
	public static function auth ( $user , $pass ) {
		$db = \DB::get_instance();
		$q = $db->prepare("SELECT * FROM users_list WHERE username = ? AND password = ?");
		$q->execute([$user,$pass]);
		$row = $q->fetch();
		if ($row != NULL) {
			return true;
		}
		return false;
	}
	public static function logout () {
		session_destroy();
	}
	public static function exists ($user) {
		$db = \DB::get_instance();
		$q = $db->prepare("SELECT * FROM users_list WHERE username = ?");
		$q -> execute([$user]);
		$row = $q->fetch();
		if ($row != NULL) {
			return true;
		}
		return false;
	}
	public static function register ($user , $pass) {
		$db = \DB::get_instance();
		$q = $db->prepare("INSERT INTO users_list(username, password) VALUES (? , ?)");
		$q -> execute([$user, $pass]);
	}
	public static function rating ( $user ) {
		$posts = \Model\LinkModel::getByUser($user);
		$comments = \Model\CommentsModel::getByUser($user);
		$rating = 0;
		foreach ($posts as $key => $post) {
			$rating = $rating + 5 * $post['likes'];
		}
		foreach ($comments as $key => $comment) {
			$rating = $rating + 3 * $comment['likes'];
		}
		return $rating;
	}
}