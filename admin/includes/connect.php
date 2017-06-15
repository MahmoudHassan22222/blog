<?php
  try {
    $connect = new PDO("mysql:host=localhost;dbname=blog", 'root', '');
  } catch (Exception $e) {
    echo $e->getMessage();
  }

?>
