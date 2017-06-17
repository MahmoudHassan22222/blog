<?php
session_start();
if(isset($_SESSION['username'])){
  require "includes/init.php";

$cat = "";
if(isset($_GET['name'])){
  $cat = $_GET['name'];
}else {
  $cat = "Manage";
}

if($cat == "Add"){ ?>
  <form action="?name=Insert" method="POST">
    <h1 class="text-center">ADD NEW CATEGORY</h1>
    <input class="form-control input-lg" type="text" name="cat_name" placeholder="Insert name of category" />
    <input class="form-control input-lg" type="text" name="cat_desc" placeholder="Description of category" />
    <div>
      <input type="checkbox" id="show" name="showCat" />
      <label for="show">SHOW OR HIDE</label>
    </div>
    <input class="btn btn-success btn-lg" type="submit" name="submit" value="ADD NEW CATEGORY" />
  </form>
<?php }elseif ($cat == "Insert"){
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $catn = $_POST['cat_name'];
    $catd = $_POST['cat_desc'];

    $catSt = "";
    if(isset($_POST['showCat']) && $_POST['showCat'] = 'on'){
      $catSt = 1;
    }else {
      $catSt = 0;
    }


    // Check Forms
    $msgErrors = "";
    if(empty($catn)){
      echo $msgErrors = "<div class='alert alert-danger msg'>CATEGORY NAME IS EMPTY</div>";
    }
    if(!empty($catn) && strlen($catn) < 3){
      echo $msgErrors = "<div class='alert alert-danger msg'>CATEGORY NAME MUST BE 3 CHARS OR MORE</div>";
    }
    // Check Description Category
    if(empty($catd)){
      echo $msgErrors = "<div class='alert alert-danger msg'>CATEGORY DESCRIPTION IS EMPTY</div>";
    }
    if(!empty($catd) && strlen($catd) < 10){
      echo $msgErrors = "<div class='alert alert-danger msg'>CATEGORY DESCRIPTION MUST BE 10 CHARS OR MORE</div>";
    }
    if(empty($msgErrors)){

    // Insert into categories table
    $newcat = $connect->prepare("INSERT INTO categories SET
      catname = :icats, catdesc = :idescr, catstatus = :istatus");
    $newcat->execute(array(
      ':icats' => $catn,
      ':idescr' => $catd,
      ':istatus' => $catSt
    ));
    $count = $newcat->rowCount();
    if($count > 0){
      $msg = "<div class='alert alert-success msg'>YOU ARE ADD CATEGORY SUCCESSFUL</div>";
      redirect($msg, 'bac', 2);
    }
  }else {
    redirect('', 'bac');
  }
  }
}elseif ($cat == "Edit") {
  $cat_id = "";
  if(isset($_GET['id'])){
    $cat_id = $_GET['id'];
  }else {
    $cat_id = 0;
  }
  $check_cat_id = $connect->prepare("SELECT * FROM categories WHERE id = ?");
  $check_cat_id->execute(array($cat_id));
  $catRows = $check_cat_id->fetch();
?>
  <form action="?name=Update" method="POST">
    <h1 class="text-center">EDIT CATEGORY</h1>
    <input type="hidden" name="id" value="<?php echo $catRows['id'] ?>">
    <input class="form-control input-lg" type="text" name="cat_name" value="<?php echo $catRows['catname'] ?>" />
    <input class="form-control input-lg" type="text" name="cat_desc" value="<?php echo $catRows['catdesc'] ?>" />
    <div>
      <!-- Checkbox -->
      <input type="checkbox" id="show" name="showCat" <?php if($catRows['catstatus'] = 1 ) {
Echo "checked";
} ?> />


      <label for="show">SHOW OR HIDE</label>
    </div>
    <input class="btn btn-success btn-lg" type="submit" name="submit" value="ADD NEW CATEGORY" />
  </form>
<?php }


}else {
  header("Location: index.php");
  exit();
}
