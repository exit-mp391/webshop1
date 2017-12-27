<?php

class Product {
	public $db;
	public $img_path;

	function __construct() {
		$this->db = require './db.inc.php';
		$this->img_path = './img/product_images/';
	}

	public function make_dir() {
		if ( ! file_exists($this->img_path) ) {
			mkdir($this->img_path, true);
		}
	}

	public function all() {
		$q_get_all = $this->db->prepare("
			SELECT *
			FROM `products`
			ORDER BY `id` DESC
		");
		$q_get_all->execute();
		return $q_get_all->fetchAll();
	}

	public function one($id) {
		$q_get_one = $this->db->prepare("
			SELECT *
			FROM `products`
			WHERE `id` = :id
		");
		$q_get_one->execute([
			':id' => $id
		]);
		return $q_get_one->fetch();
	}

	public function fromCategory($cat_id) {
		$q_get_from_category = $this->db->prepare("
			SELECT *
			FROM `products`
			WHERE `category_id` = :cat_id
		");
		$q_get_from_category->execute([
			':cat_id' => $cat_id
		]);
		return $q_get_from_category->fetchAll();
	}

	public function add_to_cart($product_id, $quantity) {
		require_once './Helper.class.php';
		require_once './User.class.php';
		// Ukoliko korisnik nije ulogovan obustavljamo operaciju
		if ( ! User::is_logged_in()) {
			return false;
		}

		// Proveravamo da li je ovaj korisnik vec dodao ovaj proizvod
		$q_check = $this->db->prepare("
			SELECT *
			FROM `carts`
			WHERE `user_id` = :user_id
			AND `product_id` = :product_id
		");
		$q_check->execute([
			':user_id' => Helper::get_id(),
			':product_id' => $product_id
		]);

		if ($q_check->rowCount() > 0) {
			// Ulogovani korisnik je vec ima ovaj proizvod u korpi
			// Samo povecavamo kolicinu
			$cart_item = $q_check->fetch();
			$q_update_quantity = $this->db->prepare("
				UPDATE `carts`
				SET `quantity` = :new_quantity
				WHERE `user_id` = :user_id
				AND `product_id` = :product_id
			");
			return $q_update_quantity->execute([
				':new_quantity' => $cart_item['quantity'] + $quantity,
				':user_id' => Helper::get_id(),
				':product_id' => $product_id
			]);
		} else {
			// Dodajemo novi proizvod
			$q_add_to_cart = $this->db->prepare("
				INSERT INTO `carts`
				(`user_id`, `product_id`, `quantity`)
				VALUES
				(:user_id, :product_id, :quantity)
			");
			return $q_add_to_cart->execute([
				':user_id' => Helper::get_id(),
				':product_id' => $product_id,
				':quantity' => $quantity
			]);
		}

	}

	public function get_cart() {
		require_once './Helper.class.php';

		$q_get_cart_items = $this->db->prepare("
		SELECT
		`carts`.`id`,
		`products`.`title`,
		`carts`.`quantity`,
		`products`.`price`
		FROM `carts`, `products`
		WHERE `user_id` = :user_id
		AND `carts`.`product_id` = `products`.`id`
		");

		$q_get_cart_items->execute([
			':user_id' => Helper::get_id()
		]);

		return $q_get_cart_items->fetchAll();
	}

	public function update_quantity($cart_id, $new_quantity) {
		$q_update_quantity = $this->db->prepare("
			UPDATE `carts`
			SET `quantity` = :quantity
			WHERE `id` = :id
		");
		return $q_update_quantity->execute([
			':quantity' => $new_quantity,
			':id' => $cart_id
		]);
	}

	public function remove_from_cart($id) {
		$q_delete_item = $this->db->prepare("
			DELETE
			FROM `carts`
			WHERE `id` = :id
		");

		return $q_delete_item->execute([
			':id' => $id
		]);
	}

	public function num_of_prod_in_cart() {
		require_once './Helper.class.php';
		$q_num_of_products = $this->db->prepare("
			SELECT `carts`.*, `products`.*
			FROM `carts`, `products`
			WHERE `user_id` = :user_id
			AND `carts`.`product_id` = `products`.id
		");
		$q_num_of_products->execute([
			':user_id' => Helper::get_id()
		]);
		$info = $q_num_of_products->fetchAll();
		$total = 0;
		$total_price = 0;
		foreach ($info as $i) {
			$total += $i['quantity'];
			$total_price += $i['quantity'] * $i['price'];
		}
		return [
			'total' => $total,
			'total_price' => $total_price
		];
	}

	public function add($title, $desc, $cat_id, $price, $img) {
		$this->make_dir();

		$allowed_file_types = [
			'image/jpeg', 'image/png', 'image/gif'
		];

		if( ! in_array($img['type'], $allowed_file_types) ) {
			return false;
		}

		// File read/write
		// $file = file_get_contents('./img/product_images/pc.jpg');
		// file_put_contents('./img/test.jpg', "11231");

		// Provera velicine fajla
		if($img['size'] / 1024 / 1024 > 1) {
			return false;
		}

		$file_extension = pathinfo($img['name'], PATHINFO_EXTENSION);
		$file_name = str_replace(".", "", microtime(true)) . '-' . md5($img['name']) . '.' . $file_extension;
		$file_path = $this->img_path . $file_name;

		move_uploaded_file($img['tmp_name'], $file_path);

		$q_add_product = $this->db->prepare("
			INSERT INTO `products`
			(`title`, `description`, `category_id`, `price`, `img`)
			VALUES
			(:title, :description, :category_id, :price, :img)
		");

		return $q_add_product->execute([
			':title' => $title,
			':description' => $desc,
			':category_id' => $cat_id,
			':price' => $price,
			':img' => $file_path
		]);
	}

	public function delete($id) {
		$info = $this->one($id);

		// Brisanje slike proizvoda
		if( file_exists($info['img'])) {
			unlink($info['img']);
		}

		// Brisanje komentara
		$q_delete_comments = $this->db->prepare("
			DELETE
			FROM `comments`
			WHERE `product_id` = :product_id
		");
		$q_delete_comments->execute([
			':product_id' => $info['id']
		]);

		// Brisanje komentara
		$q_delete_comments = $this->db->prepare("
			DELETE
			FROM `carts`
			WHERE `product_id` = :product_id
		");
		$q_delete_comments->execute([
			':product_id' => $info['id']
		]);

		// Upit za brisanje proizvoda
		$q_delete_product = $this->db->prepare("
			DELETE
			FROM `products`
			WHERE `id` = :id
		");

		return $q_delete_product->execute([
			':id' => $id
		]);
	}

	public function search($search) {
		$q_search = $this->db->prepare("
			SELECT *
			FROM `products`
			WHERE `title` LIKE CONCAT('%', :search_title, '%')
			OR `description` LIKE CONCAT('%', :search_description, '%')
		");
		$q_search->execute([
			':search_title' => $search,
			':search_description' => $search
		]);
		return $q_search->fetchAll();
	}

	public function update($id, $title, $desc, $cat_id, $price, $img) {
		$this->make_dir();
		if($img['error'] == 0) {
			$allowed_file_types = [
				'image/jpeg', 'image/png', 'image/gif'
			];
			if( ! in_array($img['type'], $allowed_file_types) ) {
				return false;
			}
			// Provera velicine fajla
			if($img['size'] / 1024 / 1024 > 1) {
				return false;
			}
			$file_extension = pathinfo($img['name'], PATHINFO_EXTENSION);
			$file_name = str_replace(".", "", microtime(true)) . '-' . md5($img['name']) . '.' . $file_extension;
			$file_path = $this->img_path . $file_name;

			move_uploaded_file($img['tmp_name'], $file_path);
		} else {
			$product_info = $this->one($id);
			$file_path = $product_info['img'];
		}

		$q_add_product = $this->db->prepare("
			UPDATE `products`
			SET `title` = :title,
			`description` = :description,
			`category_id` = :category_id,
			`price` = :price,
			`img` = COALESCE(:img, `img`)
			WHERE `id` = :id
		");

		return $q_add_product->execute([
			':id' => $id,
			':title' => $title,
			':description' => $desc,
			':category_id' => $cat_id,
			':price' => $price,
			':img' => $file_path
		]);
	}

	public function paginate($page = 1, $per_page = 10) {
		$start = ($page - 1) * $per_page;

		$q_get = $this->db->prepare("
			SELECT *
			FROM `products`
			LIMIT $start, $per_page
		");

		$q_get->execute();
		return $q_get->fetchAll();
	}

	public function num_prod() {
		$q_num_prod = $this->db->prepare("
			SELECT count(*) as num_prod
			FROM `products`
		");
		$q_num_prod->execute();
		return $q_num_prod->fetch();
	}

	public function paginate_cat($cat_id, $page = 1, $per_page = 10) {
		$start = ($page - 1) * $per_page;

		$q_get = $this->db->prepare("
			SELECT *
			FROM `products`
			WHERE `category_id` = :cat_id
			LIMIT $start, $per_page
		");

		$q_get->execute([
			':cat_id' => $cat_id
		]);
		return $q_get->fetchAll();
	}

	public function num_prod_cat($cat_id) {
		$q_num_prod = $this->db->prepare("
			SELECT count(*) as num_prod
			FROM `products`
			WHERE `category_id` = :cat_id
		");
		$q_num_prod->execute([
			':cat_id' => $cat_id
		]);
		return $q_num_prod->fetch();
	}
}
