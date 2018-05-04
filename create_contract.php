<?php
require "functions.php";
require "contracts_functions.php";

session_start();
$my_login = $_SESSION['my_login'];
$user_login = $_SESSION['user_login'];

if (isset($_POST['offer'])){
    $date_from = $_POST['date_from'];
    $date_till = $_POST['date_till'];
    $select_type = $_POST['select_type'];
    $text = $_POST['text'];
    $opt1 = $_POST['opt_1'];
    $opt2 = $_POST['opt_2'];
    if(empty($date_from) || empty($date_till) || empty($select_type) || empty($text)){
        echo '<div class = "error_message">Requires fields can\'t be empty</div>';
    } else{
        sendContract($my_login, $user_login, $select_type, $date_from, $date_till,
        $text, $opt1,$opt2);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Create contract</title>
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">

</head>
<style>
  .button_bar {
        margin-top: 166px;
        margin-left: 20px;
        text-decoration: none;
    }
    html {
        background-color: #c1bdba;
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
    .from{
        position: absolute;
        margin-top:50px;
        margin-left:250px;
        height:30px;

    }
    .till{
        position: absolute;
        margin-top:50px;
        margin-left:50px;
        height:30px;

    }
    .select_type{
        position:absolute;
        margin-top:50px;
        width:200px;
        height:30px;
    }
   
    .date_bg{
        position:absolute;
        background-color: #655050;
        width:450px;
        height:150px;
        margin-top:50px;
        margin-left:850px;
    }
    .type_bg{
        position:absolute;
        background-color: #655050;
        width:300px;
        height:150px;
        margin-top:50px;
        margin-left:350px;
    }
    .type_bg span{
        position:absolute;
        color:white;
        font-family:"Roboto Condensed";
        margin-left:140px;
        margin-top:10px;

    }
    .select_type{
      position:absolute;
        margin-left:50px;
    }
    .desc_bg{
        position:absolute;
        background-color: #655050;
        width:500px;
        height:329px;
        margin-top:250px;
        margin-left:350px;
    }
    .desc_bg span{
        position:absolute;
        color:white;
        font-family:"Roboto Condensed";
        margin-left:200px;
        margin-top:10px;

    }
    .desciption{
        width:400px;
        height:229px;
        margin-top:50px;
        margin-left:50px;
        resize:none;
    }
    .opt_bg{
        position:absolute;
        background-color: #655050;
        width:405px;
        height:185px;
        margin-top:250px;
        margin-left:900px;
    }
    .opt_bg span{
        position:absolute;
        color:white;
        font-family:"Roboto Condensed";
        margin-left:160px;
        margin-top:10px;

    }
    .date_bg span{
        position:absolute;
        color:white;
        font-family:"Roboto Condensed";
        margin-left:190px;
        margin-top:10px;

    }
    .option_1{
        margin-top:50px;
        position:absolute;
        margin-left:50px;
        height:30px;
        width:300px;

    }
    .option{
        position:absolute;
        margin-top:100px;
        margin-left:50px;
        height:30px;
        width:300px;
    }
    .send{
        width:120px;
        height:30px;
        margin-top:50px;
        margin-left:50px;
    }
    .button_gb span{
        position:absolute;
        color:white;
        font-family:"Roboto Condensed";
        margin-left:90px;
        margin-top:10px;
    }
    .button_gb{
        position:absolute;
        margin-top:485px;
        margin-left:900px;
        width:220px;
        height:130px;
        background-color: #655050;
    }

</style>
<body>
<div class="button_bar_panel">
    <div class="photo"></div>
    <div class="name"><?php echo $my_login ?></div>
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
    </div>
    

    <form action ="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class = "date_bg">
    <span>Lifetime</span> 
    <input id="date" name = "date_till" class = "from" type="date">
    <input id="date" name = "date_from" class = "till" type="date">
    </div>
    <div class = "type_bg">
    <span>Type</span>
    <select class = "select_type" name = "select_type" >
    
    <option selected disabled>Chose the type of contract</option>
    <option >Real estate</option>
    <option >Finance</option>
    <option >Sales</option>
    <option >Exchange</option>
    <option>Rent</option>
    <option>Employment</option>    
    </select>
    </div>
    <div class = "desc_bg">
    <span>Description</span>
    <textarea class = "desciption" name = "text" placeholder= "Enter the contract description here.."></textarea>
    </div> 
    <div class = "opt_bg">
    <span>Addition</span> 
    <input type = "text" name = "opt_1" placeholder = "Optional 1" class = "option_1"/>
    <input type = "text" name = "opt_2" placeholder = "Optional 1" class = "option"/>
    </div>
    <div class= "button_gb">
    <span>Ready?</span>
    <button type="submit" name = "offer" class = "send">Send</button>
    </div>
    </form>

</body>
</html>