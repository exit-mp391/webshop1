<?php require './protect.inc.php'; ?>

<?php

if( isset($_POST['username']) && $_POST['message'] ) {
	require_once './Messages.class.php';
	$m = new Messages();
	$res = $m->add($_POST['username'], $_POST['subject'], $_POST['message']);

}

?>

<?php include './header.layout.php'; ?>

<?php
	if (isset($res)) {
		require_once './Helper.class.php';
		if($res) {
			Helper::success('Message sent.');
		} else {
			Helper::danger('Failed to send message. Check username.');
		}
	}
?>

<div class="page-header">
	<h1>New Message</h1>
</div>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form method="post">
			<div class="form-group">
				<label for="inputUsername">Username</label>
				<input type="text" name="username" class="form-control" id="inputUsername" placeholder="Username">
			</div>
			<div class="form-group">
				<label for="inputSubject">Subject</label>
				<input type="text" name="subject" class="form-control" id="inputSubject" placeholder="Message subject">
			</div>
			<div class="form-group">
				<label for="inputMessage">Message</label>
				<textarea name="message" class="form-control" id="inputMessage" rows="3" placeholder="Message text..."></textarea>
			</div>
			<button type="submit" class="btn btn-primary pull-right">Send Message</button>
		</form>
	</div>
</div>

<?php include './footer.layout.php'; ?>
