<?php 
  include("connect.php");
  include("search_book.php");
  session_start();
?>
<?php
    $id = $_SESSION['buyer_id'];
    $user_query= "SELECT * from account where account_id='$id'";
    $user_result=mysqli_query($dbconn, $user_query);
    $row_session = mysqli_fetch_assoc($user_result);
    $user_image = $row_session['account_imagepath'];
    if(isset($_GET['ID'])){
      $search = $_GET["ID"];
    } else {
      echo "Not found";
    }

  if(isset($_GET['page'])){
      $page=$_GET['page'];
    }else{
      $page=0;
    }
    $resultperpage = 12;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="author" content="CMSC 128 Lab Sec. 2">
  <meta name="description" content="Sell, buy, and trade books with your schoolmates.">
  <meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
  <title> Search Result </title>
  <link rel="shortcut icon" href="../images/official_logo.png">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/library_style.css">
  <link rel="stylesheet" type="text/css" href="../css/result.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
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
              <span class="col-xs-4">             
                <form method="post" action = "<?php $_PHP_SELF; ?>">
            <input type="search" name="search" placeholder="Search..." class="form-control-srch" id="noborder">
            <input type="submit" name="submit" value="GO" class="btn btn-success">
          </form>
        </span>
            </li>
            <li class="nav_prof">
              <div>
                <a href="Profile.php">
                  <img src="<?php echo $user_image;?>" title="Profile" alt="Profile" height="40" width="40" id="logo2">
                  <label for="username"><?php echo $_SESSION['username'];?></label>
                </a>
              </div>
            </li>
            <li class="nav_cart">
              <div>
                <span id="notification_count"></span>
                <a href="Shopping_list.php" id="notificationLink" onclick = "return getNotification()">
                  <img src="../images/cart.png" alt="Shopping List" title="Go to your Shopping List" height="40" width="40" >
                </a>
              </div>
            </li>
            <li class="nav_mark">
              <div>
                <a href="View_bookmarks.php">
                  <img src="../images/logo_bookmark.png" alt="Bookmarks" title="View your bookmarks" height="40" width="40" id="logo3">
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
      <h2 id="tag_results">Search results for "<?php echo $search ?>"...</h2>
<div class="sort_result">
    <ul class="nav nav-tabs">
      <li><a  href="result.php?ID=<?php echo $search?>&amp;key=title">Book Title</a></li>
      <li><a  href="result.php?ID=<?php echo $search?>&amp;key=author">Book Author</a></li>
      <li><a  href="result.php?ID=<?php echo $search?>&amp;key=subject">Book Subject</a></li>
      <li><a  href="result.php?ID=<?php echo $search?>&amp;key=user">Bookshare User</a></li>
    </ul>
</div>

<div class="result_section" >

  <?php
    if(isset($_GET['key'])){
      $key=$_GET['key'];
    }else{
      $key="title";
    } ?>

<?php
  if($key=="title"){  
    $start_from = ($page)*$resultperpage;
    $que="SELECT * FROM book_info bi JOIN books b ON bi.book_id=b.book_id WHERE b.book_id NOT IN (SELECT cart.book_id FROM cart) AND book_name LIKE '%$search%' order by b.book_id asc limit $start_from,".$resultperpage;
    $result_bookname = mysqli_query($dbconn,$que);
    $numbooks = mysqli_num_rows($result_bookname);

    $sql="SELECT * FROM book_info bi JOIN books b ON bi.book_id=b.book_id WHERE b.book_id NOT IN (SELECT cart.book_id FROM cart) AND book_name LIKE '%$search%' order by b.book_id asc";
    $retval = mysqli_query($dbconn, $sql);
    $totalbooks = mysqli_num_rows($retval);
    $totalpages = ceil($totalbooks/$resultperpage);
?>

<h2 id="res_label"> Filter by <?=$key?> </h2>
<?php
  if(mysqli_num_rows($result_bookname)>0){ ?>

<div id="title" class="sorted well well-sm">
<?php   
      while($row=mysqli_fetch_assoc($result_bookname)){ 
          $book_id = $row['book_id'];?>
          <?php
            $sql = "SELECT account_id from books where book_id='$book_id' limit 1";
            $result_sql = mysqli_query($dbconn, $sql);
            $row_account = mysqli_fetch_assoc($result_sql);
            $owner_id = $row_account["account_id"];
          ?>
          <a class="bookshelf_book_container" 
          href=<?php if($owner_id==$id){?>"Book_info.php?id=<?=$book_id?>"
          <?php } else{ ?>
            "Public_book_info.php?id=<?=$book_id?>" <?php }?>>
            <content class="bookshelf_book">
              <img title="<?=$row['book_name']?>" alt="<?=$row['book_name']?>" height="225" width="150" class="" src="<?php echo $row['book_imagepath']; ?>">
              <label>Php<?=$row['book_price'];?></label>
            </content>
          </a>

<?php } ?>
</div>

<content id="res_prev_next">
  <?php if($page=='0' and $totalpages!='1'){?>
    <a href="result.php?page=<?php echo $page+1?>&amp;ID=<?php echo $search?>&amp;key=title" id="next" >Next >> </a>
  <?php }else if($page==$totalpages-1 and $totalpages!='1'){?>
    <a href="result.php?page=<?php echo $page-1?>&amp;ID=<?php echo $search?>&amp;key=title" id="prev" ><< Prev </a>
  <?php }else if($totalpages=='1'){ ?>
    <p></p>
  <?php }else{?>
    <a href="result.php?page=<?php echo $page-1?>&amp;ID=<?php echo $search?>&amp;key=title" id="prev" ><< Prev </a> &nbsp;|&nbsp;
    <a href="result.php?page=<?php echo $page+1?>&amp;ID=<?php echo $search?>&amp;key=title" id="next" >Next >> </a>
  <?php }?>
</content>

<?php    } else {?>
          <p> No result for keyword "<?php echo $search;?>". </p>
<?php    }
  }

  elseif($key=="author"){
    $start_from = ($page)*$resultperpage;
    $que="SELECT * FROM book_info bi JOIN books b ON bi.book_id=b.book_id WHERE b.book_id NOT IN (SELECT cart.book_id FROM cart) AND book_author LIKE '%$search%' order by b.book_id asc limit $start_from,".$resultperpage;
    $result_author = mysqli_query($dbconn,$que);
    $numauthors = mysqli_num_rows($result_author);

    $sql = "SELECT * FROM book_info bi JOIN books b ON bi.book_id=b.book_id WHERE b.book_id NOT IN (SELECT cart.book_id FROM cart) AND book_author LIKE '%$search%' order by b.book_id asc";
    $retval = mysqli_query($dbconn, $sql);
    $totalbooks = mysqli_num_rows($retval);
    $totalpages = ceil($totalbooks/$resultperpage);?>
<h2 id="res_label"> Filter by <?=$key?> </h2>
<?php    
    if(mysqli_num_rows($result_author)){ ?>

<div id="author" class="sorted well well-sm">
<?php   
      while($row1=mysqli_fetch_assoc($result_author)){ 
         $book_id = $row1['book_id'];?>
          <?php
            $sql = "SELECT account_id from books where book_id='$book_id' limit 1";
            $result_sql = mysqli_query($dbconn, $sql);
            $row_account = mysqli_fetch_assoc($result_sql);
            $owner_id = $row_account["account_id"];
          ?>
          <a class="bookshelf_book_container" 
          href=<?php if($owner_id==$id){?>"Book_info.php?id=<?=$book_id?>"
          <?php } else{ ?>
            "Public_book_info.php?id=<?=$book_id?>" <?php }?>>
            <content class="bookshelf_book">
              <img title="<?=$row1['book_name']?>" alt="<?=$row1['book_name']?>" height="225" width="150" class="" src="<?php echo $row1['book_imagepath']; ?>">
              <label>Php<?=$row1["book_price"];?></label>
            </content>
          </a>
<?php } ?>
</div>    

<content id="res_prev_next">
  <?php if($page=='0' and $totalpages!='1'){?>
    <a href="result.php?page=<?php echo $page+1?>&amp;ID=<?php echo $search?>&amp;key=author" id="next" >Next >> </a>
  <?php }else if($page==$totalpages-1 and $totalpages!='1'){?>
    <a href="result.php?page=<?php echo $page-1?>&amp;ID=<?php echo $search?>&amp;key=title" id="prev" ><< Prev </a>
  <?php }else if($totalpages=='1'){ ?>
    <p></p>
  <?php }else{?>  
    <a href="result.php?page=<?php echo $page-1?>&amp;ID=<?php echo $search?>&amp;key=author" id="prev" ><< Prev </a> &nbsp;|&nbsp;
    <a href="result.php?page=<?php echo $page+1?>&amp;ID=<?php echo $search?>&amp;key=author" id="next" >Next >> </a>
  <?php }?>
</content>


<?php    } else {?>
          <p> No result for keyword "<?php echo $search;?>". </p>
<?php    } 
  }

  elseif($key=="subject"){
    $start_from = ($page)*$resultperpage;
    $que="SELECT * FROM book_info bi JOIN books b ON bi.book_id=b.book_id WHERE b.book_id NOT IN (SELECT cart.book_id FROM cart) AND book_subject LIKE '%$search%' order by b.book_id asc limit $start_from,".$resultperpage;
    $result_subject = mysqli_query($dbconn,$que);
    $numsubjects = mysqli_num_rows($result_subject);

    $sql = "SELECT * FROM book_info bi JOIN books b ON bi.book_id=b.book_id WHERE b.book_id NOT IN (SELECT cart.book_id FROM cart) AND book_subject LIKE '%$search%' order by b.book_id asc";
    $retval = mysqli_query($dbconn, $sql);
    $totalbooks = mysqli_num_rows($retval);
    $totalpages = ceil($totalbooks/$resultperpage);?>

<h2 id="res_label"> Filter by <?=$key?> </h2>
<?php
    if(mysqli_num_rows($result_subject)>0){ ?>

<div  id="subject" class="sorted well well-sm">
<?php
      while($row2=mysqli_fetch_assoc($result_subject)){ 
          $book_id = $row2['book_id'];?>
          <?php
            $sql = "SELECT account_id from books where book_id='$book_id' limit 1";
            $result_sql = mysqli_query($dbconn, $sql);
            $row_account = mysqli_fetch_assoc($result_sql);
            $owner_id = $row_account["account_id"];
          ?>
          <a class="bookshelf_book_container" 
          href=<?php if($owner_id==$id){?>"Book_info.php?id=<?=$book_id?>"
          <?php } else{ ?>
            "Public_book_info.php?id=<?=$book_id?>" <?php }?>>
            <content class="bookshelf_book">
              <img title="<?=$row2['book_name']?>" alt="<?=$row2['book_name']?>" height="225" width="150" class="" src="<?php echo $row2['book_imagepath']; ?>">
              <label>Php<?=$row2["book_price"];?></label>
            </content>
          </a>
<?php } ?>
</div>

<content id="res_prev_next">
  <?php if($page=='0' and $totalpages!='1'){?>
    <a href="result.php?page=<?php echo $page+1?>&amp;ID=<?php echo $search?>&amp;key=subject" id="next" >Next >> </a>
  <?php }else if($page==$totalpages-1 and $totalpages!='1'){?>
    <a href="result.php?page=<?php echo $page-1?>&amp;ID=<?php echo $search?>&amp;key=subject" id="prev" ><< Prev </a>
  <?php }else if($totalpages=='1'){ ?>
    <p></p>
  <?php }else{?>  
    <a href="result.php?page=<?php echo $page-1?>&amp;ID=<?php echo $search?>&amp;key=subject" id="prev" ><< Prev </a> &nbsp;|&nbsp;
    <a href="result.php?page=<?php echo $page+1?>&amp;ID=<?php echo $search?>&amp;key=subject" id="next" >Next >> </a>
  <?php }?>
</content>

<?php    } else {?>
          <p> No result for keyword "<?php echo $search;?>". </p>
<?php    } 
  }

  elseif($key=="user"){
    $start_from = ($page)*$resultperpage;
    $que="SELECT * FROM account WHERE account_name LIKE '%$search%' and account_id!= '$id' order by account_id asc limit $start_from,".$resultperpage;
    $result_account = mysqli_query($dbconn,$que);
    $numaccounts = mysqli_num_rows($result_account);
    
    $sql="SELECT * FROM account WHERE account_name LIKE '%$search%' and account_id != '$id' order by account_id asc";
    $retval = mysqli_query($dbconn, $sql);
    $totalaccounts = mysqli_num_rows($retval);
    $totalpages = ceil($totalaccounts/$resultperpage);?>

<h2 id="res_label"> Filter by <?=$key?> </h2>
<?php
    if(mysqli_num_rows($result_account)>0){ ?>

<div id="user" class="sorted">
<?php
      while($row3=mysqli_fetch_assoc($result_account)){ 
        $image = $row3['account_imagepath'];
        $course = $row3['course'];?>
        <div id="user" class="well well-sm">
          <img id="seller_pic" src="<?=$image?>">
          <label for='seller' id="no_line"><a href="<?php echo "Seller_profile.php?seller=".$row3["account_id"];?>"><?php echo $row3["account_name"] ?></a></label>
          <label for='course_seller' id="no_line2"><?php echo $course?></label>
        </div>
<?php } ?>      
</div>

<content id="res_prev_next">
  <?php if($page=='0' and $totalpages!='1'){?>
    <a href="result.php?page=<?php echo $page+1?>&amp;ID=<?php echo $search?>&amp;key=user" id="next" >Next >> </a>
  <?php }else if($page==$totalpages-1 and $totalpages!='1'){?>
    <a href="result.php?page=<?php echo $page-1?>&amp;ID=<?php echo $search?>&amp;key=user" id="prev" ><< Prev </a>
  <?php }else if($totalpages=='1'){ ?>
    <p></p>
  <?php }else{?> 
    <a href="result.php?page=<?php echo $page-1?>&amp;ID=<?php echo $search?>&amp;key=user" id="prev" ><< Prev </a> &nbsp;|&nbsp;
    <a href="result.php?page=<?php echo $page+1?>&amp;ID=<?php echo $search?>&amp;key=user" id="next" >Next >> </a>
  <?php }?>
</content>

<?php    } else {?>
          <p> No result for keyword "<?php echo $search;?>". </p>
<?php    }
   } ?>

</div>


  <!-- DONT -->
  </div>  
    <footer>
      <p>A.Y. 2016-2017 Bookshare | &copy;CMSC 128 Lab Sec. 2 |  2016</p>
    </footer>
  </div>
</body>
</html>

<script type="text/javascript" charset="utf-8">
function addmsg(type, msg){
  $('#notification_count').html(msg);
}
function waitForMsg(){
  var id = <?php echo json_encode($id);?>;  
  $.ajax({
  type: "GET",
  url: "shopping.php?id="+id,
  async: true,
  cache: false,
  timeout:50000,
 
  success: function(data){
    addmsg("new", data);
    setTimeout(
      waitForMsg,
      1000
    );
  },
  error: function(XMLHttpRequest, textStatus, errorThrown){
    addmsg("error", textStatus + " (" + errorThrown + ")");
    setTimeout(
      waitForMsg,
      15000);
    }
  });
};
 
$(document).ready(function(){
  waitForMsg();
});
</script>