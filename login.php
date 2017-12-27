<?php include 'header.layout.php'; ?>

<?php

include_once './User.class.php';
include_once './Helper.class.php';
$u = new User();

if ( isset($_POST['username']) && isset($_POST['password']) ) {
	$res = $u->login($_POST['username'], $_POST['password']);

	if ($res) {
		echo "
			<script>
				window.location = 'index.php';
			</script>
			";
	} else {
		Helper::danger("Wrong username and/or password.");
	}
}

?>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="page-header">
			<h1>Login</h1>
		</div>

		<form action="" method="post">
			<div class="form-group">
				<label for="inputUsername">Username</label>
				<input type="text" name="username" class="form-control" id="inputUsername" placeholder="Username">
			</div>
			<div class="form-group">
				<label for="inputPassword">Password</label>
				<input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
			</div>
			<button type="submit" class="btn btn-primary pull-right">Login</button>
		</form>
	</div>
</div>

<?php include 'footer.layout.php'; ?>
