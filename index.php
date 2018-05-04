<?php
require "functions.php";

if (isset ($_COOKIE['login']) and isset ($_COOKIE['password'])) {
    header('Location: my_profile.php');
}
$db_user = 'root';
$db_password = '';
$databaseName = 'careContract';
$db_host = 'localhost';
$DATABASE = new mysqli($db_host, $db_user, $db_password, $databaseName);
if (isset($_POST['reg'])) {
    $user_first_name = mysqli_real_escape_string($DATABASE, trim($_POST['first_name']));
    $user_second_name = mysqli_real_escape_string($DATABASE, trim($_POST['last_name']));
    $user_login = mysqli_real_escape_string($DATABASE, trim($_POST['login']));
    $user_password = mysqli_real_escape_string($DATABASE, $_POST['password']);
    $user_email = mysqli_real_escape_string($DATABASE, trim($_POST['email']));

    $query = "SELECT * FROM users WHERE login = '$user_login'";
    $reg_res = mysqli_query($DATABASE, $query);
    if (mysqli_num_rows($reg_res) == 0) {
       registrate($user_first_name, $user_second_name, $user_login, $user_email, $user_password);
        reg_result(true);
    } else {
        reg_result(false);
    }

}

if (isset($_POST['log_in'])) {
    $user_login = mysqli_real_escape_string($DATABASE, $_POST['login']);
    $user_password = mysqli_real_escape_string($DATABASE, $_POST['password']);
    $query = "SELECT * FROM users WHERE login = '$user_login' AND password = '$user_password'";
    if(login($user_login,$user_password)){
    setcookie('login', $user_login, time() + 3600);
    setcookie('password', $user_password, time() + 3600);
    header("Location: my_profile.php");
    mysqli_close($DATABASE);
    session_start();
    $_SESSION['login'] = $user_login;
    exit;
    } else {
        login_error();
    }

}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">

    <script src="mainPage/js/index.js"></script>

</head>

<body>


<style>
    .reg_done {
        position: absolute;
        margin-left: 590px;
        margin-top: 10px;
        background-color: #1ab188;
    }

    .reg_error {
        position: absolute;
        margin-left: 590px;
        margin-top: 10px;
        background-color: red;
    }

    *, *:before, *:after {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    html {
        overflow-y: scroll;
    }

    body {
        background: #c1bdba;
        font-family: 'Titillium Web', sans-serif;
    }

    a {
        text-decoration: none;
        color: #1ab188;
        -webkit-transition: .5s ease;
        transition: .5s ease;
    }

    a:hover {
        color: #179b77;
    }

    .form {
        background: rgba(19, 35, 47, 0.9);
        padding: 40px;
        max-width: 600px;
        margin: 40px auto;
        border-radius: 4px;
        -webkit-box-shadow: 0 4px 10px 4px rgba(19, 35, 47, 0.3);
        box-shadow: 0 4px 10px 4px rgba(19, 35, 47, 0.3);
    }

    .tab-group {
        list-style: none;
        padding: 0;
        margin: 0 0 40px 0;
    }

    .tab-group:after {
        content: "";
        display: table;
        clear: both;
    }

    .tab-group li a {
        display: block;
        text-decoration: none;
        padding: 15px;
        background: rgba(160, 179, 176, 0.25);
        color: #a0b3b0;
        font-size: 20px;
        float: left;
        width: 50%;
        text-align: center;
        cursor: pointer;
        -webkit-transition: .5s ease;
        transition: .5s ease;
    }

    .tab-group li a:hover {
        background: #179b77;
        color: #ffffff;
    }

    .tab-group .active a {
        background: #1ab188;
        color: #ffffff;
    }

    .tab-content > div:last-child {
        display: none;
    }

    h1 {
        text-align: center;
        color: #ffffff;
        font-weight: 300;
        margin: 0 0 40px;
    }

    label {
        position: absolute;
        -webkit-transform: translateY(6px);
        transform: translateY(6px);
        left: 13px;
        color: rgba(255, 255, 255, 0.5);
        -webkit-transition: all 0.25s ease;
        transition: all 0.25s ease;
        -webkit-backface-visibility: hidden;
        pointer-events: none;
        font-size: 22px;
    }

    label .req {
        margin: 2px;
        color: #1ab188;
    }

    label.active {
        -webkit-transform: translateY(50px);
        transform: translateY(50px);
        left: 2px;
        font-size: 14px;
    }

    label.active .req {
        opacity: 0;
    }

    input, textarea {
        font-size: 22px;
        display: block;
        width: 100%;
        padding: 5px 10px;
        background: none;
        background-image: none;
        border: 1px solid #a0b3b0;
        color: #ffffff;
        border-radius: 0;
        -webkit-transition: border-color .25s ease, -webkit-box-shadow .25s ease;
        transition: border-color .25s ease, -webkit-box-shadow .25s ease;
        transition: border-color .25s ease, box-shadow .25s ease;
        transition: border-color .25s ease, box-shadow .25s ease, -webkit-box-shadow .25s ease;
    }

    input:focus, textarea:focus {
        outline: 0;
        border-color: #1ab188;
    }

    textarea {
        border: 2px solid #a0b3b0;
        resize: vertical;
    }

    .field-wrap {
        position: relative;
        margin-bottom: 40px;
    }

    .top-row:after {
        content: "";
        display: table;
        clear: both;
    }

    .top-row > div {
        float: left;
        width: 48%;
        margin-right: 4%;
    }

    .top-row > div:last-child {
        margin: 0;
    }

    .button {
        border: 0;
        outline: none;
        border-radius: 0;
        padding: 15px 0;
        font-size: 2rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .1em;
        background: #1ab188;
        color: #ffffff;
        -webkit-transition: all 0.5s ease;
        transition: all 0.5s ease;
        -webkit-appearance: none;
    }

    .button:hover, .button:focus {
        background: #179b77;
    }

    .button-block {
        display: block;
        width: 100%;
    }


</style>

<div class="form">

    <ul class="tab-group">
        <li class="tab active"><a href="#signup">Sign Up</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
    </ul>

    <?php

    function reg_result($result)
    {
        if ($result == true) {
            echo '<div class="reg_done">Done! Now you can Log in</div>';
        } else
            echo '<div class="reg_error">USER ALREADY EXISTS!</div>';

    }

    ?>
    <div class="tab-content">
        <div id="signup">
            <h1>Sign Up </h1>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                <div class="top-row">
                    <div class="field-wrap">
                        <label>
                            First Name<span class="req">*</span>
                        </label>
                        <input type="text" required autocomplete="off" name="first_name"/>
                    </div>

                    <div class="field-wrap">
                        <label>
                            Last Name<span class="req">*</span>
                        </label>
                        <input type="text" required autocomplete="off" name="last_name"/>
                    </div>
                </div>
                <div class="field-wrap">
                    <label>
                        Login<span class="req">*</span>
                    </label>
                    <input type="text" required autocomplete="off" name="login"/>
                </div>

                <div class="field-wrap">
                    <label>
                        Email Address<span class="req">*</span>
                    </label>
                    <input type="email" required autocomplete="off" name="email"/>
                </div>

                <div class="field-wrap">
                    <label>
                        Set A Password<span class="req">*</span>
                    </label>
                    <input type="password" required autocomplete="off" name="password"/>
                </div>

                <button type="submit" class="button button-block" name="reg">Get Started</button>

            </form>

        </div>
        <?php
        function login_error()
        {
            echo '<div class="reg_error">Invalid login or password!</div>';
        }

        ?>
        <div id="login">
            <h1>Welcome Back!</h1>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                <div class="field-wrap">
                    <label>
                        Login<span class="req">*</span>
                    </label>
                    <input type="text" required autocomplete="off" name="login"/>
                </div>

                <div class="field-wrap">
                    <label>
                        Password<span class="req">*</span>
                    </label>
                    <input type="password" value = "  " required autocomplete="off" name="password"/>
                </div>

                <button class="button button-block" name="log_in">Log In</button>

            </form>

        </div>

    </div><!-- tab-content -->

</div> <!-- /form -->
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>


<script>$('.form').find('input, textarea').on('keyup blur focus', function (e) {

        var $this = $(this),
            label = $this.prev('label');

        if (e.type === 'keyup') {
            if ($this.val() === '') {
                label.removeClass('active highlight');
            } else {
                label.addClass('active highlight');
            }
        } else if (e.type === 'blur') {
            if ($this.val() === '') {
                label.removeClass('active highlight');
            } else {
                label.removeClass('highlight');
            }
        } else if (e.type === 'focus') {

            if ($this.val() === '') {
                label.removeClass('highlight');
            }
            else if ($this.val() !== '') {
                label.addClass('highlight');
            }
        }

    });

    $('.tab a').on('click', function (e) {

        e.preventDefault();

        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');

        target = $(this).attr('href');

        $('.tab-content > div').not(target).hide();

        $(target).fadeIn(600);

    });</script>


</body>

</html>