<?php 


if ($_SERVER['REQUEST_METHOD']=="POST") {
        include "_dbconnect.php";
        $username = $_POST['username'];
        $email = $_POST['singupemail'];
        $password = $_POST['singuppass'];
        $confirm_password = $_POST['confirmPass'];

        // if user name exist or not
        $sqlexists = "SELECT * FROM `users` WHERE username = '$username'";
        $result = mysqli_query($conn,$sqlexists);
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            $showError = "This user name is already exist";
            header("Location: /index.php?singupsuccess=false&error=$showError");
        }
        else {
                // if email is exist or not
            $sqlexists = "SELECT * FROM `users` WHERE useremail = '$email'";
            $result = mysqli_query($conn,$sqlexists);
            $num = mysqli_num_rows($result);
            if ($num == 1) {
                $showError = "This email already in use";
                header("Location: /index.php?singupsuccess=false&error=$showError");
            }
            else {
                if ($password == $confirm_password) {
                    $hash = password_hash($password , PASSWORD_DEFAULT);
                    $sql = "INSERT INTO `users` (`username`, `useremail`, `user_password`, `user_time`) VALUES ( '$username', '$email', '$hash', current_timestamp());";
                    $result = mysqli_query($conn,$sql);
                    header("Location: /index.php?singupsuccess=true");
                    exit();
                }
                else {
                    $showError = "Password and confirm passowrd does not match";
                    header("Location: /index.php?singupsuccess=false&&error=$showError");
                }
            }
        }
        
    }
    

?>