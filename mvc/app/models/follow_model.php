<?php
namespace Model;
class FollowModel {
	public static function fromFollowed ($user) {
		$db = \DB::get_instance();
		$q = $db -> prepare("SELECT * FROM links WHERE author IN (SELECT followed FROM follows WHERE follower = ?)");
		$q -> execute([$user]);
		$rows = $q -> fetchAll();
		return $rows;
	}
	public static function followers ($user) {
		$db = \DB::get_instance();
		$q = $db -> prepare("SELECT count(*) FROM follows WHERE followed = ?");
		$q -> execute([$user]);
		$row = $q -> fetch();
		$count = $row[0];
		return $count;
	}
	public static function check ($follower, $followed) {
		$db = \DB::get_instance();
		$q = $db -> prepare("SELECT * FROM follows WHERE follower = ? AND followed = ?");
		$q -> execute([$follower, $followed]);
		$row = $q -> fetch();
		if($row != NULL)
			return true;
		return false;
	}
	public static function follow ($follower, $followed) {
		if (!FollowModel::check($follower,$followed)) {
			$db = \DB::get_instance();
			$q = $db -> prepare("INSERT INTO follows (follower,followed) VALUES (?,?) ");
			$q -> execute([$follower,$followed]);
		}
	}
	public static function unfollow ($follower, $followed) {
		if(FollowModel::check($follower,$followed)) {
			$db = \DB::get_instance();
			$q = $db -> prepare("DELETE FROM follows WHERE follower = ? AND followed = ?");
			$q -> execute([$follower,$followed]);

		}
	}
}