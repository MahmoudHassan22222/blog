<?php
function redirect($msg, $url = null, $sec = 5){
  if($url === null){
    $url = 'index.php';
    $home = 'Home Panel';
  }else {
    $url = $_SERVER['HTTP_REFERER'];
    $home = 'Previous Page';
  }
  echo $msg;
  echo "<div class='alert alert-success msg'>You will redirect to $home in $sec seconds</div>";
  header("refresh:$sec; url=$url");
  exit();
}
