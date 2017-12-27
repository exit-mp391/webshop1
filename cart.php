<?php

require_once './Product.class.php';
require_once './Helper.class.php';
require_once './User.class.php';

$p = new Product();
$u = new User();

if ( isset($_POST['buy_products']) ) {
  $u->buy();
}

// prvo pravimo izmene, a aonda izvlacimo podatke iz baze za prikazivanje
if (isset($_POST['action'])) {
  // update kolicine
  if ($_POST['action'] == 'update' && isset($_POST['id']) && isset($_POST['quantity'])) {
    $update_res = $p->update_quantity($_POST['id'], $_POST['quantity']);

  }
  // brisanje proizvoda iz korpe
  if($_POST['action'] == 'delete' && isset($_POST['id'])) {
    $delete_res = $p->remove_from_cart($_POST['id']);
  }
}


$items = $p->get_cart();

$total = 0;
for($i = 0; $i < count($items); $i++) {
  $items[$i]['total'] = $items[$i]['quantity'] * $items[$i]['price'];
  $total += $items[$i]['total'];
}

$fmt = new NumberFormatter( 'sr_RS', NumberFormatter::CURRENCY );

?>

<?php include './header.layout.php'; ?>

<?php

if(isset($delete_res)) {
  if ($delete_res) {
    Helper::success('Product successfully removed from cart.');
  } else {
    Helper::danger('Failed to remove product from cart.');
  }
}

if(isset($update_res)) {
  if ($update_res) {
    Helper::success('Product qunatity updated.');
  } else {
    Helper::danger('Failed to update product quantity.');
  }
}

?>


<div class="page-header">
  <h1>My Cart</h1>
</div>

<table class="table">
  <thead>
    <tr>
      <th>Product title</th>
      <th>Quantity</th>
      <th>Price</th>
      <th>Total</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>

    <?php foreach($items as $it): ?>
      <tr>
        <td><?php echo $it['title'] ?></td>
        <td>
          <form action="" method="post" class="form-inline">
            <div class="input-group">
              <input type="hidden" name="action" value="update">
              <input type="hidden" name="id" value="<?php echo $it['id']; ?>">
              <input type="number" name="quantity" class="form-control" value="<?php echo $it['quantity']; ?>">
              <span class="input-group-btn">
                <button class="btn btn-primary">Update</button>
              </span>
            </div>
          </form>
        </td>
        <td><?php echo number_format($it['price'], 2, '.', ','); ?> RSD</td>
        <td><?php echo number_format($it['total'], 2, '.', ','); ?> RSD</td>
        <td>
          <form action="" method="post">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?php echo $it['id']; ?>">
            <button class="btn btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>

  </tbody>
  <tfoot>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>
        <strong>
          <?php echo number_format($total, 2, '.', ','); ?> RSD
        </strong>
      </td>
      <td></td>
    </tr>
  </tfoot>
</table>

<div class="row">
  <div class="col-md-12">
    <form action="" method="post">
      <button
        data-trigger="hover"
        data-toggle="popover"
        title="Total"
        data-html="true"
        data-placement="left"
        data-content="Your total for the items in the cart is:<br /><h2><?php echo number_format($total, 2, '.', ','); ?> RSD</h2>"
        type="submit"
        class="btn btn-lg btn-primary pull-right"
        name="buy_products">Order products</button>
    </form>
  </div>
</div>

<?php include './footer.layout.php'; ?>
