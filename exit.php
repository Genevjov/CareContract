<?php
setcookie('login', null, time() -100);
setcookie('password', null, time() -100);
header('Location: index.php');
?>