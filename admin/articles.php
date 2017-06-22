<?php
	session_start();
	if(isset($_SESSION['username'])){
		require "includes/init.php";

		$articles = "";
		if(isset($_GET['name'])){
			$articles = $_GET['name'];
		}else{
			$articles = "Manage";
		}

		// Add - Edit - Delete - Manage
		if($articles == "Add"){ ?>
			<form class="articlesForm" action="?name=Insert" method="POST" enctype="multipart/form-data">
				<h1 class="text-center">ADD NEW ARTICLE</h1>
				<input class="form-control input-lg" type="text" name="name_article" placeholder="Insert name of article">
				<textarea class="form-control input-lg" name="desc_article" placeholder="Description Article"></textarea>
				<select class="form-control input-lg" name="article_cat">
					<?php
						$allCats = getFromTable("categories");
						foreach($allCats as $allCat){
							echo "<option value=" . $allCat["id"] . ">" . $allCat['catname'] . "</option>";
						}
					?>
				</select>
				<select class="form-control input-lg" name="article_user">
					<?php
						$allUsers = getFromTable("users");
						foreach($allUsers as $allUser){
							echo "<option value=" . $allUser["id"] . ">" . $allUser['username'] . "</option>";
						}
					?>
				</select>
				<input type="file" name="article_img">
				<input class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="ADD NEW ARTICLE">
			</form>
		<?php }elseif ($articles == "Insert") {
			$article_name = $_POST['name_article'];
			$article_desc = $_POST['desc_article'];
			$article_cat = $_POST['article_cat'];
			$article_user = $_POST['article_user'];
			$article_img = $_FILES['article_img'];
			// Check Form
			$errArticle = "";
			if(empty($article_name)){
		      echo $errArticle = "<div class='alert alert-danger msg'>
		      ARTICLE NAME IS EMPTY
		      </div>";
		    }
		    if(!empty($article_name) && strlen($article_name) < 6){
		      echo $errArticle = "<div class='alert alert-danger msg'>
		      ARTICLE NAME MUST BE 6 CHARS OR LARG
		      </div>";
		    }
			// Check Description of article
			if(empty($article_desc)){
		      echo $errArticle = "<div class='alert alert-danger msg'>
		      ARTICLE DESCRIPTION IS EMPTY
		      </div>";
		    }
		    if(!empty($article_desc) && strlen($article_desc) < 6){
		      echo $errArticle = "<div class='alert alert-danger msg'>
		      ARTICLE DESCRIPTION MUST BE 10 CHARS OR LARG
		      </div>";
		    }
			if(empty($errArticle)){
			// Article Img
			$nameImg = $article_img['name'];
			$typeImg = $article_img['type'];
			$tmpImg = $article_img['tmp_name'];
			$sizeImg = $article_img['size'];

				// Ext.
			$extImg = array("jpg", "jpeg", "gif", "png");
			$expl = strtolower(end(explode(".", $nameImg)));
			if(in_array($expl, $extImg)){
				//$rndm = rand(1, 100000000000, $nameImg);
				move_uploaded_file($tmpImg, "images/$nameImg");
			$article_insert = $connect->prepare("INSERT INTO articles SET name = :xname, descr = :xdesc, art_user = :artuser, art_cat = :artcat, imgs = :ximags, created = now()");
			$article_insert->execute(array(
					'xname' => $article_name,
					'xdesc' => $article_desc,
					'artuser' => $article_user,
					'artcat' => $article_cat,
					'ximags' => $nameImg
				));
			$article_insert_row = $article_insert->rowCount();
			if($article_insert_row > 0){
				echo $errArticle = "<div class='alert alert-success msg'>
			      ARTICLE ADDED SUCCESSFUL
			      </div>";
			      redirect('', 'bac');
			}
		}else{
				echo $errArticle = "<div class='alert alert-danger msg'>
			      THIS EXTEND NOT SUPPORTED
			      </div>";
			      redirect('', 'bac');
			}
		}else{
			redirect('', 'back', 7);
	}
		}elseif ($articles == "Edit") {

			$article_id = "";
			if(isset($_GET['id']) && is_numeric($_GET['id'])){
				$article_id = $_GET['id'];
			}else{
				$article_id = 0;
			}
			$select_article_id = $connect->prepare("SELECT * FROM articles WHERE id = ?");
			$select_article_id->execute(array($article_id));
			$article_rows = $select_article_id->fetch();

			?>
			<!--
انا مش فاهم انت ليه بتكتب الاكشن في الفورم بالشكل ده ؟؟؟
			<form class="articlesForm" action="?name=Insert" method="POST" enctype="multipart/form-data"> -->
			<form class="articlesForm" action="" method="post" enctype="multipart/form-data">
				<h1 class="text-center">EDIT ARTICLE</h1>
				<input type="hidden" name="id" value="<?php echo $article_id ?>">
				<input class="form-control input-lg" type="text" name="name_article" value="<?php echo $article_rows['name'] ?>">
				<textarea class="form-control input-lg" name="desc_article"><?php echo $article_rows['descr'] ?></textarea>
				<select class="form-control input-lg" name="article_cat">
					<?php
					// categories options
						$allCats = getFromTable("categories");
						foreach($allCats as $allCat){
							echo "<option value=" . $allCat['id'] . " >" . $allCat['catname'] . "</option>";
						}
					?>
				</select>
				<input type="hidden" name="userId" value="<?php echo $_SESSION['user_id']; ?>" />
				<input type="file" name="article_img">
				<input class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="ADD NEW ARTICLE">
			</form>
		<?php }

	} else{
		header("Location: index.php");
		exit();
	}
?>
<?php require "includes/tmp/footer.php"; ?>
