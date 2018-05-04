<?php
require 'system_messages.php';
function c_connectDB(){
    $user_name = 'root';
    $user_password = '';
    $database_name = 'careContract';
    $host = 'localhost:2303';
    return mysqli_connect($host, $user_name, $user_password, $database_name);
}
function checkForNewContracts($login){
    $connection = c_connectDB();
    $query = "SELECT COUNT(*) from contracts where to_user = '$login' and status = 'send'";
    $row = mysqli_fetch_assoc(mysqli_query($connection, $query));
    mysqli_close($connection);
    return $row['COUNT(*)'];
}


function acceptContract($sender, $acceptor){
    $connection = c_connectDB();
    $query = "UPDATE contracts set status = 'accetpted' where from_user = '$sender' and 'user_to' = '$acceptor'";
    mysqli_query($connection, $query);
    mysqli_close($connection);

}

function getContracts($login){
    $connection = c_connectDB();
    $query = "SELECT * from contracts where to_user = '$login' or from_user = '$login'";
    return mysqli_query($connection, $query);
    mysqli_close($connection);
}

function checkContractsExist($login){
    $connection = c_connectDB();
    $query = "SELECT * from contracts where to_user = '$login' or  from_user = '$login'";
    return mysqli_num_rows(mysqli_query($connection, $query)) == 0;
    mysqli_close($connection);
}
function getContractInfo($reciver, $sender){
    $connection = c_connectDB();
    $query = "SELECT * from contracts where to_user = '$reciver' and from_user = '$sender'";
    return mysqli_fetch_assoc(mysqli_query($connection, $query));
    mysqli_close($connection);
}
function open($reciver, $sender){
    $connection = c_connectDB();
    $query = "UPDATE contracts set status = 'read' where to_user = '$reciver' and from_user = '$sender'";
    mysqli_query($connection, $query);
    mysqli_close($connection);

}

function closeContract($reciver, $sender){
    $connection = c_connectDB();
    $query = "DELETE from contracts  where to_user = '$reciver' and from_user = '$sender'";
    mysqli_query($connection, $query);
    $query = "SELECT * from stat where stat_id = '$reciver'";
    $row = mysqli_fetch_array(mysqli_query($connection, $query));
    $value = $row['contracts'];
    $value += 1;
    $query = "UPDATE stat set contracts = '$value' where stat_id = '$reciver'";
    mysqli_query($connection, $query);

    $query = "SELECT * from stat where stat_id = '$sender'";
    $row = mysqli_fetch_array(mysqli_query($connection, $query));
    $value = $row['contracts'];
    $value += 1;
    $query = "UPDATE stat set contracts = '$value' where stat_id = '$sender'";
    mysqli_query($connection, $query);
    mysqli_close($connection);

}

function accept($reciver, $sender){
    $connection = c_connectDB();
    $query = "UPDATE contracts set status = 'accept' where to_user = '$reciver' and from_user = '$sender'";
    mysqli_query($connection, $query);
    mysqli_close($connection);
}

function cancle($reciver, $sender){
    $connection = c_connectDB();
    $query = "DELETE from contracts  where to_user = '$reciver' and from_user = '$sender'";
    mysqli_query($connection, $query);
    mysqli_close($connection);

}
function done ($reciver, $sender){
    $connection = c_connectDB();
    $query = "UPDATE contracts set status = 'done' where to_user = '$reciver' and from_user = '$sender'";
    mysqli_query($connection, $query);
    mysqli_close($connection);
}

?>