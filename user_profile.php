<?php
require 'functions.php';
require "contracts_functions.php";

session_start();
$my_login = $_SESSION['my_login'];
$user_login = $_SESSION['user_login'];
$row = getUserNameByLogin($user_login);
$USER_FIRST_NAME = $row['first_name'];
$USER_SECOND_NAME = $row['second_name'];
$row = getStat($user_login);
$stars = $row['stars'];
$closed_contracts = $row['contracts'];
$getEmail = getEmailByLogin($user_login);
$email = $getEmail['email'];
$user_data = getInfo($user_login);
$date_of_birth = ($user_data['old'] === null) ? "Not indicated" : $user_data['old'];
$country = ($user_data['country'] === null) ? "Not indicated" : $user_data['country'];
$city = ($user_data['city'] === null) ? "Not indicated" : $user_data['city'];
$education = ($user_data['education'] === null) ? "Not indicated" : $user_data['education'];
$number = ($user_data['phone'] === null) ? "Not indicated" : $user_data['phone'];
$bio = ($user_data['bio'] === null) ? "Not indicated" : $user_data['bio'];
$block_button_text = isUserBlockedByMe($my_login, $user_login) ? "Block" : "Unblock";

    if (isset($_POST['add_star'])){
        if(isUserBlocked($user_login, $my_login)){
                if(checkAddedStar($my_login, $user_login)){
                    addStar($my_login, $user_login);
                    session_start();
                    $_SESSION['my_login'] = $my_login;
                    $_SESSION['user_login'] = $user_login;
                    header('Location: user_profile.php');
        } else{
            echo '<div class = "error">Star have already added!</div>';
        }
    }else{
        echo '<div class = "error">This user blocked you!</div>';
        }
    }

    if(isset($_POST['block'])){
        blockUser($my_login, $user_login);
        session_start();
        $_SESSION['my_login'] = $my_login;
        $_SESSION['user_login'] = $user_login;
        header('Location: user_profile.php');
        exit;   
    }
    if(isset($_POST['offer_contract'])){
        session_start();
        $_SESSION['my_login'] = $my_login;
        $_SESSION['user_login'] = $user_login;
        header('Location: create_contract.php');
        exit;
    }

    function gotoMessages(){
         session_start();
        $_SESSION['my_login'] = $my_login;
        $_SESSION['message_resiver'] = $user_login;
        header('Location: messages.php');
        exit();   
    }

    if(isset($_POST['block']) && $block_button_text === 'Unblock'){
        unblock($my_login, $user_login);
        session_start();
        $_SESSION['my_login'] = $my_login;
        $_SESSION['user_login'] = $user_login;
        header('Location: user_profile.php');
    }

    if(isset($_POST['send_message'])){
        if(isChatExists($my_login,$user_login)){
            createChat($my_login,$user_login);
            gotoMessages();
        }else{
            gotoMessages();
        }
    }
    
  
?>
 <!DOCTYPE html>
 <html>
 <head>
     <meta charset="utf-8" />
     <title><?php echo $USER_FIRST_NAME; echo ' '; echo $USER_SECOND_NAME ?></title>
     <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
     <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">


 </head>
 <style> 
    .error{
        position:absolute;
        margin-top:185px;
        margin-left:715px;
        color:red;
        font-family: "Roboto Condensed";
    }
    html {
        background-color: #c1bdba;
    }
    .header {
        background: linear-gradient(to right, #24313c, #1ab188);
        position: absolute;
        width: 1118px;
        height: 150px;
        margin-top: -640px;
        margin-left: 250px;
    }

    .user_photo {
        position: relative;
        background-image: url(images/man1.png);
        width: 128px;
        height: 128px;
        margin-top: 10px;
        margin-left: 60px;
    }

    .user_name {
        color: white;
        margin-top: -75px;
        margin-left: 240px;
    }

    .rating {
        list-style: none;
        position: absolute;
        margin-top: -60px;
        margin-left: 350px;
        text-align: center;

    }

    .rating ul li {
        list-style: none;
        display: inline;
        padding-left: 150px;
        text-align: center;
        color: white;

    }

    .rating ul {
        text-align: center;
    }

    .rating_value {
        position: absolute;
        margin-top: -42px;
        margin-left: 70px;
    }

    .star_value {
        position: absolute;
        margin-left: -145px;
        margin-top: 25px;
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

    .button_bar_panel {
        position: absolute;
        width: 250px;
        height: 639px;
        background-color: #655050;
        margin-left: -10px;
        margin-top: -10px;
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
    .offer_contract button{
        position:absolute;
        margin-top:-460px;
        margin-left:280px;
        width:200px;
        text-align:center;
        height:50px;
        border-width:0px;
        outline:none;
        background-color:#949494;
        color:white;
        border-radius:20px;
        font-family: 'Roboto Condensed';
        font-size:20px;
    }
    .offer_contract button:hover{
        background-color: #1ab188;
        transition: 0.5s;
    }
    .send_message button{
        position:absolute;
        margin-top:-460px;
        margin-left:500px;
        width:200px;
        text-align:center;
        height:50px;
        border-width:0px;
        outline:none;
        background-color:#949494;
        color:white;
        border-radius:20px;
        font-family: 'Roboto Condensed';
        font-size:20px;
    }
    .send_message button:hover{
        background-color: #1ab188;
        transition: 0.5s;
    }
    .add_star button{
        position:absolute;
        margin-top:-460px;
        margin-left:910px;
        width:200px;
        text-align:center;
        height:50px;
        border-width:0px;
        outline:none;
        background-color:#949494;
        color:white;
        border-radius:20px;
        font-family: 'Roboto Condensed';
        font-size:20px;
    } 
    .add_star button:hover{
        background-color: #1ab188;
        transition: 0.5s;
    }
    .block button{
        position:absolute;
        margin-top:-460px;
        margin-left:1130px;
        width:200px;
        text-align:center;
        height:50px;
        border-width:0px;
        outline:none;
        background-color:#949494;
        color:white;
        border-radius:20px;
        font-family: 'Roboto Condensed';
        font-size:20px;
    }
    .block button:hover{
        background-color: RED;
        transition: 0.5s;
    }
    .information{
        position:absolute;
        font-family: 'Roboto Condensed';
        font-size:25px;
        margin-top: -400px;
        margin-left: 250px;
        padding-top: 10px;
        width:400px;
        
    }
    .information ul{
        list-style: none;
    }
    .information ul li{
        padding-top:10px;
    }
    .separator{
        position:absolute;
        width:1px;
        height:370px;
        background-color:black;
        margin-top:-370px;
        margin-left:750px;
    }
    .bio{
        position: absolute;
        font-family:"Roboto Condensed";
        margin-top:-300px;
        margin-left:850px;
        width:400px;
        font-size:20px;
    }

    
 </style>
 <body>
 
 <div class="button_bar_panel">
    <div class="photo"></div>
    <div class="name"><?php echo $my_login ?></div>
    <div class="button_bar">
    <?php
            $num = check_for_messages($my_login);
            if($num > 0 && $num < 10){
                echo "<div class='indicator'>$num</div>";
            } elseif($num >= 10){
               echo "<div class='indicator'>!</div>";
            }
            $new_contracts = checkForNewContracts($my_login);
            if($new_contracts > 0 && $new_contracts < 10){
                echo '<div class = "contracts_indicator">'.$new_contracts.'</div>';
            }elseif($new_contracts >=10 ){
                echo '<div class = "contracts_indicator">!</div>';

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
    <div class="header">
    <div class="user_photo"></div>
    <div class="user_name"><? echo "$USER_FIRST_NAME $USER_SECOND_NAME ($user_login)" ?></div>
    <div class="rating">
        <ul>
            <li><img src="images/002-star.png"/></li>
            <li class="star_value"><?php echo $stars?></li>
            <li><img src="images/001-diploma.png"/></li>
            <li class="rating_value"><?php echo $closed_contracts?></li>
        </ul>
    </div>
</div>
    <div class = "user_page_buttons">
    
            <form class = "offer_contract" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <button name = "offer_contract" type = "submit">Offer a contract</button></form>
            <form class = "send_message" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <button name = "send_message" type = "submit">Send message</button></form>
            <form class = "add_star" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <button name = "add_star" type = "submit">Add star</button></form>
            <form class = "block" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <button name = "block"  type = "submit"><?php echo $block_button_text?></button></form>
        </div>

        <div class ="user_info">
        <div class = "information">
            <ul>
                <li>Name: <?php echo "$USER_FIRST_NAME $USER_SECOND_NAME"?></li>
                <li>Years old: <?php echo "$date_of_birth"?> </li>
                <li>Country: <?php echo "$country"?></li>
                <li>City: <?php echo "$city"?></li>
                <li>Education: <?php echo $education?> </li>
                <li>Email: <?php echo "$email"?> </li>
                <li>Phone number: <?php echo "$number"?></li>
            </ul>

        </div>
        <div class = "separator"></div>
        <div class = "bio">
            <?php echo $bio?>
        </div>
</div>
 </body>
 </html>