<?php
session_start();
unset($_SESSION["admin"]);
unset($_COOKIE["admin"]);
unset($_COOKIE["pass"]);
header("location:index.php");
?>