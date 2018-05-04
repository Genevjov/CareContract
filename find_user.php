<?php
require 'functions.php';
require "contracts_functions.php";

session_start();
$login = $_SESSION['login'];
if(isset($_POST['goPage'])){
    $u_login = $_POST['login'];
    if($u_login == $login){
        header('Location: my_profile.php');
        exit();
    }else{
        session_start();
        $_SESSION['my_login'] = $login;
        $_SESSION['user_login'] = $u_login;
        header('Location: user_profile.php');
       }
}
?>
<!DOCTYPE <HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Find user</title>


    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">

    <style>
     html {
        background-color: #c1bdba;
    }

    .button_bar {
        margin-top: 166px;
        margin-left: 20px;
        text-decoration: none;
    }

    .button_bar ul li {
        list-style: none;
        display: inline;
        padding-left: 100px;
        text-decoration: none;
    }

    .button_bar ul li a {
        text-decoration: none;
        width: 100px;
        padding: 11px;
        text-align: center;
        background-color: #949494;
        display: block;
        color: white;
    }
    .dialogs_list{
        text-decoration: none;

    }
    

    .button_bar_panel {
        position: absolute;
        width: 250px;
        height: 639px;
        background-color: #655050;
        margin-left: -10px;
        margin-top: -10px;
    }
    .contracts_indicator{
        position:absolute;
        margin-top:80px;
        background-color:red;
        border-radius:50px;
        width:20px;
        height:20px;
        margin-left:150px;
        text-align: center;
    }

    .button_bar ul li a:hover {
        background-color: #1ab188;
        transition: 1.5s;
    }

    .photo {
        background-image: url("../images/man1.png");
        position: absolute;
        width: 128px;
        height: 128px;
        margin-top: 10px;
        margin-left: 60px;
    }

    .name {
        position: absolute;
        color: white;
        margin-top: 150px;
        margin-left: 90px;
    }

    .indicator {
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 50px;
        background-color: red;
        text-align: center;
        margin-top: 160px;
        margin-left: 150px;
    }
    .search_form {
        background-color: wheat;
        position: absolute;
        width: 400px;
        height: 639px;
        margin-top: -639px;
        margin-left: 250px;
    }
    .search_name{
        position:absolute;
        margin-top:100px;
        outline:none;
        margin-left: 70px;
        width:255px;
        border-radius:20px;
        padding-left:10px;

    }
    .search_sname{
        position:absolute;
        margin-top:150px;
        outline:none;
        margin-left: 70px;
        width:255px;
        border-radius:20px;
        padding-left:10px;

    }
    .search_login{
        position:absolute;
        margin-top:200px;
        outline:none;
        margin-left: 70px;
        width:255px;
        border-radius:20px;
        padding-left:10px;
    }
    .search_email{
        position:absolute;
        margin-top:250px;
        outline:none;
        margin-left: 70px;
        width:255px;
        border-radius:20px;
        padding-left:10px;

    }
   
    .find{
        position:absolute;
        margin-top: 290px;
        margin-left:180px;
        outline:none;
        border-color:transparent;
        border-radius:20px;
        font-size:20px;
        font-family: 'Roboto Condensed';
        background-color: #949494;
    }
    .find:hover{
        background-color: #1ab188;
    } .find:active{
        background-color: #949494;

    }
    .founded_user{
        margin-top:-500px;
        margin-left:720px;
        width:500px;
        height:100px;
        background-color:#79afce;
        text-align:center;
        
    }
    .user_input{
        position:absolute;
        background-color:transparent;
        border-width:0px;
        font-size:20px;
        margin-left:-150px;
        margin-top:35px;
        font-family:"Roboto Condensed"


    }
    ul{
        list-style:none;
    }
   
    .users ul li button {
        position:absolute;
        width:150px;
        height:50px;
        margin-top:25px;
        margin-left:30px;
        outline:none;
        border-width:0px;
        background-color: #1ab188;
    }
    .users ul li form{
        position:absolute;
        
    }
    .not_found{
        position:absolute;
        margin-left:950px;
        margin-top:-350px;
        width:150px;
        font-size:25px;
        font-family: "Lato";
        color:gray;
    }
    .user_login{
        position:absolute;
        width:0px;
        border-width:0px;
    }
    .user_name{
        position:absolute;
        background: transparent;
        border-width:0px;
        margin-top:35px;
        margin-left:-200px;
        font-family: "lato";
        font-size:20px;
    }
    
    </style>


 </head>
<body>
<div class="button_bar_panel">
    <div class="photo"></div>
    <div class="name"><?php echo $login ?></div>
    <div class="button_bar">
    <?php
            $num = check_for_messages($login);
            if($num > 0 && $num < 10){
                echo "<div class='indicator'>$num</div>";
            } elseif($num >= 10){
               echo "<div class='indicator'>!</div>";
            }
        ?>
        <ul>
        <li><a href="my_profile.php">Home</a></li>
        <li><a href="contracts.php">Contracts</a></li>
        <li><a href="messages.php">Messages</a></li>
        <li><a href="settings.php">Edit profile</a></li>
        <li><a href="find_user.php">Find user</a></li>
        <li><a href="exit.php">Exit</a></li>
        </ul>
    </div>
    <?php
        if(isset($_POST['find'])){
            $connection = connectDB();
            $sLogin = trim($_POST['login']);
            $first_name = trim($_POST['name']);
            $second_name = trim($_POST['second_name']);
            $email = trim($_POST['email']);
            //ALL
            if (!empty($first_name) && !empty($sLogin) && !empty($second_name) && !empty($email)){
                $query = "SELECT * from users where first_name = '$first_name' and second_name = '$second_name' and
                 login = '$sLogin' and email = '$email'";
                 $result = mysqli_query($connection, $query);
                 if (mysqli_num_rows($result) != 0){
                   printFoundedUsers($result);
               } else {
                   notFound();
               }
                //First_name and email
            }elseif (!empty($first_name) && !empty($second_name)){
                $query = "SELECT * from users where first_name = '$first_name' and second_name = '$second_name'";
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) != 0){
                  printFoundedUsers($result);
              } else {
                  notFound();
              }
                // First_name and login
            }elseif (!empty($first_name) && !empty($sLogin)){
            $query = "SELECT * from users where first_name = '$first_name' and login = '$sLogin'";
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) != 0){
              printFoundedUsers($result);
          } else {
              notFound();
          }
            
             }
             //First_name and email
             elseif (!empty($first_name) && !empty($email)){
            $query = "SELECT * from users where first_name = '$first_name' and email = '$email'";
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) != 0){
              printFoundedUsers($result);
          } else {
              notFound();
          }
            }
            //Second_name and login
            elseif (!empty($second_name) && !empty($sLogin)){
                $query = "SELECT * from users where second_name = '$second_name' and login = '$sLogin'";
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) != 0){
                  printFoundedUsers($result);
              } else {
                  notFound();
              }
            //Second_name and email
        }elseif (!empty($second_name) && !empty($email)){
            $query = "SELECT * from users where second_name = '$second_name' and email = '$email'";
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) != 0){
              printFoundedUsers($result);
          } else {
              notFound();
          }
            //Login and email
        }elseif (!empty($sLogin) && !empty($email)){
            $query = "SELECT * from users where login = '$sLogin' and email = '$email'";
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) != 0){
              printFoundedUsers($result);
          } else {
              notFound();
          }
             // First name
        }elseif (!empty($first_name)){
            $query = "SELECT * from users where first_name = '$first_name'";
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) != 0){
              printFoundedUsers($result);
          } else {
              notFound();
          }
            //Second name
        }elseif (!empty($second_name)){
            $query = "SELECT * from users where second_name = '$second_name'";
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) != 0){
              printFoundedUsers($result);
          } else {
              notFound();
          }
            //Login
        }elseif (!empty($sLogin)){
            $query = "SELECT * from users where login = '$sLogin'";
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) != 0){
              printFoundedUsers($result);
          } else {
              notFound();
          }
            //email
        }elseif (!empty($email)){
            $query = "SELECT * from users where email = '$email'";
            $result = mysqli_query($connection, $query);
              if (mysqli_num_rows($result) != 0){
                printFoundedUsers($result);
            } else {
                notFound();
            }
        }
        mysqli_close($connection);       
    }          ?>
    <div class = "search_form">
        <form action = <?php echo $_SERVER['PHP_SELF']; ?> method = "POST">
            <input class="search_name" placeholder="First name" name = "name"/>
            <input class="search_sname" placeholder="Second name" name = "second_name"/>
            <input class="search_login" placeholder="Login" name = "login"/>
            <input class="search_email" placeholder="Email" name = "email"/>
            
            <button class="find" type="submit" name = "find">Find</button>
        </div>
    </div>

   
        <?php
        function printFoundedUsers($mysql_result){
            echo '<div class = "users">
            <ul>';

           while( $row = $mysql_result->fetch_assoc()){
            $first_name = $row['first_name'];
            $second_name = $row['second_name'];
            $sLogin = $row['login'];
                echo '
                <li>
                <form class = "founded_user"action ='.$_SERVER['PHP_SELF'].' method="POST">
                <input class ="user_name" readonly  value ="'.$first_name.' '.$second_name.' ('.$sLogin.')"></input>
                <input class ="user_login" readonly name="login" value ='.$sLogin.'></input>
                <button type = "submit" name = "goPage">Watch page</button>
                </form>
                </li>';
            }
            echo ' </ul></div>';

        }
            function notFound(){
                echo "<div class = 'not_found'>Not found.</div>";
            }
        ?>
        </ul>
    </div>
</body>
</html>