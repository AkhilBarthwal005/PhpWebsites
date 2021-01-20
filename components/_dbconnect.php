<?php

    $servername = "localhost";
    $username = "root";
    $password = "9557860483Akhil";
    $dbname = "letsdiscuss";

    $conn = mysqli_connect($servername,$username,$password,$dbname);
    if (!$conn) {
       die("Connection has been die");
    }

?>