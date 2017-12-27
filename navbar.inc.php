<?php
require_once './User.class.php';
require_once './Messages.class.php';
require_once './Product.class.php';

$u = new User();
$user_info = $u->info();
$m = new Messages();
$num_of_unread_msgs = $m->num_of_unread();
$p = new Product();
$cart_info = $p->num_of_prod_in_cart();

?>
<!-- .navbar-default -->
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="./">
				<span class="glyphicon glyphicon-shopping-cart"></span>
				WebShop
			</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">

				<li class="active"><a href="index.php">Products</a></li>

				<?php if(User::is_logged_in()): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							Messages
							<?php if($num_of_unread_msgs > 0): ?>
								<span class="badge">
									<?php echo $num_of_unread_msgs; ?>
								</span>
							<?php endif; ?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="new_message.php">New message</a></li>
							<li><a href="messages.php">All messages</a></li>
							<li><a href="sent_messages.php">Sent messages</a></li>
						</ul>
					</li>
				<?php endif; ?>

				<li><a href="kontakt.php">Contact</a></li>

			</ul>

			<ul class="nav navbar-nav navbar-right">

				<?php if($u->is_admin()): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							Admin menu
							<span class="caret"></span></a>
							<ul class="dropdown-menu">
									<li class="dropdown-header">Products</li>
									<li><a href="add_product.php">Add new</a></li>
							</ul>
						</a>
					</li>
				<?php endif; ?>

				<li><a
					data-toggle="tooltip"
					data-placement="bottom"
					title="<?php echo number_format($cart_info['total_price'], 2, '.', ','); ?> RSD"
					href="cart.php">
					<span class="glyphicon glyphicon-shopping-cart"></span>
					Cart
					<span
						class="badge"><?php echo $cart_info['total']; ?></span>
				</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<?php
						if(isset($user_info['email'])) {
							echo $user_info['email'];
						} else {
							echo "Login / Register";
						}
						?>
						<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?php if(User::is_logged_in()): ?>
								<li class="dropdown-header">Account management</li>
								<li><a href="settings.php">Settings</a></li>
								<li class="divider"></li>
								<li><a href="logout.php">Log out</a></li>
							<?php else: ?>
								<li><a href="login.php">Log in</a></li>
								<li><a href="register.php">Create account</a></li>
							<?php endif; ?>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
