<?php

include './User.class.php';

if( ! User::is_logged_in() ) {
	header("Location: login.php");
	die();
}