<?php
namespace Model;
class LinkModel {
	public static function all () {
		$db = \DB::get_instance();
		$q = $db -> prepare ("SELECT * FROM links");
		$q -> execute([]);
		$rows = $q -> fetchAll();
	}
	public static function ten_new () {
		$db =\DB::get_instance();
		$q = $db -> prepare ("SELECT count(*) FROM links");
		$q -> execute([]);
		$row = $q -> fetch();
		$count = $row[0];
		$index = $count - 10;
		$q = $db -> prepare ("SELECT * FROM links WHERE id > ?");
		$q -> execute([ $index ]);
		$rows = $q -> fetchAll();
		return $rows;
	}
	public static function find ($id) {
		$db = \DB::get_instance();
		$q = $db->prepare("SELECT * FROM links WHERE id = ?");
		$q->execute([$id]);
		$row = $q->fetch();
		return $row;
	}
	public static function compare_popular ( $r1 , $r2 ) {
		$t0 = strtotime("2018-03-15 10:10:00");
		$a = (2 * $r1['likes'] + 3 * $r1['comments']) * (time() - strtotime($r2['time']));
		$b = (2 * $r2['likes'] + 3 * $r2['comments']) * (time() - strtotime($r1['time']));
		if ($a > $b)
			return -1;
		else
			return 1;
	}
	public static function compare_likes ( $r1 , $r2 ) {
		if( $r1['likes'] == $r2['likes'] ) {
			return ($r1['time'] > $r2['time']) ? -1 : 1;
		}
		return ( $r1['likes'] < $r2['likes'] ) ? 1 : -1;
	}
	public static function ten_popular () {
		$db = \DB::get_instance();
		$q = $db -> prepare ("SELECT * FROM links");
		$q -> execute();
		$rows = $q -> fetchAll();
		usort($rows,"\Model\LinkModel::compare_popular");
		return array_slice($rows, 0, 10);
	}
	public static function ten_liked () {
		$db =\DB::get_instance();
		$q = $db -> prepare ("SELECT * FROM links");
		$q -> execute();
		$rows = $q -> fetchAll();
		usort($rows,"\Model\LinkModel::compare_likes");
		return array_slice($rows, 0, 10);
	}
	public static function add ($author, $url, $title, $tags) {
		$db = \DB::get_instance();
		$q = $db->prepare("INSERT INTO links(url,author,title) VALUES (?,?,?)");
		$q->execute([$url, $author, $title]);
		$id = $db->lastInsertId();
		foreach ($tags as $key => $value) {
			$q = $db -> prepare("INSERT INTO tags (url_id, tag) VALUES (?,?)");
			$q -> execute([$id,$value]);
		}
		return $id;
	}
	public static function getByUser ($user) {
		$db = \DB::get_instance();
		$q = $db -> prepare ("SELECT * FROM links WHERE author = ?");
		$q -> execute([$user]);
		$rows = $q -> fetchAll();
		return $rows;
	}
}