<?php
namespace Model;
class CommentsModel {
	public static function byURL ( $id ) {
		$db = \DB::get_instance();
		$q = $db -> prepare ("SELECT * FROM comments WHERE url_id = ?");
		$q -> execute([$id]);
		$rows = $q -> fetchAll();
		return $rows;
	}
	public static function getByUser ( $user ) {
		$db = \DB::get_instance();
		$q = $db -> prepare ("SELECT * FROM comments WHERE author = ?");
		$q -> execute([$user]);
		$rows = $q -> fetchAll();
		return $rows;
	}
	public static function addComment( $author, $link_id, $text ) {
		$db = \DB::get_instance();
		$q = $db -> prepare ("INSERT INTO comments(author, url_id, text) VALUES (?,?,?)");
		$q -> execute([$author, $link_id, $text]);
		$q = $db -> prepare ("UPDATE links SET comments = comments + 1 WHERE id = ?");
		$q -> execute([$link_id]);
	}
	public static function byURL_likes ($id) {
		$db = \DB::get_instance();
		$q = $db -> prepare ("SELECT * FROM comments WHERE url_id = ?");
		$q -> execute([$id]);
		$rows = $q -> fetchAll();
		usort($rows, "\Model\CommentsModel::compare_likes");
		return $rows;
	}
	public static function compare_likes ($r1, $r2) {
		if( $r1['likes'] == $r2['likes'] ) {
			return ($r1['time'] > $r2['time']) ? -1 : 1;
		}
		return ( $r1['likes'] < $r2['likes'] ) ? 1 : -1;
	}
}