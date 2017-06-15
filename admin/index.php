<?php
session_start();
$noNavbar = "";
if(isset($_SESSION['username'])){
  header("Location: admincp.php");
  exit();
}
  require "includes/init.php";
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $mail = $_POST['username'];
    $password = $_POST['password'];
    $hash_pass = md5($password);
    $login = $connect->prepare("SELECT * FROM users WHERE username = ? OR email = ? AND password = ?");
    $login->execute(array($username, $mail, $hash_pass));
    $allUsers = $login->fetch();
    $count = $login->rowCount();
    if($count > 0){
      $_SESSION['username'] = $username;
      $_SESSION['user_id'] = $allUsers['id'];
      header("Location: admincp.php");
      exit();
    }else {
      echo "<div class='alert alert-danger msg'>" . 'Username OR Password Wrong, Please try again' . "</div>";
    }
  }
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
  <h1 class="text-center">LOGIN ADMIN PANEL</h1>
  <input class="form-control input-lg" type="text" name="username" placeholder="Type username OR email" />
  <input class="form-control input-lg" type="password" name="password" placeholder="Type password" />
  <input class="btn btn-success btn-block btn-lg" type="submit" name="login" value="LOGIN" />
</form>
