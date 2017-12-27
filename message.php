<?php require './protect.inc.php'; ?>

<?php
include_once './Messages.class.php';
$m = new Messages();
$message = $m->one($_GET['id']);

?>

<?php include './header.layout.php'; ?>


<div class="page-header">
	<h1>
    <?php
      if (is_null($message['subject'])) {
        echo "(no subject)";
      } else {
        echo $message['subject'];
      }
    ?>
  </h1>
</div>

<div class="row">
  <div class="col-md-12">
    <strong><?php echo $message['username']; ?></strong>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <?php echo $message['message']; ?>
  </div>
</div>


<?php include './footer.layout.php'; ?>
