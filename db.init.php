<?php

$db = require './db.inc.php';

/* PREPARATIONS */
$q_create_users_table = $db->prepare("
	CREATE TABLE IF NOT EXISTS `users`
	(
		`id` int auto_increment,
		`username` varchar(30),
		`email` varchar(255),
		`password` varchar(255),
		`account_type` enum('admin', 'user') DEFAULT 'user',
		PRIMARY KEY (`id`)
	)
");
$q_insert_admin_account = $db->prepare("
	INSERT INTO `users`
	(`username`, `email`, `password`, `account_type`)
	VALUES
	(:username, :email, :password, :account_type)
");
$q_get_users = $db->prepare("
	SELECT *
	FROM `users`
");
$q_create_categories_table = $db->prepare("
	CREATE TABLE IF NOT EXISTS `categories`
	(
		`id` int auto_increment,
		`title` varchar(255),
		PRIMARY KEY (`id`)
	)
");
$q_create_products_table = $db->prepare("
	CREATE TABLE IF NOT EXISTS `products`
	(
		`id` int auto_increment,
		`title` varchar(255),
		`description` text,
		`category_id` int,
		`price` varchar(255),
		`img` varchar(255),
		PRIMARY KEY (`id`)
	)
");
$q_create_messages_table = $db->prepare("
	CREATE TABLE IF NOT EXISTS `messages`
	(
		`id` int auto_increment,
		`from_id` int,
		`to_id` int,
		`subject` varchar(255) DEFAULT NULL,
		`message` text,
		`date_sent` datetime DEFAULT CURRENT_TIMESTAMP,
		`date_read` datetime DEFAULT NULL,
		PRIMARY KEY (`id`)
	)
");
$q_create_comments_table = $db->prepare("
	CREATE TABLE IF NOT EXISTS `comments`
	(
		`id` int auto_increment,
		`user_id` int,
		`product_id` int,
		`comment` text,
		`date_posted` datetime DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
	)
");
$q_create_cart_table = $db->prepare("
	CREATE TABLE IF NOT EXISTS `carts`
	(
		`id` int auto_increment,
		`user_id` int,
		`product_id` int,
		`quantity` int,
		PRIMARY KEY (`id`)
	)
");



/* EXECUTION */
$q_create_users_table->execute();
$q_get_users->execute();
if($q_get_users->rowCount() == 0) {
	$q_insert_admin_account->execute([
		':username' => 'admin',
		':email' => 'admin@test.com',
		':password' => md5("123"),
		':account_type' => 'admin'
	]);
}
$q_create_categories_table->execute();
$q_create_products_table->execute();
$q_create_messages_table->execute();
$q_create_comments_table->execute();
$q_create_cart_table->execute();
