<?php
namespace Model;
class LinkLikesModel {
	public static function check($user, $url_id) {
		$db = \DB::get_instance();
		$q = $db->prepare("SELECT * FROM link_likes WHERE liker = ? AND url_id = ?");
		$q->execute([$user,$url_id]);
		$row = $q->fetch();
		if ($row != NULL) {
			return true;
		}
		return false;
	}
	public static function like($user, $url_id) {
		$db = \DB::get_instance();
		if (LinkLikesModel::check($user, $url_id))
			return;
		$q = $db->prepare("INSERT INTO link_likes(liker,url_id) VALUES (?,?)");
		$q->execute([$user,$url_id]);
		$q = $db->prepare("UPDATE links SET likes = likes + 1 WHERE id = ?");
		$q->execute([$url_id]);
	}
	public static function unlike($user, $url_id) {
		$db = \DB::get_instance();
		if (!LinkLikesModel::check($user, $url_id))
			return;
		$q = $db->prepare("DELETE FROM link_likes WHERE liker = ? AND url_id = ?");
		$q->execute([$user,$url_id]);
		$q = $db->prepare("UPDATE links SET likes = likes - 1 WHERE id = ?");
		$q->execute([$url_id]);
	}
}