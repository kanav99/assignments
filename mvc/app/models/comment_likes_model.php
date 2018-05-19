<?php
namespace Model;
class CommentLikesModel {
	public static function check ($liker, $comment_id) {
		$db = \DB::get_instance();
		$q = $db->prepare("SELECT * FROM comment_likes WHERE liker = ? AND comment_id = ?");
		$q->execute([$liker,$comment_id]);
		$row = $q->fetch();
		if ($row != NULL) {
			return true;
		}
		return false;
	}
	public static function like ($liker, $comment_id) {
		$db = \DB::get_instance();
		if (CommentLikesModel::check($liker, $comment_id))
			return;
		$q = $db->prepare("INSERT INTO comment_likes(liker,comment_id) VALUES (?,?)");
		$q->execute([$liker,$comment_id]);
		$q = $db->prepare("UPDATE comments SET likes = likes + 1 WHERE id = ?");
		$q->execute([$comment_id]);
	}
	public static function unlike ($liker, $comment_id) {
		$db = \DB::get_instance();
		if (!CommentLikesModel::check($liker, $comment_id))
			return;
		$q = $db->prepare("DELETE FROM comment_likes WHERE liker = ? AND comment_id = ?");
		$q->execute([$liker,$comment_id]);
		$q = $db->prepare("UPDATE comments SET likes = likes - 1 WHERE id = ?");
		$q->execute([$comment_id]);
	}
}