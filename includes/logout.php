<?php
//Kill session
session_start();
session_unset();
session_destroy();
if(isset($_COOKIE[session_name()])):
    setcookie(session_name(), '', time()-7000000, '/');
endif;

if(isset($_COOKIE['login'])):
    setcookie('login', '', time()-7000000, '/');
endif;
header("Location: ../index.php");
