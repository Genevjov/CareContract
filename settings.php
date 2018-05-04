<?php
require "functions.php";
require "contracts_functions.php";
session_start();
$login = $_SESSION['login'];
$get_FSO = getUserNameByLogin($login);
$first_name = $get_FSO['first_name'];
$second_name = $get_FSO['second_name'];
$stat = getStat($login);
$stars = $stat['stars'];
$closed_contracts = $stat['contracts'];
session_destroy();
session_start();
$_SESSION['login'] = $login;
                                                                
//TODO FIX
if(isset($_POST['change_date'])){
    $connection = connectDB();
    $years = mysqli_real_escape_string($connection, trim($_POST['date_of_birth']));
    if(!empty($years)){
        updateDateOfBirthByLogin($login,$years);
    } else{
        echo("Input cat't be empty");
    }
    mysqli_close($connection);
}

//Change password
if(isset($_POST['change_number'])){
    $connection = connectDB();
    $number = mysqli_real_escape_string($connection, trim($_POST['number']));
    if(!empty($number)){
        updatePhoneNumberByLogin($login,$number);
    } else{
        echo("Input cat't be empty");
    }
    mysqli_close($connection);
}

//Change email
if(isset($_POST['change_email'])){
    $connection = connectDB();
    $email = mysqli_real_escape_string($connection, trim($_POST['email']));
    if(!empty($email)){
        updateEmailByLogin($login,$email);
    } else{
        echo("Input cat't be empty");
    }
    mysqli_close($connection);
}

//Cange password
if(isset($_POST['change_password'])){
    $connection = connectDB();
    $password = mysqli_real_escape_string($connection, trim($_POST['password']));
    if(!empty($password)){
        updatePasswordByLogin($login,$password);
    } else{
        echo("Input cat't be empty");
    }
    mysqli_close($connection);
}

//Change country
if(isset($_POST['change_country'])){
    $connection = connectDB();
    $country = mysqli_real_escape_string($connection, trim($_POST['country']));
    if(!empty($country)){
        updateCountryByLogin($login,$country);
    } else{
        echo("Input cat't be empty");
    }
    mysqli_close($connection);
}

//Change city
if(isset($_POST['change_city'])){
    $connection = connectDB();
    $city = mysqli_real_escape_string($connection, trim($_POST['city']));
    if(!empty($city)){
        updateCityByLogin($login,$city);
    } else{
        echo("Input cat't be empty");
    }
    mysqli_close($connection);
}

//Change education
if(isset($_POST['change_education'])){
    $connection = connectDB();
    $education = mysqli_real_escape_string($connection, trim($_POST['education']));
    if(!empty($education)){
        updateEducationByLogin($login,$education);
    } else{
        echo("Input cat't be empty");
    }
    mysqli_close($connection);
}

//Change bio
if(isset($_POST['change_bio'])){
    $connection = connectDB();
    $bio = mysqli_real_escape_string($connection, trim($_POST['bio']));
    if(!empty($bio)){
        udpdateBio($login,$bio);
    } else{
        echo("Input cat't be empty");
    }
    mysqli_close($connection);
}



?>
<!DOCTYPE HTML>
    <html>
    <head>
        <title>Settings</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">

    </head>
    
    <style>
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
            margin-top: 120px;
            margin-left: 340px;
            padding-top: 25px;
        }
        .information ul{
        list-style: none;
        }
    
        .separator{
        position:absolute;
        width:1px;
        height:489px;
        background-color:black;
        margin-top:140px;
        margin-left:750px;
    }
    .action_button{
        position:absolute;
        margin-top: -21px;
        margin-left: 200px;
        outline:none;
        border-width:0px;
        border-color:transparent;
        font-family: 'Roboto Condensed';
        font-size:17px;
        border-radius:20px;
        background-color: #949494;
    }
    .action_button:hover{
        background-color:#1ab188;
    }
    .action_button:active{
        background-color:#949494;
    }
    .input_data{

    }
    .bio{
        position:absolute;
    }
    .bio_area{
        resize:none;
        width: 450px;
        height: 400px;
        position:absolute;
        margin-top:170px;
        margin-left: 830px;
    }
    .bio_button{
        position:absolute;
        border-width:0px;
        margin-top:590px;
        margin-left:1035px;
        font-family: "Roboto Condensed";
        font-size:20px;
        border-radius:20px;
        outline:none;
        background-color: #949494;
    }
    .bio_button:hover{
        background-color:#1ab188;
    }
    .bio_button:active{
        background-color:#949494;
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

            
                    <li>Years old: 
                    </br>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                     <input  name = "date_of_birth"/> 
                     <button type= "submit" name ="change_date" class = "action_button">Save</button >
                     </form> 
                     </li>

                    <li>Country: 
                    </br>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>"method="POST">
                     <input  name = "country"/> 
                     <button class = "action_button" type= "submit" name ="change_country">Save</button>
                     </form>
                     </li>

                    <li>City: 
                    </br>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>"method="POST">
                    <input  name = "city"/>
                    <button class = "action_button" type= "submit" name ="change_city">Save</button>
                    </form>
                    </li>

                    <li>Education: 
                    </br>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>"method="POST">
                    <input  name = "education"/>
                    <button class = "action_button" type= "submit" name ="change_education">Save</button>
                    </form>
                    </li>

                    <li>Email: 
                    </br>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>"method="POST">
                    <input name = "email"/>
                    <button class = "action_button" type= "submit" name ="change_email">Save</button>
                    </form>
                    </li>
                    
                    <li>Password: 
                    </br>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>"method="POST">
                    <input  name = "password" type ="password"/>
                    <button class = "action_button" type= "submit" name ="change_password">Save</button>
                    </form>
                    </li>
                    <li>Phone number: 
                    </br>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input  name = "number"/>
                    <button class = "action_button" type= "submit" name ="change_number">Save</button>
                    </form>
                    </li>
                </ul>

            </div>
            <div class = "separator"></div>
            <div class = "bio">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <textarea name = "bio" class = "bio_area" placeholder="Tell something about you.."></textarea>
                <button class = "bio_button" type = "submit" name = "change_bio">Save</button>
            </div>
    </div>
        </body>
        </html>
