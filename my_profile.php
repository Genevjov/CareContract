<?php
require "contracts_functions.php";
require "functions.php";
session_start();
$login = $_SESSION['login'];
$get_FSO = getUserNameByLogin($login);
$first_name = $get_FSO['first_name'];
$second_name = $get_FSO['second_name'];
$stat = getStat($login);
$stars = $stat['stars'];
$closed_contracts = $stat['contracts'];
$getEmail = getEmailByLogin($login);
$email = $getEmail['email'];
$user_data = getInfo($login);
$date_of_birth = ($user_data['old'] === null) ? "Not indicated" : $user_data['old'];
$country = ($user_data['country'] === null) ? "Not indicated" : $user_data['country'];
$city = ($user_data['city'] === null) ? "Not indicated" : $user_data['city'];
$education = ($user_data['education'] === null) ? "Not indicated" : $user_data['education'];
$number = ($user_data['phone'] === null) ? "Not indicated" : $user_data['phone'];
$bio = ($user_data['bio'] === null) ? "Not indicated" : $user_data['bio'];



session_destroy();
session_start();
$_SESSION['login'] = $login;
?>
<!DOCTYPE HTML>
<html>
<head>
    <title><?php echo $first_name;
        echo ' ';
        echo $second_name; ?></title>
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
         </head>

<style>
    html {
        background-color: #c1bdba;
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
    .header {
        background: linear-gradient(to right, #24313c, #1ab188);
        position: absolute;
        width: 1368px;
        height: 150px;
        margin-top: -10px;
        margin-left: -10px;
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
        margin-top: 0px;
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
        height: 489px;
        background-color: #655050;
        margin-left: -10px;
        margin-top: 140px;
    }

    .button_bar ul li a:hover {
        background-color: #1ab188;
        transition: 1.5s;
    }
    .information{
        position:absolute;
        font-family: 'Roboto Condensed';
        font-size:25px;
        margin-top: 180px;
        margin-left: 240px;
        padding-top: 10px;
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
        height:489px;
        background-color:black;
        margin-top:140px;
        margin-left:750px;
    }
    .bio{
        position: absolute;
        font-family:"Roboto Condensed";
        margin-top:200px;
        margin-left:850px;
        width:400px;
        font-size:20px;
    }


</style>

<body>
<div class="header">
    <div class="user_photo"></div>
    <div class="user_name"><? echo "$first_name $second_name ($login)" ?></div>
    <div class="rating">
        <ul>
            <li><img src="images/002-star.png"/></li>
            <li class="star_value"><?php echo $stars?></li>
            <li><img src="images/001-diploma.png"/></li>
            <li class="rating_value"><?php echo $closed_contracts?></li>
        </ul>
    </div>
</div>
<div class="button_bar_panel">

    <div class="photo"></div>

    <div class="button_bar">
    <?php
            $num = check_for_messages($login);
            if($num > 0 && $num < 10){
                echo "<div class='indicator'>$num</div>";
            } elseif($num >= 10){
               echo "<div class='indicator'>!</div>";
            }
            $new_contracts = checkForNewContracts($login);
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
   
</div>
<div class ="user_info">
            <div class = "information">
                <ul>
                    <li>Name: <?php echo "$first_name $second_name"?></li>
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