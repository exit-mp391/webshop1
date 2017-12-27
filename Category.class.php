<?php

class Category {

	public $db;

	function __construct() {
		$this->db = require './db.inc.php';
	}

	public function all() {
		$q_get_all = $this->db->prepare("
			SELECT *, (
				SELECT count(*)
				FROM `products`
				WHERE `category_id` = `categories`.`id`
				) as count
			FROM `categories`
			ORDER BY `title` ASC
		");
		$q_get_all->execute();
		return $q_get_all->fetchAll();
	}

	public function one($id) {
		$q_get_one = $this->db->prepare("
			SELECT *
			FROM `categories`
			WHERE `id` = :id
		");
		$q_get_one->execute([
			':id' => $id
		]);
		return $q_get_one->fetch();
	}

}
