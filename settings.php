<?php require './protect.inc.php'; ?>
<?php require './header.layout.php'; ?>

<?php

  require_once './Helper.class.php';
  // da li je poslata forma?
  // ako jeste, niz $_POST sadrzi action element
  if(isset($_POST['action'])) {
    require_once './User.class.php';
    $u = new User();

    // ako je action change email potrebno je da se promeni sifra
    if($_POST['action'] == 'change_email') {
      $res = $u->change_email($_POST['current_password'], $_POST['new_email']);
      if($res) {
        Helper::success('E-mail address changed.');
      } else {
        Helper::danger('Unable to change e-mail address. Please check your current password.');
      }
    }

    // ako je action change password potrebno je promeniti sifru
    if($_POST['action'] == 'change_password') {
      if($_POST['new_password'] === $_POST['new_password_repeat']) {
        $res = $u->change_password($_POST['current_password'], $_POST['new_password']);

        if($res) {
          Helper::success('Password changed.');
        } else {
          Helper::danger('Unable to change password. Please check your current password.');
        }

      } else {
        Helper::danger('Passwords dont match.');
      }
    }

  }
?>

<div class="page-header">
  <h1>Settings</h1>
</div>

<div class="row">
  <!-- change email address -->
  <div class="col-md-6">
    <h3>Change email</h3>
    <form name="change-email" action="" method="post">
      <input type="hidden" name="action" value="change_email">
      <div class="form-group">
        <label for="inputCurrentPassword">Current password</label>
        <input type="password" name="current_password" class="form-control" id="inputCurrentPassword" placeholder="Current password">
      </div>
      <div class="form-group">
        <label for="inputNewemail">New e-mail address</label>
        <input type="email" name="new_email" class="form-control" id="inputNewemail" placeholder="New e-mail address">
      </div>
      <button type="submit" class="btn btn-primary pull-right">Change e-mail</button>
    </form>
  </div>
  <!-- change password -->
  <div class="col-md-6">
    <h3>Change password</h3>
    <form name="change-password" action="" method="post">
      <input type="hidden" name="action" value="change_password">
      <div class="form-group">
        <label for="inputCurrentPassword">Current password</label>
        <input type="password" name="current_password" class="form-control" id="inputCurrentPassword" placeholder="Current password">
      </div>
      <div class="form-group">
        <label for="inputNewPassword">New password</label>
        <input type="password" name="new_password" class="form-control" id="inputNewPassword" placeholder="New password">
      </div>
      <div class="form-group">
        <label for="inputNewPasswordRepeat">New password repeat</label>
        <input type="password" name="new_password_repeat" class="form-control" id="inputNewPassword" placeholder="New password repeat">
      </div>

      <button type="submit" class="btn btn-primary pull-right">Change password</button>
    </form>
  </div>
</div>

<?php require './footer.layout.php'; ?>
