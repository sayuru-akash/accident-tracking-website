<?php

session_start();

session_unset();
session_destroy();

echo "<script>alert('Log Out Success!');window.location.href='../login.php';</script>";