<?php

class User {
	public $db;

	function __construct() {
		$this->db = require './db.inc.php';
	}

	public function login($username, $password) {
		$q_find_user = $this->db->prepare("
			SELECT *
			FROM `users`
			WHERE `username` = :username
			AND `password` = :password
		");
		$q_find_user->execute([
			':username' => $username,
			':password' => md5($password)
		]);

		if($q_find_user->rowCount() > 0) {
			require_once './Helper.class.php';
			Helper::session_start();
			$user = $q_find_user->fetch();
			$_SESSION['id'] = $user['id'];
			return true;
		} else {
			return false;
		}
	}

	public static function is_logged_in() {
		require_once './Helper.class.php';
		Helper::session_start();
		// var_dump($_SESSION);
		return isset($_SESSION['id']);
	}

	public static function log_out() {
		require_once './Helper.class.php';
		Helper::session_start();
		unset($_SESSION['id']);
	}

	public function info() {
		if(!$this->is_logged_in()) {
			return false;
		}

		require_once './Helper.class.php';

		$q_get_user_info = $this->db->prepare("
			SELECT *
			FROM `users`
			WHERE `id` = :id
		");
		$q_get_user_info->execute([
			':id' => Helper::get_id()
		]);
		return $q_get_user_info->fetch();
	}

	public function info_by_username($username) {
    $q_get_user = $this->db->prepare("
      SELECT *
      FROM `users`
      WHERE `username` = :username
    ");
    $q_get_user->execute([
      ':username' => $username
    ]);

    if( $q_get_user->rowCount() == 1) {
      return $q_get_user->fetch();
    } else {
			return false;
		}
  }

	public function info_by_email($email) {
    $q_get_user = $this->db->prepare("
      SELECT *
      FROM `users`
      WHERE `email` = :email
    ");
    $q_get_user->execute([
      ':email' => $email
    ]);

    if( $q_get_user->rowCount() == 1) {
      return $q_get_user->fetch();
    } else {
			return false;
		}
  }

	public function change_email($current_password, $new_email) {
		$user = $this->info();
		if($user['password'] != md5($current_password)) {
			return false;
		}

		$q_change_password = $this->db->prepare("
			UPDATE `users`
			SET `email` = :new_email
			WHERE `id` = :id
		");
		return $q_change_password->execute([
			':new_email' => $new_email,
			':id' => $user['id']
		]);
	}

	public function change_password($current_pwd, $new_pwd) {
		$user = $this->info();
		if($user['password'] != md5($current_pwd)) {
			return false;
		}

		$q_change_password = $this->db->prepare("
			UPDATE `users`
			SET `password` = :new_password
			WHERE `id` = :id
		");

		return $q_change_password->execute([
			':new_password' => md5($new_pwd),
			':id' => $user['id']
		]);
	}

	public function check_username($username) {
		$user = $this->info_by_username($username);

		return !! $user;
	}

	public function check_email($email) {
		$user = $this->info_by_email($email);

		return !! $user;
	}

	public function register($username, $email, $password) {
		$user = $this->info_by_username($username);
		if($user) {
			return false;
		}
		$q_register = $this->db->prepare("
			INSERT INTO `users`
			(`username`, `email`, `password`)
			VALUES
			(:username, :email, :password)
		");

		$res = $q_register->execute([
			':username' => $username,
			':email' => $email,
			':password' => md5($password)
		]);

		$user = $this->info_by_username($username);
		require_once './Helper.class.php';
		Helper::session_start();
		$_SESSION['id'] = $user['id'];
		return $res;
	}

	public function is_admin() {
		$user = $this->info();

		if($user['account_type'] == 'admin') {
			return true;
		} else {
			return false;
		}
	}

	public function buy() {
		require_once './Product.class.php';
		$p = new Product();
		$product_list = $p->get_cart();
		$user = $this->info();

		$email = "Spisak porucenih proizvoda:" . PHP_EOL;
		foreach ($product_list as $product) {
			$email .= $product['title'] . PHP_EOL;
		}
		$email .= PHP_EOL . PHP_EOL;
		$email .= "S postovanjem," . PHP_EOL;
		$email .= "naziv_prodavnice";

		mail($user['email'], "Successfull order", $email);
	}
}
