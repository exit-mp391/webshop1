<?php

class Comment {
	public $db;

	function __construct() {
		$this->db = require './db.inc.php';
	}

	// public function get($product_id) {
	// 	$q_get_comments_for_product = $this->db->prepare("
	// 		SELECT * FROM `comments`
	// 		WHERE `product_id` = :product_id
	// 	");
	// 	$q_get_comments_for_product->execute([
	// 		':product_id' => $product_id
	// 	]);
	// 	return $q_get_comments_for_product->fetchAll();
	// }

	public function get($product_id) {
		$q_get_comments_for_product = $this->db->prepare("
			SELECT
				`comments`.*,
				`users`.`username`
			FROM `comments`, `users`
			WHERE `comments`.`product_id` = :product_id
			AND `comments`.`user_id` = `users`.`id`
			ORDER BY `date_posted` DESC
		");
		$q_get_comments_for_product->execute([
			':product_id' => $product_id
		]);
		return $q_get_comments_for_product->fetchAll();
	}

	public function add($user_id, $product_id, $comment) {
		$q_insert_comment = $this->db->prepare("
			INSERT INTO `comments`
			(
				`user_id`,
				`product_id`,
				`comment`
			)
			VALUES (
				:user_id,
				:product_id,
				:comment
			)
		");
		$q_insert_comment->execute([
			':user_id' => $user_id,
			':product_id' => $product_id,
			':comment' => $comment
		]);
	}

	public function delete($id) {
		$q_delete_comment = $this->db->prepare("
			DELETE
			FROM `comments`
			WHERE `id` = :id
		");
		return $q_delete_comment->execute([
			':id' => $id
		]);
	}
}
