<?php include 'header.layout.php'; ?>

<?php
	require_once './Product.class.php';
	$p = new Product();

	if ( isset($_GET['page']) ) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

	$per_page = 8;

	$products = $p->paginate_cat($_GET['cat_id'], $page, $per_page);

	$total_p = ceil( $p->num_prod_cat($_GET['cat_id'])['num_prod'] / $per_page );

?>

<div class="page-header">
	<h1>Proizvodi</h1>
</div>

<div class="row">

	<?php foreach($products as $product): ?>

		<div class="col-md-3">

			<a class="product-card-link" href="product_details.php?product_id=<?php echo $product['id']; ?>">
				<div class="product-card clearfix">
					<div class="img">
						<img src="<?php echo $product['img'] ?>">
					</div>
					<h4><?php echo $product['title']; ?></h4>
					<div class="price pull-right">
						<?php echo number_format($product['price'], 2, '.', ',');; ?> RSD
					</div>
				</div>
			</a>

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
					echo "<li $active><a href='products.php?cat_id=" . $_GET['cat_id'] . "&page=$i'>$i</a></li>";
				}
				?>
			</ul>
		</nav>

	</div>
</div>

<?php include 'footer.layout.php'; ?>
