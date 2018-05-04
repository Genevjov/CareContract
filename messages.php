<?php
require "functions.php";
require "contracts_functions.php";
session_start();
$login = $_SESSION['login'];
$resiver = $_SESSION['message_resiver'];


if (isset($_POST['open_chat'])){
    $connection = connectDB(); 
    $resiver = mysqli_real_escape_string($connection, $_POST['r_login']);
    readMessageInDialog($login, $resiver);
    mysqli_close($connection);

    session_start();
    $_SESSION['message_resiver'] = $resiver;
    header('Location: messages.php');

}


if (isset($_POST['send_message'])){
    $text = $_POST['message_text'];
    if(!empty($text) && !empty($resiver)){
        sendMessage($login,$resiver,$text);
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Messages</title>
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    
</head>
<style>

    .selected_dialog_user{
        position:absolute;
        margin-left:340px;
        margin-top:15px;
        font-size: "Roboto Condensed";
        font-size:20px;
        font-weight:bold;
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
    .no_messages{

    }
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
    
    li .current a {
        background-color: #1ab188;

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

    .dialogs {
        background: wheat;
        position: absolute;
        width: 400px;
        height: 639px;
        margin-top: -639px;
        margin-left: 250px;
    }

    .find_dialog {
        position: absolute;
        margin-top: 15px;
        margin-left: 20px;
        boder-color: transparent;
        border-radius: 30px;
        border-width: 0.1px;
        padding-left: 5px;
        outline: 0;
        width: 300px;
        height: 20px;
        background-color: #c1bdba;
    }

    .find_button {
        position: absolute;
        margin-left: 340px;
        margin-top: 15px;
        border-radius: 20px;
        border-color: transparent;
        outline: 0;
        background-color: #c1bdba;
    }

    .find_button:hover {
        background-color: #1ab188;
    }

    .find_button:active {
        background-color: #c1bdba;
    }

    .find_dialogs {
        position: absolute;
        background-color: #ffd954;
        width: 400px;
        height: 50px;
    }

    .dialog {
        position: absolute;
        margin-top: -639px;
        margin-left: 650px;
        width: 717px;
        height: 639px;
        background-color: snow;
    }

    .dialog_header {
        position: absolute;
        background-color: #ffd954;
        width: 718px;
        height: 50px;
    }

    .line {
        position: absolute;
        background-color: #949494;
        height: 639px;
        width: 1px;
    }

    .dialog_separator {
        position: absolute;
        background-color: #949494;
        height: 1px;
        width: 717px;
        margin-top: 500px;
    }

    .message_input {
        width: 400px;
        height: 100px;
        position: absolute;
        resize: none;
        margin-top: 20px;
        margin-left: 50px;
        outline: none;
    }

    .write_message_footer {
        position: absolute;
        width: 716.51px;
        height: 140px;
        background-color: #77abff;

    }

    .send_messge {
        position: absolute;
        outline: none;
        margin-top: 45px;
        margin-left: 520px;
        width: 150px;
        height: 60px;
        border-radius: 25px;
        border-color: transparent;
        background-color: #c1bdba;

    }

    .send_messge:hover {
        background-color: #1ab188;
    }

    .send_messge:active {
        background-color: #c1bdba;
    }
    .user_dialogs{
        margin-top:50px;
        position:absolute;
    }
    .user_dialogs li{
        
        display:block;
        padding-top:10px;
    }
    .user_dialogs li button{
        width:370px;
        margin-left: -25px;
        height:50px;
        outline:none;
        color:black;
        font-family:'Lato';
        border-width:0px;
    }
    .user_dialogs li button:hover{
        background-color: #1ab188;

    }
    .user_dialogs li input{
        width:0px;
        position: absolute;
        background: transparent;
        border-width:0px;
    }
    .no_messages{
        position:absolute;
        color:gray;
        margin-top:250px;
        margin-left:280px;
        font-family: "Roboto Condensed";
        font-size: 25px;
    }
    .no_dialog_selected{
        font-family: "Roboto Condensed";
        margin-top:18px;
        margin-left:300px;
        position:absolute;
    }
     li{
        list-style:none          
     }
     .messages_list{
         position:absolute;
        margin-top:-580px;
        margin-left:650px;
    }
    .messages_list li{
        padding-top:15px;
        width:200px;
        font-family:'Lato';
        font-size:18px;
        display: block;
    }
    .time{
        position:absolute;
        margin-left:500px;
        width:145px;
        font-size:15px;
        margin-top:-19px;
    }
    .message_text {
        position:absolute;
    }
    .word_chats{
        position:absolute;
        font-family:"Late";
        font-size:20px;
        margin-top:15px;
        margin-left:175px;
    }

</style>
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
    <div class="dialogs">
        <div class=" find_dialogs">
            <div class = "word_chats">Chats</div>
        </div>
        <div class="dilogs_list">
            <ul class = "user_dialogs">
            <?php
                $mysql_result = getChatsForUser($login);
                $r_login = null;
                while( $row = $mysql_result->fetch_assoc()){
                    echo '<li>';
                    echo '<form action = "'.$_SERVER['PHP_SELF'].'" method="POST">';
                    if($row['user_1']=== $login){
                        $r_login = $row['user_2'];
                    } else {
                        $r_login = $row['user_1'];
                    }
                    echo '<input readonly  name = "r_login" value = "'.$r_login.'"/>';
                    echo '<button type = "submit" name = "open_chat">';
                    $chat_name = getUserNameByLogin($r_login);
                    echo $chat_name['first_name'];
                    echo ' ';
                    echo $chat_name['second_name'];
                    echo '</button>';
                    echo '</form>';
                    echo '</li>';
                } 

            ?>
            </ul>
        </div>
    </div>
    <div class="dialog">

        <div class="dialog_header">
        
        <?php
        if(empty($resiver)){
            echo '<div class = "no_messages">No messages here..</div>';
            echo '<div class = "no_dialog_selected">Nothing selected..</div>';
        } else{
            $dialog_name = getUserNameByLogin($resiver);
        echo '<div class = "selected_dialog_user">'.$dialog_name['first_name'].' '.$dialog_name['second_name'].'</div>';
        }
        ?>
        </div>
        
        <div class="line"></div>
             
        
        <div class="dialog_separator">
            <div class="write_message_footer">
            <form action = "<?php $_SERVER['PHP_SELF']?>" method = "POST">
            <textarea class="message_input" name="message_text"
                      placeholder="Enter your message here."></textarea>
                <button type="submit" class="send_messge" name="send_message">Send</button>
            <form>
            </div>
        </div>
    
    
        </div>  
        <div class = "messages">
            <ul class = "messages_list">
            <?php
            if(!empty($resiver)){
                $mysql_result = getMessagesFromChat($login, $resiver);
                while($row = $mysql_result->fetch_assoc()){
                    echo '<li>'; 
                    $name = getUserNameByLogin($row['from_user']);
                    echo $name['first_name'].$name['second_name'].':';
                    echo '<div class = "time">'.$row['time'].'</div>';
                    echo '</br>';
                    echo $row['text'];
                    echo '</li>';

                }
            }
        ?>
        </ul>
        </div>  
</body>
</html>