<?php 


if ($_SERVER['REQUEST_METHOD']=="POST") {
        include "_dbconnect.php";
        $email = $_POST['loginemail'];
        $password = $_POST['loginpassword'];

        // if email is not exist.
        $sql = "SELECT * FROM `users` WHERE useremail = '$email'";
        $result = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($result);
        if ($num == 0) {
            $showError = "This email id is not registerd yet";
            header("Location: /?loginsuccess=false&error=$showError");
        }
        else {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password,$row['user_password'])) {
                header("Location: /index.php?loginsuccess=true");
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
            }
            else {
                $showError = "Incorrect password";
                header("Location: /?loginsuccess=false&error=$showError");
            }
        }
    }
?>