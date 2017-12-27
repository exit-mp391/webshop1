<?php

if( ! isset($_POST['search']) ) {
  header("Location: index.php");
}

?>

<?php include 'header.layout.php'; ?>

<?php
require_once './Product.class.php';
require_once './User.class.php';
$p = new Product();
$u = new User();

if(isset($_POST['delete'])) {
	$p->delete($_POST['product_id']);
}

$products = $p->search($_POST['search']);

// var_dump($products);
?>


<?php include './search_bar.inc.php'; ?>


<div class="page-header">
	<h1>Search results for "<?php echo $_POST['search']; ?>"</h1>
</div>


<div class="row">

	<?php foreach($products as $product): ?>

		<div class="col-md-3">

			<a class="product-card-link" href="product_details.php?product_id=<?php echo $product['id']; ?>">
				<div class="product-card clearfix">
					<?php if($u->is_admin()): ?>
						<div class="product-admin-menu">
							<form action="" method="post">
								<input type="hidden" name="product_id" value="<?php echo $product['id'] ?>">
								<button class="btn btn-sm btn-danger" type="submit" name="delete">Delete</button>
							</form>
						</div>
					<?php endif; ?>
					<img src="<?php echo $product['img'] ?>">
					<h4><?php echo $product['title']; ?></h4>
					<div class="price pull-right">
						<?php echo number_format($product['price'], 2, '.', ','); ?> RSD
					</div>
				</div>
			</a>

		</div>

	<?php endforeach; ?>
</div>

<?php include 'footer.layout.php'; ?>
