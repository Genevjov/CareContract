<?php
require 'functions.php';
require 'contracts_functions.php';

session_start();
$reciver = $_SESSION['reciver'];
$sender = $_SESSION['sender'];
$my_login = $_SESSION['my_login'];

$new_contracts = checkForNewContracts($my_login);
$s_name = getUserNameByLogin($sender);
$s_first_name = $s_name['first_name'];
$s_second_name = $s_name['second_name'];
$m_name = getUserNameByLogin($reciver);
$m_first_name = $m_name['first_name'];
$m_second_name = $m_name['second_name'];
$row = getContractInfo($reciver,$sender);
if(isset($_POST['confirm'])){
    $sender =  $_POST['sender'];
    $reciver = $_POST['reciver'];
    closeContract($reciver,$sender);
    session_start();
    $_SESSION['login'] = $my_login;

    header('Location:  contracts.php');
    exit();
}
if(isset($_POST['accept'])){
    accept($my_login, $sender);
    if(isChatExists('system',$sender)){
        createChat('system',$sender);
        sendMessage('system', $sender, 'Contract which you sent to user '.$reciver.' was accepted.');
    }else{
        sendMessage('system', $sender, 'Contract which you sent to user '.$reciver.' was accepted.');
    }

    session_start();
    $_SESSION['login'] = $my_login;
    header('Location: contracts.php');
    exit();
}

if(isset($_POST['abolish'])){
    cancle($my_login, $sender);
    if(isChatExists('system',$sender)){
        createChat('system',$sender);
        sendMessage('system', $sender, 'Contract which you sent to user '.$reciver.' was canceled.');
    }else{
        sendMessage('system', $sender, 'Contract which you sent to user '.$reciver.' was canceled.');
    }
    session_start();
    $_SESSION['login'] = $my_login;
    header('Location: contracts.php');
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Contract</title>
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <script src="main.js"></script>
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
    .contract{
        position:absolute;
        margin-top:50px;
        margin-left:300px;
        font-size:25px;
        font-family:"Roboto Condensed";
    }
    .m_name{
        margin-top:20px;
    }
    .desc{
        margin-top:20px;
        width:800px;
    }
    .type{
        margin-top:20px;
    }
    .opt_1{
        margin-top:250px;
    }
    .buttons{
        position:absolute;
        margin-left:650px;
        margin-top:-50px;

    }
    .accept{
        width:150px;
        height:55px;
        border-width:0px;
        position:absolute;
        background-color: #1ab188;
        outline:none;
        font-family:"Lato";
    }
  
    .abolish{
        background:#f45f42;
        outline:none;
        width:150px;
        height:55px;
        border-width:0px;
        position:absolute;
        margin-left:200px;
        font-family:"Lato";

    }
    .time{
        position:absolute;
        margin-left:650px;
        width:400px;
        margin-top:-30px;
        
    }
 
</style>
<body>
<div class="button_bar_panel">
    <div class="photo"></div>
    <div class="name"><?php echo $my_login?></div>
    <div class="button_bar">
    <?php
            $num = check_for_messages($my_login);
            if($num > 0 && $num < 10){
                echo "<div class='indicator'>$num</div>";
            } elseif($num >= 10){
               echo "<div class='indicator'>!</div>";
            }
            
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
    <div class = "contract">
        <div class = "s_name">From: <?php echo $s_first_name.' '.$s_second_name?></div>
        <div class = "time">From: <?php echo $row['date_from']?> Till:  <?php echo $row['date_till']?></div>
        <div class = "m_name">To: <?php echo $m_first_name.' '.$m_second_name?></div>
        <div class = "type">Type:  <?php echo $row['type']?></div>

        
        <div class = "desc">Description:</br></br> <?php echo $row['description']?></div>
        <div class = "opt_1">Addition 1: <?php 
            if (empty(row['optional_1'])){
                echo 'Not indicated';
            } else{
                echo row['optional_1'];
            }
        ?>
        <div class = "opt_2">Addition 2: <?php 
            if (empty(row['optional_2'])){
                echo 'Not indicated';
            } else{
                echo row['optional_2'];
            }
        ?>
        <?php 
            if(!$my_login === $sender){
          
            echo '<form action = "'.$_SERVER['SELF'].'" method = "POST">
        <div class = "buttons">
        <form action = "<?php echo'. $_SERVER['SELF'].' method = "POST">
        <button class = "accept" name = "accept" type = "submit">Accept</button>
        <button class = "abolish" name = "abolish" type = "submit">Abolish</button>
        </form>';
        }
        ?>
            </div>

    
    
            
    </div>
</body>
</html>