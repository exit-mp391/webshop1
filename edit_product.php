<?php
  if ( ! isset($_GET['id']) ) {
    header("Location: index.php");
  }

?>

<?php include 'admin_protect.inc.php'; ?>
<?php include 'header.layout.php'; ?>

<?php

require_once './Category.class.php';
require_once './Product.class.php';

$c = new Category();
$categories = $c->all();


$p = new Product();


if( isset($_POST['title']) && isset($_POST['description']) && isset($_POST['price']) && $_POST['title'] != '' && $_POST['price'] != '') {
  $res = $p->update(
    $_GET['id'],
    $_POST['title'],
    $_POST['description'],
    $_POST['category_id'],
    $_POST['price'],
    $_FILES['img']
  );

  if($res) {
    Helper::success("Product successfully updated.");
  } else {
    Helper::danger("Failed to update product. Please make sure image is less than 1MB in size.");
  }
}

$product = $p->one($_GET['id']);

?>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="page-header">
      <h1>Update product</h1>
    </div>

    <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="inputCategory">Category</label>
        <select name="category_id" class="form-control" id="inputCategory">
          <?php foreach($categories as $cat): ?>
            <?php
              if ( $product['category_id'] == $cat['id'] ) {
                $selected = "selected";
              } else {
                $selected = "";
              }
            ?>
            <option value="<?php echo $cat['id']; ?>" <?php echo $selected; ?>>
              <?php echo $cat['title']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="inputTitle">Title</label>
        <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Product title" value="<?php echo $product['title'] ?>" required>
      </div>
      <div class="form-group">
        <label for="inputDescription">Description</label>
        <textarea name="description" id="inputDescription" class="form-control" rows="3" placeholder="Describe product to customers..."><?php echo $product['description']; ?></textarea>
      </div>
      <div class="form-group">
        <label for="inputPrice">Price</label>
        <!-- <input type="number" name="price" class="form-control" id="inputPrice" placeholder="Product price"> -->
        <div class="input-group">
          <input type="number" name="price" class="form-control" id="inputPrice" placeholder="Product price" value="<?php echo $product['price']; ?>" required>
          <span class="input-group-addon">.00</span>
          <span class="input-group-addon">RSD</span>
        </div>
      </div>
      <div id="img_to_edit" class="edit-img-container">
        <img class="img-responsive" src="<?php echo $product['img']; ?>">
        <div class="img-msg">
          Click to change the product image.
        </div>
      </div>
      <div id="edit_img_input" class="form-group">
        <label for="inputImage">Choose image</label>
        <input type="file" name="img" id="inputImage">
        <p class="help-block">Please only choose image files.</p>
      </div>
      <button name="update_product" type="submit" class="btn btn-primary pull-right">Update product details</button>
    </form>
  </div>
</div>

<?php include 'footer.layout.php'; ?>
