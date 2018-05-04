<?php
require 'functions.php';
require 'contracts_functions.php';

session_start();
$my_login = $_SESSION['login'];
$new_contracts = checkForNewContracts($my_login);

if(isset($_POST['open'])){
    $sender = $_POST['sender'];
    $reciver = $_POST['reciver'];
    open($reciver, $sender);
    session_start();
    $_SESSION['reciver'] = $reciver;
    $_SESSION['sender'] = $sender;
    $_SESSION['my_login'] = $my_login;
    header('Location:  contract.php');
    exit();
}
    if(isset($_POST['accept'])){
        $sender =  $_POST['sender'];
        $reciver = $_POST['reciver'];
        accept($reciver, $sender);
        if(isChatExists('system',$sender)){
            createChat('system',$sender);
            sendMessage('system', $sender, 'Contract which you sent to user '.$my_login.' was accepted.');
        }else{
            sendMessage('system', $sender, 'Contract which you sent to user '.$my_login.' was accepted.');
        }
        session_start();
        $_SESSION['login'] = $my_login;

        header('Location:  contracts.php');
        exit();
}

if(isset($_POST['confirm'])){
    $sender =  $_POST['sender'];
    $reciver = $_POST['reciver'];
    closeContract($reciver,$sender);
    session_start();
    $_SESSION['login'] = $my_login;

    header('Location:  contracts.php');
    exit();
}

if(isset($_POST['done'])){
    $sender =  $_POST['sender'];
    $reciver = $_POST['reciver'];
    done($reciver, $sender);
    if(isChatExists('system',$sender)){
        createChat('system',$sender);
        sendMessage('system', $sender, 'Contract which you sent to user '.$my_login.' is ready to check.');
    }else{
        sendMessage('system', $sender, 'Contract which you sent to user '.$my_login.' is ready to check.');
    }
    session_start();
    $_SESSION['login'] = $my_login;

    header('Location:  contracts.php');
    exit();
}

if(isset($_POST['abolish'])){
    $sender =  $_POST['sender'];
    $reciver = $_POST['reciver'];
    cancle($reciver, $sender);
    if(isChatExists('system',$sender)){
        createChat('system',$sender);
        sendMessage('system', $sender, 'Contract which you sent to user '.$my_login.' was canceled.');
    }else{
        sendMessage('system', $sender, 'Contract which you sent to user '.$my_login.' was canceled.');
    }
    session_start();
    $_SESSION['login'] = $my_login;
    header('Location:  contracts.php');
    exit();
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">



     <title>My contracts</title>
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

    .no_contracts{
        position:absolute;
        margin-top:280px;
        margin-left:600px;
        font-family: "Roboto Condensed";
        font-size:25px;
        color:gray;
    }
    li{
        list-style:none;
    }
    .contract{
        position:absolute;
        margin-top:50px;
        margin-left:250px;
        font-family:"lato";
        
    }
    .contract li{
        padding-left:50px;
        width: 180px;
        height:220px;
        background:wheat;
        position:absolute;
        display:inline;
    }
    .contract li input{
        background:transparent;
        border-width:0px;
        text-align:center;
        position:absolute;
        margin-top:2px;
        font-size:15px;
    }
    .contract li button{
        margin-top:25px;
        display:block;
        margin-left:25px;
        width:80px;
        height:25px;
    }
    .open {
        background:#e2f442;
        outline:none;
        border-width:0px;
    }
   
    .accept{
        background-color: #1ab188;
        outline:none;
        border-width:0px;
    }
  
    .abolish{
        background:#f45f42;
        outline:none;
        border-width:0px;
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

    <div class = "contracts">
            
            <?php
            $noExistance = checkContractsExist($my_login);
            if($noExistance){
                echo '<div class ="no_contracts">Now you haven\'t got any contracts..</div>';
           }else{
                echo '<ul class = "contract">';
                $mysqlResult = getContracts($my_login);
                while($row = $mysqlResult->fetch_assoc()){
                    if($row['from_user'] == $my_login){
                        
                        echo '<li>';
                        echo '<form action ='.$_SERVER['PHP_SELF'].' method = "POST">';
                        echo 'From:';
                        echo '<input readonly name = "sender" value ='.$row['from_user'].'></input>';
                        echo '</br>';
                        echo 'To:';
                        echo '<input readonly name = "reciver"  value = '.$row['to_user'].'></input>';
                        echo '</br>';
                        echo '<button class = "open" name = "open" type = "submit">Open</button>';
                        
                        echo '<button class = "accept" name = "confirm" type = "submit">Confirm</button>';
                        
                        echo '<button class = "abolish" name = "abolish" type = "submit">Abolish</button>';
                        echo '</form>';
                        echo '</li>';

                    }else{
                    echo '<li>';
                    echo '<form action ='.$_SERVER['PHP_SELF'].' method = "POST">';
                    echo 'From:';
                    echo '<input readonly name = "sender" value ='.$row['from_user'].'></input>';
                    echo '</br>';
                    echo 'To:';
                    echo '<input readonly name = "reciver"  value = '.$row['to_user'].'></input>';
                    echo '</br>';
                    if ($row['status'] === 'done'){
                        echo '</br>Waiting for sender';
                    } else{
                    echo '<button class = "open" name = "open" type = "submit">Open</button>';
                    
                    if($row['status'] === 'accept'){
                        echo '<button class = "accept" name = "done" type = "submit">Done</button>';

                    }else{
                    echo '<button class = "accept" name = "accept" type = "submit">Accept</button>';
                    }
                    echo '<button class = "abolish" name = "abolish" type = "submit">Abolish</button>';
                    echo '</form>';
                    echo '</li>';
               }
                echo '</ul>';
            }

            }
        }
            ?>
    </div>
</body>
</html>