<?php
  include("connect.php");
  include("search_book.php");
  session_start();

    $id = $_SESSION['buyer_id'];
    $user_query= "SELECT * from account where account_id='$id'";
    //datatable = 'books';
    $resultperpage = 18;
    $user_result=mysqli_query($dbconn, $user_query);
    $row_session = mysqli_fetch_assoc($user_result);
    $user_image = $row_session['account_imagepath'];
?>

<?php
  if(isset($_GET['page'])){
    $page=$_GET['page'];
  }else{ 
    $page=1;
  }
  $start_from = ($page-1)*$resultperpage;
  
  $bookname_shelf = "SELECT * from books as B join account as A on B.account_id=A.account_id WHERE B.account_id='$id' order by book_id asc limit $start_from,".$resultperpage;
  $shelf_result=mysqli_query($dbconn, $bookname_shelf);
  $numbooks=mysqli_num_rows($shelf_result);
  $totalpages = ceil($numbooks['$numbooks']);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="author" content="CMSC 128 Lab Sec. 2">
  <meta name="description" content="Sell, buy, and trade books with your schoolmates.">
  <meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
  <title> Bookshelf </title>

  <link rel="shortcut icon" href="../images/official_logo.png">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
</head>
<body>
  <div class="wrapper">
  <header>
    <nav>
      <ul>
            <li class="nav_lib">
              <div>
                <a href="Library.php">
                  <img src="../images/official_logo.png" title="Library" alt="Library" height="50" width="50" id="logo">
                  <label for="library" id="logolabel">Library</label>
                </a>
              </div>
            </li>
            <li class="nav_srch">
              <span class="col-xs-2">             
                <form method="post" action = "<?php $_PHP_SELF; ?>">
                  <input type="search" name="search" placeholder="Search..." class="form-control-srch" id="noborder">
                  <input type="submit" name="submit" value="GO" class="btn btn-success">
                </form>
              </span>
            </li>
            <li class="nav_prof">
              <div>
                <a href="Profile.php">
                  <img src="<?php echo $user_image; ?>" title="Profile" alt="Profile" height="40" width="40" id="logo2">
                  <label for="username"><?php echo $_SESSION['username'];?></label>
                </a>
              </div>
            </li>
            <li class="nav_set">
              <div>
                <label for="settings">
                  <a href="Settings.php">Settings</a> |
                </label>
              </div>
            </li>
            <li class="nav_log">
              <div>
              <a href="index.php">
                <label for="logout" id="logout">Log-out</label>
              </a>
              </div>
            </li>
          </ul>
    </nav>
  </header>
  <div class="container">
      <a href="Bookshelf.php"><h1 id="bookshelf">Bookshelf</h1></a>
   <div class="add_button_container">
    <div id="btn_container">
      <a href="Add_Book.php"><input type="button" name="add_a_book" value="+Add a Book" class="btn btn-primary"></a>
      <!-- <a href="View_Bookmarks.php"><input id="bookmarks" type="button" name="add_a_book" value="Bookmarks" class="btn btn-success"></a> -->
    </div>
   </div>

     
<div class=" shelf_section well well-sm " >
<?php 
  if($numbooks > 0){ ?>
<?php
      while($row = mysqli_fetch_assoc($shelf_result)){ ;?>
            <a class="bookshelf_book_container" href="Book_info.php?id=<?php echo $row["book_id"];?>" >
        <content class="bookshelf_book">
            <img  height="225" width="150" class="" alt="<?=$row["book_name"];?>" title="<?=$row["book_name"];?>" src="<?php echo $row['book_imagepath']; ?>">
            <label>Php<?=$row["book_price"];?></label>
        </content>
      </a>
 <?php  } 
    } ?>

</div>

   <content id="prev_next">

<?php
  if($page=='1'){?>
    <a href=" " id="prev" > << Prev </a> &nbsp;|&nbsp;
    <a href="Bookshelf.php?page=<?php echo $page+1?>" name="page">Next >></a>
<?php
  }else{?>
    <a href="Bookshelf.php?page=<?php echo $page-1?>" name="page"><< Prev</a>  &nbsp;|&nbsp;
    <a href="Bookshelf.php?page=<?php echo $page+1?>" id="next" name="page">Next >></a>
 <?php }
?>
   </content>

<!-- DON'T -->
  </div>  
    <footer>
      <p>A.Y. 2016-2017 Bookshare | &copy;CMSC 128 Lab Sec. 2 |  2016</p>
    </footer>
  </div>
</body>
</html>