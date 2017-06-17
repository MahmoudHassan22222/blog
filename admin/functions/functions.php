<?php
function redirect($msg = null, $url = null, $sec = 5){
  if($url === null){
    $url = 'index.php';
    $home = 'Home Panel';
  }else {
    $url = $_SERVER['HTTP_REFERER'];
    $home = 'Previous Page';
  }
  if(empty($msg) && !isset($msg)){
    $msg === null;
  }else {
    echo $msg;
  }
  echo "<div class='alert alert-info msg'>You will redirect to $home in $sec seconds</div>";
  header("refresh:$sec; url=$url");
  exit();
}
