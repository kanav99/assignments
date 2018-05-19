<?php
namespace Model;
class TagModel {
	public static function getTagsById ($id) {
		$db = \DB::get_instance();
		$q = $db -> prepare("SELECT tag FROM tags WHERE url_id = ?");
		$q -> execute([$id]);
		$rows = $q -> fetchAll();
		return $rows;
	}
	public static function getLinksByTag ($tag) {
		$db = \DB::get_instance();
		$q = $db -> prepare ("SELECT * FROM links WHERE id IN (SELECT url_id FROM tags WHERE tag = ?)");
		$q -> execute([$tag]);
		$rows = $q -> fetchAll();
		return $rows;
	}
}