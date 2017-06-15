<?php
  require "includes/connect.php";
  require "functions/functions.php";
  require "includes/tmp/header.php";
  // Navbar
  if (!isset($noNavbar)) {
    require "includes/tmp/nav.php";
  }
?>
