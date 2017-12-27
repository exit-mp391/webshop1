<?php include 'header.layout.php'; ?>

<?php
require_once './Product.class.php';
require_once './User.class.php';
$p = new Product();
$u = new User();

if ( isset($_GET['page']) ) {
	$page = $_GET['page'];
} else {
	$page = 1;
}

$per_page = 8;

if(isset($_POST['delete'])) {
	$p->delete($_POST['product_id']);
}

// $products = $p->all();
$products = $p->paginate($page, $per_page);

$total_p = ceil( $p->num_prod()['num_prod'] / $per_page );

// var_dump($products);
?>


<?php include './search_bar.inc.php'; ?>


<div class="page-header">
	<h1>Proizvodi</h1>
</div>


<div class="row">

	<?php foreach($products as $product): ?>

		<div class="col-md-3">


			<div class="product-card clearfix">
				<?php if($u->is_admin()): ?>
					<div class="product-admin-menu">
						<form action="" method="post">
							<input type="hidden" name="product_id" value="<?php echo $product['id']; ?>" />
							<button class="btn btn-sm btn-danger" type="submit" name="delete">Delete</button>
							<a class="btn btn-sm btn-info" href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
						</form>

					</div>
				<?php endif; ?>
				<a class="product-card-link" href="product_details.php?product_id=<?php echo $product['id']; ?>">
					<div class="img">
						<img src="<?php echo $product['img']; ?>" />
					</div>
					<h4><?php echo $product['title']; ?></h4>
					<div class="price pull-right">
						<?php echo number_format($product['price'], 2, '.', ','); ?> RSD
					</div>
				</a>
			</div>


		</div>

	<?php endforeach; ?>
</div>

<div class="row">
	<div class="col-md-12 pagination-container">

		<nav>
			<ul class="pagination">
				<?php
				for( $i = 1; $i <= $total_p; $i++) {
					if ( $page == $i ) {
						$active = "class='active'";
					} else {
						$active = "";
					}
					echo "<li $active><a href='index.php?page=$i'>$i</a></li>";
				}
				?>
			</ul>
		</nav>

	</div>
</div>

<?php include 'footer.layout.php'; ?>
