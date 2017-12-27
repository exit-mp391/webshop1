<?php require './protect.inc.php'; ?>
<?php include './header.layout.php'; ?>

<?php

require_once './Messages.class.php';
$m = new Messages();
$messages = $m->sent_messages();

?>

<div class="page-header">
  <h1>Sent Messages</h1>
</div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>To</th>
			<th>Subject</th>
			<th>Date</th>
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
			</tr>
		<?php endforeach; ?>
	</tbody>

</table>

<?php include './footer.layout.php'; ?>
