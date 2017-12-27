<?php require './protect.inc.php'; ?>
<?php include './header.layout.php'; ?>

<?php
include_once './Messages.class.php';
$m = new Messages();

if(isset($_POST['message_id_to_delete'])) {
	$m->delete($_POST['message_id_to_delete']);
}

$messages = $m->all();

?>

<div class="page-header">
	<h1>Messages</h1>
</div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>From</th>
			<th>Subject</th>
			<th>Date</th>
			<th>Actions</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach($messages as $msg): ?>
			<tr>
				<td><?php echo $msg['username']; ?></td>
				<td>
					<a href="message.php?id=<?php echo $msg['id']; ?>">
						<?php
						if(is_null($msg['date_read'])) {
							echo "<strong>{$msg['subject']}</strong>";
						} else {
							echo $msg['subject'];
						}
						?>
					</a>
				</td>
				<td><?php echo $msg['date_sent']; ?></td>
				<td>
					<form action="" method="post">
						<input type="hidden" name="message_id_to_delete" value="<?php echo $msg['id']; ?>">
						<button type="submit">Delete</button>
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>

</table>

<?php include './footer.layout.php'; ?>
