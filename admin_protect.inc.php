<?php

include './User.class.php';

if( ! User::is_logged_in() ) {
	header("Location: login.php");
	die();
}

$u = new User();

if( ! $u->is_admin() ) {
  header("Location: index.php");
	die();
}
