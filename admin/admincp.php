<?php
session_start();
if(isset($_SESSION['username'])){
require "includes/init.php";
}else {
  header("Location: index.php");
  exit();
}
require "includes/tmp/footer.php";
?>
