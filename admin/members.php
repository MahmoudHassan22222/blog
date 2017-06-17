<?php
session_start();
if(isset($_SESSION['username'])){
require "includes/init.php";

$users = "";
if (isset($_GET['users'])) {
  $users = $_GET['users'];
}else {
  $users = "Manage";
}

// Add - Edit - Delete - Manage
if($users == "Add"){ ?>
  <form action="?users=Insert" method="post">
    <h1 class="text-center">ADD NEW MEMBER</h1>
    <input class="form-control input-lg" type="text" name="name" placeholder="First and last name" />
    <input class="form-control input-lg" type="text" name="user" placeholder="User Name" />
    <input class="form-control input-lg" type="email" name="email" placeholder="Type your email" />
    <input class="form-control input-lg" type="password" name="password" placeholder="Type your password" />
    <input class="btn btn-success btn-block btn-lg" type="submit" name="login" value="ADD NEW MEMBER" />
  </form>
<?php }elseif ($users == "Insert") {
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $user = $_POST['user'];
    $mail = $_POST['email'];
    $pass = $_POST['password'];
    $md5 = md5($pass);
    // Exist Username
    $errMsg = "";
    $userEx = $connect->prepare("SELECT * FROM users WHERE username = :Euser");
    $userEx->execute(array(
      ':Euser' => $user
    ));
    $userExCount = $userEx->rowCount();
    if($userExCount == 1){
      echo $errMsg = "<div class='alert alert-danger msg'>
      USERNAME IS FOUND IN DATABASE, PLEASE TRY AGAIN
      </div>";
    }
    // Exist Email
    $emailEx = $connect->prepare("SELECT * FROM users WHERE email = :xmails");
    $emailEx->execute(array(
      ':xmails' => $mail
    ));
    $emailExCount = $emailEx->rowCount();
    if($emailExCount == 1){
      echo $errMsg = "<div class='alert alert-danger msg'>
      EMAIL IS FOUND IN DATABASE, PLEASE TRY AGAIN
      </div>";
      //redirect('back', 7);
    }
    // Check All Forms

    // Check Full Name
    if(empty($name)){
      echo $errMsg = "<div class='alert alert-danger msg'>
      NAME IS EMPTY
      </div>";
    }
    if(!empty($name) && strlen($name) < 8){
      echo $errMsg = "<div class='alert alert-danger msg'>
      NAME MUST BE 6 CHARS OR LARG
      </div>";
    }
    // Check User
    if(empty($user)){
      echo $errMsg = "<div class='alert alert-danger msg'>
      USERNAME IS EMPTY
      </div>";
    }
    if(!empty($user) && strlen($user) < 6){
      echo $errMsg = "<div class='alert alert-danger msg'>
      USERNAME MUST BE 6 CHARS OR LARG
      </div>";
    }
    // Check Email
    if(empty($mail)){
      echo $errMsg = "<div class='alert alert-danger msg'>
      EMAIL IS EMPTY
      </div>";
    }
    // Check Password
    if(empty($pass)){
      echo $errMsg = "<div class='alert alert-danger msg'>
      PASSWORD IS EMPTY
      </div>";
    }
    if(!empty($pass) && strlen($pass) < 8){
      echo $errMsg = "<div class='alert alert-danger msg'>
      PASSWORD MUST BE 8 CHARS OR LARG
      </div>";
    }

    if(empty($errMsg)){


    $insert = $connect->prepare("INSERT INTO users SET
      username = :vuser, password = :vpass, name = :vname, email = :vmail, created = now()");
    $insert->execute(array(
      ':vuser' => $user,
      ':vpass' => $md5,
      ':vname' => $name,
      ':vmail' => $mail
    ));
    $count = $insert->rowCount();
    if ($count > 0) {
      $msg = "<div class='alert alert-success msg'>You Are Registered</div>";
      redirect($msg, 'bk');
    }
  }else {
    redirect('', 'back', 15);
  }

  }
}elseif ($users == "Edit") {

  $userId = "";
  if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $userId = intval($_GET['id']);
  }else {
    $userId = 0;
  }
  $userTable = $connect->prepare("SELECT * FROM users WHERE id = ?");
  $userTable->execute(array($userId));
  $userFetch = $userTable->fetch();


  ?>
  <form action="?users=Update" method="post" class="form-horizontal">
    <h1 class="text-center">EDIT MEMBER</h1>
    <input type="hidden" name="id" value="<?php echo $userId ?>" />
    <div class="form-group">
      <label class="control-label">Full Name</label>
        <input class="form-control input-lg" type="text" name="name" value="<?php echo $userFetch['name'] ?>" />
    </div>

    <div class="form-group">
      <label class="control-label">User Name</label>
      <input class="form-control input-lg" type="text" name="user" value="<?php echo $userFetch['username'] ?>" />
    </div>

    <div class="form-group">
      <label class="control-label">Email</label>
      <input class="form-control input-lg" type="email" name="email" value="<?php echo $userFetch['email'] ?>" />
    </div>

    <div class="form-group">
      <label class="control-label">Password</label>
      <input class="form-control input-lg" type="password" name="newpass" />
    </div>
    <input class="form-control input-lg" type="hidden" name="oldpass" value="<?php echo $userFetch['password'] ?>" />
    <input class="btn btn-success btn-block btn-lg" type="submit" name="login" value="EDIT MEMBER" />
  </form>
<?php } elseif ($users == "Update") {
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $id = $_POST['id'];
    $user = $_POST['user'];
    $newPass = $_POST['newpass'];
    $oldPass = $_POST['oldpass'];
    $name = $_POST['name'];
    $mail = $_POST['email'];

    // Password
    $pass = "";
    if(empty($newPass)){
      $pass = $oldPass;
    }else {
      $pass = md5($newPass);
    }
    $userUpdate = $connect->prepare("UPDATE users SET
      username = :uuser, password = :upass, name = :uname, email = :uemail WHERE id = :uid");
    $userUpdate->execute(array(
      ':uuser' => $user,
      ':upass' => $pass,
      ':uname' => $name,
      ':uemail' => $mail,
      ':uid' => $id
    ));
    $upDateRow = $userUpdate->rowCount();
    if($upDateRow > 0){
      $msg = "<div class='alert alert-success msg'>UPDATED SUCCESSFUL</div>";
      redirect($msg, 'bac');
    }
  }
}elseif ($users == "Manage") { ?>
  <div class="container text-center">
    <a class="btn btn-success" href="?users=Add">ADD NEW MEMBER</a>
    <div class="panel panel-info">
    <!-- Default panel contents -->
    <div class="panel-heading">MEMBERS MANAGEMENTS</div>

    <!-- Table -->
    <table class="table table-bordered">
      <tr class="success">
        <td>Name</td>
        <td>User Name</td>
        <td>Email</td>
        <td>Last Update</td>
        <td>Options</td>
      </tr>
      <?php
          $usersManage = $connect->prepare("SELECT * FROM users");
          $usersManage->execute();
          $usersAll = $usersManage->fetchAll();
          foreach ($usersAll as $userE) {
            echo "<tr>";
              echo "<td>" . $userE['name'] . "</td>";
              echo "<td>" . $userE['username'] . "</td>";
              echo "<td>" . $userE['email'] . "</td>";
              echo "<td>" . $userE['updated'] . "</td>";
              echo "<td>";
                echo '<a class="btn btn-primary" href="?users=Edit&id=' . $userE['id'] . '">Edit</li></a>';
                echo '<a class="btn btn-danger" href="?users=Delete&id=' . $userE['id'] . '">Delete</li></a>';
                // User Active
                if($userE['active'] == 0){
                  echo '<a class="btn btn-success" href="?users=Active&id=' . $userE['id'] . '">Active</li></a>';
                }
              echo "</td>";
            echo "</tr>";
          }
      ?>
    </table>
    </div>
  </div>
<?php }elseif ($users == "Delete") {
  $udi = "";
  if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $udi = $_GET['id'];
  }else {
    $udi = 0;
  }
  $idCon = $connect->prepare("SELECT * FROM users WHERE id = ?");
  $idCon->execute(array($udi));
  $row = $idCon->rowCount();
  if($row > 0){
    $deleteUser = $connect->prepare("DELETE FROM users WHERE id = :duid");
    $deleteUser->execute(array(
      'duid' => $udi
    ));
    $delRow = $deleteUser->rowCount();
    if($delRow > 0){
      $msg = "<div class='alert alert-danger msg'>
      DELETED SUCCESSFUL
      </div>";
      redirect($msg, 'back');
    }
  }
}elseif ($users == "Active") {
  $activeid = "";
  if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $activeid = $_GET['id'];
  }else {
    $activeid = 0;
  }
  $activeCon = $connect->prepare("SELECT * FROM users WHERE id = ?");
  $activeCon->execute(array($activeid));
  $row = $activeCon->rowCount();
  if($row > 0){
    $actUpdate = $connect->prepare("UPDATE users SET active = 1 WHERE id = ?");
    $actUpdate->execute(array($activeid));
    $actRow = $actUpdate->rowCount();
    if($actRow > 0){
      $msg = "<div class='alert alert-success msg'>
      USER ACTIVE SUCCESSFUL
      </div>";
      redirect($msg, 'back');
    }
  }
}




}else {
  header("Location: index.php");
  exit();
}
?>
<?php require "includes/tmp/footer.php"; ?>
