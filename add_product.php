<?php include 'admin_protect.inc.php'; ?>
<?php include 'header.layout.php'; ?>

<?php
require_once './Category.class.php';
require_once './Product.class.php';

$c = new Category();
$categories = $c->all();

$p = new Product();

if( isset($_POST['title']) && isset($_POST['description']) && isset($_POST['price']) && $_POST['title'] != '' && $_POST['price'] != '') {
  $res = $p->add(
    $_POST['title'],
    $_POST['description'],
    $_POST['category_id'],
    $_POST['price'],
    $_FILES['img']
  );

  if($res) {
    Helper::success("Product successfully added to the store.");
  } else {
    Helper::danger("Failed to add product to the store. Please make sure image is less than 1MB in size.");
  }
}

?>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="page-header">
      <h1>Add new product</h1>
    </div>

    <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="inputCategory">Category</label>
        <select name="category_id" class="form-control" id="inputCategory">
          <?php foreach($categories as $cat): ?>
            <option value="<?php echo $cat['id']; ?>">
              <?php echo $cat['title']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="inputTitle">Title</label>
        <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Product title" required>
      </div>
      <div class="form-group">
        <label for="inputDescription">Description</label>
        <textarea name="description" id="inputDescription" class="form-control" rows="3" placeholder="Describe product to customers..."></textarea>
      </div>
      <div class="form-group">
        <label for="inputPrice">Price</label>
        <!-- <input type="number" name="price" class="form-control" id="inputPrice" placeholder="Product price"> -->
        <div class="input-group">
          <input type="number" name="price" class="form-control" id="inputPrice" placeholder="Product price" required>
          <span class="input-group-addon">.00</span>
          <span class="input-group-addon">RSD</span>
        </div>
      </div>
      <div class="form-group">
        <label for="inputImage">Choose image</label>
        <input type="file" name="img" id="inputImage">
        <p class="help-block">Please only choose image files.</p>
      </div>
      <button type="submit" class="btn btn-primary pull-right">Add product</button>
    </form>
  </div>
</div>

<?php include 'footer.layout.php'; ?>
