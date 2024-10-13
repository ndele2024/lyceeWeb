<?php
session_unset();
session_destroy();
header("Location:../index_login.php");
