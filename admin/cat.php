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
    <h1 class="text-center">UPDATE CATEGORY</h1>
    <input type="hidden" name="id" value="<?php echo $catRows['id'] ?>">
    <input class="form-control input-lg" type="text" name="c_name" value="<?php echo $catRows['catname'] ?>" />
    <input class="form-control input-lg" type="text" name="c_desc" value="<?php echo $catRows['catdesc'] ?>" />
    <!-- Start Checkbox -->
    <div>
      <input type="checkbox" id="show" name="showCats" <?php if($catRows['catstatus'] == 1 ) { echo "checked = checked ";} ?> />
      <label for="show">SHOW OR HIDE</label>
    </div>
    <!-- End Checkbox -->
    <input class="btn btn-success btn-lg" type="submit" name="submit" value="UPDATE CATEGORY" />
  </form>
<?php }elseif ($cat == "Update") {
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $catsId = $_POST['id'];
    $catN = $_POST['c_name'];
    $catD = $_POST['c_desc'];
          // Checkbox
    $catStatus = "";
    if($_POST['showCats'] = 'on'){
      $catStatus = 1;
    }else {
      $catStatus = 0;
    }

    $catUpdate = $connect->prepare("UPDATE categories SET
      catname = :xnameC, catdesc = :xdesC, catstatus = :xstatus WHERE id = :vid");
    $catUpdate->execute(array(
      ':xnameC' => $catN,
      ':xdesC' => $catD,
      ':xstatus' => $catStatus,
      ':vid' => $catsId
    ));
    $updateRows = $catUpdate->rowCount();
    echo $updateRows;
  }
}elseif ($cat == "Delete") {
  $deleteCatId = "";
  if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $deleteCatId = $_GET['id'];
  }else{
    $deleteCatId = 0;
  }
  $selectCatId = $connect->prepare("SELECT * FROM categories WHERE id = ?");
  $selectCatId->execute(array($deleteCatId));
  $selectCatIdRow = $selectCatId->rowCount();
  if ($selectCatIdRow > 0) {
      $delCat = $connect->prepare("DELETE FROM categories WHERE id = :dcatid");
      $delCat->execute(array(
          ':dcatid' => $deleteCatId
        ));
      $delCatRow = $delCat->rowCount();
      if ($delCatRow > 0) {
        $msg = "<div class='alert alert-success msg'>DELETED CATEGORY SUCCESSFUL</div>";
      redirect($msg, 'bac', 2);
      }
  }
}elseif ($cat == "Manage") { ?>
  <div class="container">
    <a class="btn btn-success btn-lg add" href="?name=Add">ADD NEW CATEGORY</a>
    <div class="panel panel-primary">
      <div class="panel-heading text-center">CATEGORIES MANAGEMENT</div>
      <div class="panel-body">
        <?php
          $cats = getFromTable("categories");
          foreach($cats as $cat){
            echo "<div class='catmanage'>";
              echo "<p>" . $cat['catname'] . "</p>";
              echo "<a class='btn btn-primary' href='?name=Edit&id=" . $cat['id'] . "'>Edit</a>";
              echo "<a class='btn btn-danger' href='?name=Delete&id=" . $cat['id'] . "'>Delete</a>";
            echo "</div>";
          }
        ?>
      </div>
    </div>
  </div>
<?php }


}else {
  header("Location: index.php");
  exit();
}
?>
<?php require "includes/tmp/footer.php"; ?>