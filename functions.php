<?php

function connectDB(){
    $user_name = 'root';
    $user_password = '';
    $database_name = 'careContract';
    $host = 'localhost:2303';
    return mysqli_connect($host, $user_name, $user_password, $database_name);
}

function getUserById($id){
    $database = connectDB();
    $query = "Select * from users WHERE id = '$id'";
    return mysqli_fetch_array(mysqli_query($database, $query));
    mysqli_close($database);

}

function getIdByLogin($login){
    $database = connectDB();
    $query = "Select id from users WHERE login = '$login'";
    $result = mysqli_query($database, $query);
    mysqli_close($database);
    return mysqli_fetch_array($result);

}

function getUserByName($name){
    $database = connectDB();
    $query = "Select * from users WHERE first_name or second_name = '$name'";
    $result = mysqli_query($database, $query);
    mysqli_close($database);
    return mysqli_fetch_array($result);
}

function getUserNameByLogin($login){
    $connection = connectDB();
    $query = "SELECT first_name, second_name from users where login = '$login'";
    $row = mysqli_fetch_assoc(mysqli_query($connection, $query));
    return $row;
    mysqli_close($connection);

}

function registrate($first_name, $second_name, $login, $email, $password){
    $connection = connectDB();
    $query = "INSERT INTO users VALUES ('$first_name', '$second_name','$login','$email',' $password')";
    $stat_query = "INSERT into stat values('$login',0,0)";
    mysqli_query($connection,$query);
    mysqli_query($connection, $stat_query);
    mysqli_close($connection);
}

function login($login, $password){
    $connection = connectDB();
    $query = "SELECT * from users where login = '$login' and password = '$password'";
    return (mysqli_num_rows(mysqli_query($connection, $query)) != 0); 
    mysqli_close($connection);
       
}

function getStat($login){
    $connection = connectDB();
    $query = "SELECT * from stat where stat_id = '$login'";
    return mysqli_fetch_array(mysqli_query($connection, $query));
    mysql_close($connection);
}

function getInfo($login){
    $connection = connectDB();
    $query = "SELECT * from user_info where login = '$login'";
    return mysqli_fetch_array(mysqli_query($connection,$query));
    mysql_close($connection);
}

function getEmailByLogin($login){
    $connection = connectDB();
    $query = "SELECT email from users where login = '$login'";
    return mysqli_fetch_array(mysqli_query($connection,$query));
    mysql_close($connection);
}

function checkInfoForLoginExists($login){
    $connection = connectDB();
    $query = "SELECT * from user_info where login = '$login'";
    return mysqli_num_rows(mysqli_query($connection, $query)) == 0;
    mysql_close($connection);
}

function updateDateOfBirthByLogin($login, $years){
    $connection = connectDB();
    if (checkInfoForLoginExists($login)){
        $query = "INSERT into user_info (login, old) values ('$login','$years)";
        mysqli_query($connection, $query);
        mysqli_close($connection);

    } else {
        $query = "UPDATE user_info set old = '$years' 
        where login = '$login'";
        mysqli_query($connection, $query);
        mysqli_close($connection);

    }        
}

function updatePhoneNumberByLogin($login, $newPhoneNumber){
    $connection = connectDB();
    if (checkInfoForLoginExists($login)){
        $query = "INSERT into user_info (login, phone) values ('$login','$newPhoneNumber)";
        mysqli_query($connection, $query);
        mysqli_close($connection);

    } else {
        $query = "UPDATE user_info set phone = '$newPhoneNumber' 
        where login = '$login'";
        mysqli_query($connection, $query);
        mysqli_close($connection);

    }        
}

function updateEmailByLogin($login, $newEmail){
    $connection = connectDB();
    $query = "UPDATE users SET email = '$newEmail' where login = '$login'";
    mysqli_query($connection, $query);
    mysqli_close($connection);

}

function updatePasswordByLogin($login, $newPassword){
    $connection = connectDB();
    $query = "UPDATE users SET password = '$newPassword' where login = '$login'";
    mysqli_query($connection, $query);
    mysqli_close($connection);


}

function updateEducationByLogin($login, $education){
    $connection = connectDB();
    if (checkInfoForLoginExists($login)){
        $query = "INSERT into user_info (login, education) values ('$login','$education')";
        mysqli_query($connection, $query);
        mysqli_close($connection);

    } else {
        $query = "UPDATE user_info set education = '$education' 
        where login = '$login'";
        mysqli_query($connection, $query);
        mysqli_close($connection);

    }        
}

function updateCityByLogin($login, $city){
    $connection = connectDB();
    if (checkInfoForLoginExists($login)){
        $query = "INSERT into user_info (login, city) values ('$login','$city)";
        mysqli_query($connection, $query);
        echo "Done";
        mysqli_close($connection);

    } else {
        $query = "UPDATE user_info set city = '$city' 
        where login = '$login'";
        mysqli_query($connection, $query);
        mysqli_close($connection);

    }        
}

function updateCountryByLogin($login, $country){
    $connection = connectDB();
    if (checkInfoForLoginExists($login)){
        $query = "INSERT into user_info (login, country) values ('$login','$country)";
        mysqli_query($connection, $query);
        mysqli_close($connection);

    } else {
        $query = "UPDATE user_info set country = '$country' 
        where login = '$login'";
        mysqli_query($connection, $query);
        mysqli_close($connection);

    }        
}

function udpdateBio($login, $newBio){
    $connection = connectDB();
    if (checkInfoForLoginExists($login)){
        $query = "INSERT into user_info (login, bio) values ('$login','$newBio)";
        mysqli_query($connection, $query);
        echo "Done";
        mysqli_close($connection);

    } else {
        $query = "UPDATE user_info set bio = '$newBio' 
        where login = '$login'";
        mysqli_query($connection, $query);
        echo "Done";
        mysqli_close($connection);

    }        
}

function check_for_messages($login){
    $connection = connectDB();
    $query = "SELECT COUNT(*) from messages where to_user = '$login' and status = 'send'";
    $row = mysqli_fetch_assoc(mysqli_query($connection, $query));
    return $row['COUNT(*)'];    
    mysql_close($connection);
}

function checkNewMesagesForDialog($user1, $user2){
    $connection = connectDB();
    $id_1 = $user1.$user2;
    $id_2 = $user2.$user1;
    $query = "SELECT COUNT(*) FROM messages where chat_key = '$id_1' or chat_key = '$id_2' and status = 'send'";
    $row = mysqli_fetch_assoc(mysqli_query($connection, $query));
    return $row['COUNT(*)'];
    mysql_close($connection);
}

function addStar($login,$user_login){
    $connection = connectDB();
    $query = "SELECT * from stat where stat_id = '$user_login'";
    $row = mysqli_fetch_array(mysqli_query($connection, $query));
    $value = $row['stars'];
    $value += 1;
    $query = "INSERT into stars_edded values('$login', '$user_login')";
    mysqli_query($connection, $query);
    $query = "UPDATE stat set stars = '$value' where stat_id = '$user_login'";
    mysqli_query($connection, $query);
    mysqli_close($connection);
}

function checkAddedStar($login,$user_login){
    $connection = connectDB();
    $query = "SELECT * from stars_edded where edded_from = '$login' and edded_to = '$user_login'";
    return mysqli_num_rows(mysqli_query($connection, $query)) == 0;
    mysqli_close($connection);
}

function unblock($login, $user_login){
    $connection = connectDB();
    $query = "DELETE from block where blocker = '$login' and blocked = '$user_login'";
    mysqli_query($connection, $query);
    mysqli_close($connection);
}

function isUserBlockedByMe($login, $user_login){
    $connection = connectDB();
    $query = "SELECT * from block where blocker = '$login' and blocked = '$user_login'";
    return mysqli_num_rows(mysqli_query($connection, $query)) == 0;
    mysqli_close($connection);
}   
function isUserBlocked($user_login, $login){
    $connection = connectDB();
    $query = "SELECT * from block where blocker = '$user_login' and blocked = '$login'";
    return mysqli_num_rows(mysqli_query($connection, $query)) == 0;
    mysqli_close($connection);
}

function blockUser($user_login, $login){
    $connection = connectDB();
    $query = "INSERT into block values('$user_login', '$login')";
    mysqli_query($connection, $query);
    mysqli_close($connection);
}


function readMessageInDialog($user1, $user2){
    $connection = connectDB();
    $id_1 = $user1.$user2;
    $id_2 = $user2.$user1;
    $query = "UPDATE messages set status = 'read' where to_user = '$user1' and from_user = '$user2'";
    mysqli_query($connection, $query);
    mysqli_close($connection);

}

function createChat($user1, $user2){
    $connection = connectDB();
    $id = $user1.$user2;
    $query = "INSERT into chats values ('$user1', '$user2', '$id')";
    mysqli_query($connection, $query);
    mysqli_close($connection);
}

function getMessagesFromChat($user1, $user2){
    $connection = connectDB();
    $query = "SELECT * from messages where from_user = '$user1' 
    and to_user = '$user2' or from_user = '$user2' and to_user = '$user1' order by  id desc limit 7";
    return mysqli_query($connection, $query);
    mysqli_close($connection);
}

function getChatsForUser($login){
    $connection = connectDB();
    $query = "SELECT * From chats where user_1 = '$login' or user_2 = '$login'";
    $row = (mysqli_query($connection, $query));
    return $row;
    mysqli_close($connection);
}

function isChatExists($user1, $user2){
    $connection = connectDB();
    $query = "SELECT * from chats where user_1 = '$user1' and user_2 = '$user2' or user_1= '$user2'
    and user_2 = '$user1'";
    return mysqli_num_rows(mysqli_query($connection, $query)) == 0;
    mysqli_close($connection);
}
function sendMessage($sender, $reciver,$text){
    $connection = connectDB();
    $query = "SELECT chat_key from chats where user_1 = '$sender' and user_2 = '$reciver' or
    user_2 = '$sender' and user_2 = '$reciver'";
    $row = mysqli_fetch_assoc(mysqli_query($connection, $query));
    $chat_key = $row['chat_key'];
    $now = date("Y-m-d H:i:s");
    $query = "INSERT into messages (from_user, to_user, text, chat_key, time, status) values('$sender', '$reciver','$text','$chat_key','$now','send')";
    mysqli_query($connection, $query);
    mysqli_close($connection);
}

function sendContract($from, $to, $type, $date_from, $date_till,
 $description, $opt1, $opt2){
     $connection = connectDB();
    if(empty($opt1) && empty($opt2)){
        $query = "INSERT into contracts(from_user, to_user, type, date_from,
        date_till, description, status) VALUES ('$from', '$to', '$type', '$date_from', '$date_till',
        '$description', 'send')";
        mysqli_query($connection, $query);
        mysqli_close($connection);
    }
    if(!empty($opt1) && empty($opt2)){
        $query = "INSERT into contracts(from_user, to_user, type, date_from,
        date_till, description, optional_1, status) VALUES ('$from', '$to', '$type', '$date_from', '$date_till',
        '$description', '$opt1','send')";
        mysqli_query($connection, $query);
        mysqli_close($connection);
    } 
    if(!empty($opt1) && !empty($opt2)){
        $query = "INSERT into contracts(from_user, to_user, type, date_from,
        date_till, description, optional_1, optional_2 ,status) VALUES ('$from', '$to', '$type', '$date_from', '$date_till',
        '$description', '$opt', '$opt2','send')";
        mysqli_query($connection, $query);
        mysqli_close($connection);

    }
}
?>