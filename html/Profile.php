<?php
  include("connect.php");
  include("search_book.php");
  session_start();
  ?>
  <?php      
      $account_id = $_SESSION['buyer_id'];
      $user_query= "SELECT * from account where account_id='$account_id'";
      $user_result=mysqli_query($dbconn, $user_query);
      $row_session = mysqli_fetch_assoc($user_result);
      $account_name = $row_session['account_name'];
      $user_name = $row_session['username'];
      $password = $row_session['password'];
      $year_level = $row_session['year_level'];
      $user_image = $row_session['account_imagepath'];
      $course = $row_session['course'];
      $query1 ="SELECT * FROM account_contacts where account_id='$account_id'";
      $result1 = mysqli_query($dbconn, $query1);
      $query2 ="SELECT * FROM account_emails where account_id='$account_id'";
      $result2 = mysqli_query($dbconn, $query2);
  
    ?>

<!DOCTYPE html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta name="author" content="CMSC 128 Lab Sec. 2">
  <meta name="description" content="Sell, buy, and trade books with your schoolmates.">
  <meta name="keywords" content="Book, Books, Trade Book, Sell Book, Buy Book">
  <title>Your Profile</title>

  <link rel="shortcut icon" href="../images/official_logo.png">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/profile_style.css">
  <script src="../js/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <script src="../js/modal.js"></script>
  <script src="../js/custom-file-input.js"></script>
  <script src="../js/jquery.min.js"></script>
  <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

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
                  <img src="<?php echo $user_image?>" title="Profile" alt="Profile" height="40" width="40" id="logo2">
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
      <a href="Profile.php"><h1 id="bookshelf">User Profile</h1></a>
    
    <div class="profile_header">
      <aside>
        <div>
          <img id="user_pic" src="<?php echo $user_image;?>"  alt="user photo">
        </div>  
        <div id="yrlvl_course">
          <label id="course"><?php echo  $course?></label>
          <label><?php echo  $year_level?></label>
        </div>
      </aside>
      <div id="profile_side">
        <div id="prof_name">
          <label id="accountname"><?php echo  $account_name?></label>
          <label id="username"><?php echo $user_name?></label>
        </div>
        <div id="contact_section">
          <label>Contact Number/s:</label> 
<?php       while($row1 = mysqli_fetch_assoc($result1)){ 
              $contact_number=$row1['contact_number'];?>
              <div id="multi_inputs">
                <content><?php echo $contact_number; ?></content>
              </div>
<?php    } ?>
        </div>
        <div id="contact_section">
          <label>Email/s:</label> 
<?php       while($row1 = mysqli_fetch_assoc($result2)){ 
                $email = $row1['email'];?>
                <div id="multi_inputs">
                    <content><?php echo  $email; ?></content>
                </div>
<?php    } ?>
        </div>
      </div>
    </div>

<div class="activity_section">
  <div class="icon_section">
      <a href="View_Bookmarks.php">
        <img id="bookmark" src="../images/logo_bookmark.png" alt="Bookmarks" title="View your bookmarks">
      </a>
      <a href="Shopping_list.php">
        <img id="cart" src="../images/cart.png" alt="Shopping List" title="Go to your Shopping List">
      </a>
      <a href="Bookshelf.php" id="bookshelf_section">
        <div id="image_bookshelf">
          <img src="../images/bookshelf.png">
        </div>
        <div id="label_bookshelf">
          <img src="../images/label_bookshelf.png">
        </div>
      </a>
  </div>




<div class="notif_section well well-sm">
      <h2>Activity Log</h2>
    <!-- PHP NI DIRI -->

    <?php  
            $transaction_buyer; $transaction_seller; $transaction_date; $prev_buyer_id=""; $prev_seller_id=""; $prev_date="";
    
              
              $activity = "SELECT * from (select `cart`.`seller_id` AS `seller_id`,`seller`.`account_name` AS `seller`,`cart`.`book_id` AS `book_id`,`cart`.`date` AS `date`,`books`.`book_name` AS `book_name`,`books`.`book_price` AS `book_price`,`cart`.`buyer_id` AS `buyer_id`,`buyer`.`account_name` AS `buyer` from (((`cart` join (select `account`.`account_id` AS `account_id`,`account`.`account_name` AS `account_name` from `account`) `seller` on((`seller`.`account_id` = `cart`.`seller_id`))) join (select `account`.`account_id` AS `account_id`,`account`.`account_name` AS `account_name` from `account`) `buyer` on((`buyer`.`account_id` = `cart`.`buyer_id`))) join (select `books`.`book_name` AS `book_name`,`books`.`book_id` AS `book_id`,`books`.`book_price` AS `book_price` from `books`) `books` on((`cart`.`book_id` = `books`.`book_id`)))) 
              as transactions where  seller_id = '$account_id' or buyer_id = '$account_id' order by date desc, seller";
              $activity_result = mysqli_query($dbconn, $activity);
              
     while($activity_row = mysqli_fetch_assoc($activity_result)){
             
              $transaction_buyer_id= $activity_row['buyer_id'];
              $transaction_seller_id= $activity_row['seller_id'];
              $transaction_date= $activity_row['date'];
              $transaction_buyer = $activity_row['buyer'];
              $transaction_seller= $activity_row['seller'];
              if($transaction_buyer_id != $prev_buyer_id || $transaction_seller_id != $prev_seller_id && $transaction_date != $prev_date){
              $user_buyer = "SELECT * from (select `cart`.`seller_id` AS `seller_id`,`seller`.`account_name` AS `seller`,`cart`.`book_id` AS `book_id`,`cart`.`date` AS `date`,`books`.`book_name` AS `book_name`,`books`.`book_price` AS `book_price`,`cart`.`buyer_id` AS `buyer_id`,`buyer`.`account_name` AS `buyer` from (((`cart` join (select `account`.`account_id` AS `account_id`,`account`.`account_name` AS `account_name` from `account`) `seller` on((`seller`.`account_id` = `cart`.`seller_id`))) join (select `account`.`account_id` AS `account_id`,`account`.`account_name` AS `account_name` from `account`) `buyer` on((`buyer`.`account_id` = `cart`.`buyer_id`))) join (select `books`.`book_name` AS `book_name`,`books`.`book_id` AS `book_id`,`books`.`book_price` AS `book_price` from `books`) `books` on((`cart`.`book_id` = `books`.`book_id`))) ) 
              as transactions where buyer_id  = '$transaction_buyer_id' and date='$transaction_date'";
             
              $user_seller = "SELECT * from (select `cart`.`seller_id` AS `seller_id`,`seller`.`account_name` AS `seller`,`cart`.`book_id` AS `book_id`,`cart`.`date` AS `date`,`books`.`book_name` AS `book_name`,`books`.`book_price` AS `book_price`,`cart`.`buyer_id` AS `buyer_id`,`buyer`.`account_name` AS `buyer` from (((`cart` join (select `account`.`account_id` AS `account_id`,`account`.`account_name` AS `account_name` from `account`) `seller` on((`seller`.`account_id` = `cart`.`seller_id`))) join (select `account`.`account_id` AS `account_id`,`account`.`account_name` AS `account_name` from `account`) `buyer` on((`buyer`.`account_id` = `cart`.`buyer_id`))) join (select `books`.`book_name` AS `book_name`,`books`.`book_id` AS `book_id`,`books`.`book_price` AS `book_price` from `books`) `books` on((`cart`.`book_id` = `books`.`book_id`))) ) 
              as transactions where seller_id = '$transaction_seller_id' and date='$transaction_date'";
              $user_buyer_result = mysqli_query($dbconn, $user_buyer);
              $user_seller_result = mysqli_query($dbconn, $user_seller);
              $fetch_row;
              
                  //echo $transaction_seller;
                  //echo $transaction_buyer;
                
                //echo mysqli_num_rows($activity_result);
          ?>

          <?php
                          $user_is_buyer=0; $transaction_person;
                              if($account_id == $transaction_seller_id){
                                $transaction_person = $transaction_buyer;
                                $user_is_buyer = 1;
                           }
                              else if ($account_id == $transaction_buyer_id){
                                  $transaction_person = $transaction_seller;
                                  $user_is_buyer = 0;
                                
                              }
            ?>

          <?php
                      $query; $query_result; $message;
                    if($user_is_buyer == 0){
                      $query = "SELECT message_details from message_content where message_id=1";
                      $query_result = mysqli_query($dbconn, $query);
                      while($fetch_row = mysqli_fetch_assoc($query_result)){
                          $message = $fetch_row['message_details'];
                        }}
            else{
                      $counter = 1;
                      $query = "SELECT message_details from message_content where message_id=2";
                      $query_result = mysqli_query($dbconn, $query);
                      while($fetch_row = mysqli_fetch_assoc($query_result)){
                          $message = $fetch_row['message_details'];
                        }
                      $records = ("SELECT * from (select `cart`.`seller_id` AS `seller_id`,`seller`.`account_name` AS `seller`,`cart`.`book_id` AS `book_id`,`cart`.`date` AS `date`,`books`.`book_name` AS `book_name`,`books`.`book_price` AS `book_price`,`cart`.`buyer_id` AS `buyer_id`,`buyer`.`account_name` AS `buyer` from (((`cart` join (select `account`.`account_id` AS `account_id`,`account`.`account_name` AS `account_name` from `account`) `seller` on((`seller`.`account_id` = `cart`.`seller_id`))) join (select `account`.`account_id` AS `account_id`,`account`.`account_name` AS `account_name` from `account`) `buyer` on((`buyer`.`account_id` = `cart`.`buyer_id`))) join (select `books`.`book_name` AS `book_name`,`books`.`book_id` AS `book_id`,`books`.`book_price` AS `book_price` from `books`) `books` on((`cart`.`book_id` = `books`.`book_id`))) ) 
                        as transactions where seller_id = '$account_id'" );
                      $records_result = mysqli_query($dbconn, $records);
                     ?>

                 <?php } ?>

      <div class="log_content">
          <img src="../images/user_pic.jpg" id="user_pic2">
          <p id="act_content"><?= $message; ?><strong><?php echo $transaction_person;?></strong><br> 
           </p>
          <div id="act_date"><?php echo $transaction_date?></div>
      
<?php                       
        $records = ("SELECT * from (select `cart`.`seller_id` AS `seller_id`,`seller`.`account_name` AS `seller`,`cart`.`book_id` AS `book_id`,`cart`.`date` AS `date`,`books`.`book_name` AS `book_name`,`books`.`book_price` AS `book_price`,`cart`.`buyer_id` AS `buyer_id`,`buyer`.`account_name` AS `buyer` from (((`cart` join (select `account`.`account_id` AS `account_id`,`account`.`account_name` AS `account_name` from `account`) `seller` on((`seller`.`account_id` = `cart`.`seller_id`))) join (select `account`.`account_id` AS `account_id`,`account`.`account_name` AS `account_name` from `account`) `buyer` on((`buyer`.`account_id` = `cart`.`buyer_id`))) join (select `books`.`book_name` AS `book_name`,`books`.`book_id` AS `book_id`,`books`.`book_price` AS `book_price` from `books`) `books` on((`cart`.`book_id` = `books`.`book_id`))) ) as transactions
                        where seller_id = '$transaction_seller_id' and date = '$transaction_date' order by book_name" );
        $records_result = mysqli_query($dbconn, $records);?>

  <div class="box">
    <div class="top">
      <button class="btn btn-primary" name="view" id="view">Book List</button>
    </div>
    <div class="bottom">
      <table>
      <tr>
        <th>Book</th>
        <th>Price</th>
      </tr>
        <?php while($records_row = mysqli_fetch_assoc($records_result)) {?>
        <tr>
          <td><a href="Book_info.php?id=<?php echo $row["book_id"];?>"><?php echo $records_row['book_name'];?></a></td>
          <td>Php<?php echo $records_row['book_price'];?></td>
        <?php } ?> 
        </tr>
        <tr >
          <td id=total>Total:</td>
          <td id=total><?= '0000' ?>
        </tr>
      </table> 
    </div>
  </div>

</div>
  

                    
      <?php 
    }
      $prev_buyer_id = $transaction_buyer_id;
      $prev_seller_id = $transaction_seller_id;
      $prev_date = $transaction_date;
    } ?>
        

    </div>
</div>
<!-- DON'T -->
    </div>
    <footer>
      <p>A.Y. 2016-2017 Bookshare | &copy;CMSC 128 Lab Sec. 2 |  2016</p>
    </footer>
  </div>


</body>
</html>

<!-- TOGGLES -->
<script>
$('.top').on('click', function() {
  $parent_box = $(this).closest('.box');
  $parent_box.siblings().find('.bottom').slideUp();
  $parent_box.find('.bottom').slideToggle(200, 'swing');
});
</script>