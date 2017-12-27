<?php

include_once './Product.class.php';
include_once './Comment.class.php';
include_once './User.class.php';
include_once './Helper.class.php';

$p = new Product();
$product = $p->one($_GET['product_id']);

$c = new Comment();

if( isset($_POST['btn_del_com']) ) {
	$c->delete($_POST['com_id']);
}

if( isset($_POST['comment']) ) {
	$c->add(Helper::get_id(), $_GET['product_id'], $_POST['comment']);
}

$comments = $c->get($_GET['product_id']);

if (isset($_POST['add_to_cart']) && isset($_POST['product_id']) && isset($_POST['quantity']) ) {
	$res = $p->add_to_cart($_POST['product_id'], $_POST['quantity']);
}

?>

<?php include 'header.layout.php'; ?>

<?php

if (isset($res)) {
	if ($res) {
		Helper::success('Product added to cart.');
	} else {
		Helper::danger('Failed to add product to cart.');
	}
}

?>


<div class="page-header">
	<h1><?php echo $product['title']; ?></h1>
</div>

<div class="row product-details">

	<div class="col-md-4">
		<img src="<?php echo $product['img'] ?>">
	</div>

	<div class="col-md-8">
		<div class="description">
			<?php echo $product['description']; ?>
		</div>
		<div class="price">
			<?php echo number_format($product['price'], 2, '.', ','); ?> RSD
		</div>
		<div class="add-to-cart clearfix">
			<form action="" method="post">
				<div class="input-group pull-right">
					<input type="number" name="quantity" class="form-control" value="1">
					<input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>">
					<span class="input-group-btn">
						<button name="add_to_cart" class="btn btn-primary">Add to cart</button>
					</span>
				</div>
			</form>
		</div>

	</div>

</div>

<div class="row">
	<div class="col-md-12">
		<h1>Comments</h1>
	</div>
</div>

<?php if(count($comments) <= 0): ?>
	<div class="row">
		<div class="col-md-12">
			<em>There are no comments for this product yet.</em>
		</div>
	</div>
<?php endif; ?>

<?php if(User::is_logged_in()): ?>
	<div class="row">
		<div class="col-md-12 comment-form">
			<form action="" method="POST">
				<textarea name="comment" placeholder="Tekst komentara..."></textarea>
				<button type="submit" class="btn btn-primary pull-right">Post comment</button>
			</form>
		</div>
	</div>
<?php else: ?>
	<div class="row">
		<div class="col-md-12">
			<em>Please login to leave comment.</em>
		</div>
	</div>
<?php endif; ?>

<div class="row">
	<div class="col-md-12">

		<!-- <div class="comments"> -->

		<?php foreach($comments as $comment): ?>
			<div class="comment clearfix">
				<form action="" method="post">
					<input type="hidden" name="com_id" value="<?php echo $comment['id']; ?>">
					<button data-id="<?php echo $comment['id']; ?>" id="btn_del_com" type="submit" name="btn_del_com" class="btn btn-sm btn-danger btn-del-com">Delete</button>
				</form>
				<div class="comment-text">
					<?php echo $comment['comment']; ?>
				</div>
				<div class="comment-info pull-right">
					Posted by <?php echo $comment['username']; ?>, <?php echo $comment['date_posted']; ?>
				</div>
			</div>
		<?php endforeach; ?>

		<!-- </div> -->

	</div>
</div>

<?php include 'footer.layout.php'; ?>
