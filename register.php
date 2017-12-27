<?php include './header.layout.php'; ?>

<?php

require_once './Helper.class.php';

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_repeat'])) {

	if($_POST['password'] != $_POST['password_repeat']) {
		Helper::danger('Passwords dont match.');
	} else {
		require_once './User.class.php';
		$u = new User();
		$res = $u->register($_POST['username'], $_POST['email'], $_POST['password']);

		if($res) {
			Helper::success('Registration successfull.');
		} else {
			Helper::danger('Failed to regsiter user.');
		}
	}

}

?>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="page-header">
			<h1>Create account</h1>
		</div>

		<form action="" method="post">
			<div class="form-group">
				<label for="inputUsernameRegister">Username</label>
				<input type="text" name="username" class="form-control" id="inputUsernameRegister" placeholder="Username" required>
        <small id="usernameRegisterMessage">Choose your username.</small>
			</div>
      <div class="form-group">
				<label for="inputEmailRegister">E-mail</label>
				<input type="email" name="email" class="form-control" id="inputEmailRegister" placeholder="E-mail address" required>
        <small id="emailRegisterMessage">Type in your e-mail address.</small>
			</div>
      <div class="form-group">
				<label for="inputPassword">Password</label>
				<input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
        <small>Choose password.</small>
			</div>
      <div class="form-group">
				<label for="inputPasswordRepeat">Password again</label>
				<input type="password" name="password_repeat" class="form-control" id="inputPasswordRepeat" placeholder="Password repeat" required>
        <small>Type in the same password again.</small>
			</div>
			<button type="submit" class="btn btn-primary pull-right">Create account</button>
		</form>
	</div>
</div>

<?php include './footer.layout.php'; ?>
