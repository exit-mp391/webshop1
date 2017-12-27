<?php

class Helper {

	public static function session_start() {
		if ( !isset($_SESSION) ) {
			session_start();
		}
	}

	public static function get_id() {
		if ( !isset($_SESSION) ) {
			session_start();
		}

		if (isset($_SESSION['id'])) {
			return $_SESSION['id'];
		} else {
			return false;
		}
	}

	public static function success($message, $title = "Success!") {
		echo "
			<div class='alert alert-success'>
				<span class='glyphicon glyphicon-ok-sign'></span>
				<b>{$title} </b>
				{$message}
			</div>
		";
	}

	public static function danger($message, $title = "Error!") {
		echo "
			<div class='alert alert-danger'>
				<span class='glyphicon glyphicon-remove-sign'></span>
				<b>{$title} </b>
				{$message}
			</div>
		";
	}

}
