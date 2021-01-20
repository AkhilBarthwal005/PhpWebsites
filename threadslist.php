<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Welcome to Let's Discuss- The Coding Forums</title>
</head>

<body>
    <?php  include "components/_header.php"?>
    <?php  include "components/_dbconnect.php"?>
    <!-- Making these intro dynaminc of threadslist dynamic  -->
    <?php
                $cat_id = $_GET['cat_id'];
                $sql = "SELECT * FROM `category` WHERE category_id=$cat_id";
                $result = mysqli_query($conn,$sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $cat_name=$row['category_name'];
                    $cat_desc=$row['category_discription'];
                } 
                // inserting form data to the database.
                if ($_SERVER['REQUEST_METHOD']=="POST") {
                    // insert into the database.
                    $showAlert=false;
                    $th_title = $_POST['title'];
                    // str_replace is used for replacing angular brackets which if user add in title will hack the website.
                    $th_title = str_replace("<","&lt;",$th_title);
                    $th_title = str_replace(">","&gt;",$th_title);

                    $th_desc = $_POST['desc'];
                    // str_replace is used for replacing angular brackets which if user add in discription will hack the website.
                    $th_desc = str_replace("<","&lt;",$th_desc);
                    $th_desc = str_replace(">","&gt;",$th_desc);


                    $session_user_id = $_SESSION['user_id']; 
                    // $cat_id is used for id in which category we have to insert data 
                    $sql = "INSERT INTO `threads` (`thread_title`, `thread_discription`, `cat_id`, `user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$cat_id', '$session_user_id', current_timestamp());";
                    $result = mysqli_query($conn,$sql);
                    $showAlert = true;
                    if($showAlert){
                        echo '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success! </strong> Your Question has been Added Successfully. Now wait for Community to respond.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                      </div>
                        ';
                    }
                }
    ?>

    <!-- Jumbatron start here means - introduction -->
    <div class="container mt-3">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $cat_name; ?> Forums</h1>
            <p class="lead"><?php echo $cat_desc; ?></p>
            <hr class="my-4">
            <p>No Spam / Advertising / Self-promote in the forums is not allowed.Do not post “offensive” posts, links or
                images Do not cross post questionsRemain respectful of other members at all times.</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>
    <!-- Media object for question and answers start here -->
    <!-- here we have make a form for asking question from the user  -->
    <!-- $_SERVER['SELF_PHP'] ==> This will call php to the same page for example in our case it will call threadslist it self. -->
    <!-- $_SERVER['REQUEST_URI'] == > it also call php page it self but it also include things after ? mark in url which Self_php does not do it.   -->
    <?php 
    if (isset($_SESSION['loggedin']) and $_SESSION['loggedin']=="true") {
        
    echo '<div class="container">
        <h2>Ask a Questions</h2>
        <form action="'. $_SERVER['REQUEST_URI'] . '" method="POST">
            <div class="form-group">
                <label for="title">Question Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp"
                    placeholder="Enter Question">
                <small id="emailHelp" class="form-text text-muted">Make sure your title should be Sort and Crisp
                    enough.</small>
            </div>
            <div class="form-group">
                <label for="desc">Ellaborate Your Question</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
    }
    else {
        echo '<div class="container">
            <h2>Ask a Questions</h2>
            <p class="lead bg-light">You are not logged in. Please login to be able to Ask a Question</p>
        </div>';
    }
    ?>

    <div class="container mt-4" style="min-height:144px" ;">
        <h2>Browse Questions</h2>
        <?php
                $cat_id = $_GET['cat_id'];
                $sql = "SELECT * FROM `threads` WHERE cat_id=$cat_id";
                $result = mysqli_query($conn,$sql);
                $noResult = true;
                while ($row = mysqli_fetch_assoc($result)) {
                    $noResult=false;
                    $id = $row['thread_id'];
                    $thread_title = $row['thread_title'];
                    $thread_desc = $row['thread_discription'];
                    $thread_time = $row['timestamp'];
                    // this for taking user name of user and show in the post question.
                    $user_id = $row['user_id'];
                    $sql2 = "SELECT username FROM `users` WHERE user_id = $user_id";
                    $result2 = mysqli_query($conn,$sql2);
                    $row2 = mysqli_fetch_assoc($result2);


                    echo '<div class="media mt-3 pt-3">
                            <img src="img/user-default.png" width="54px" class="mr-3" alt="...">
                            <div class="media-body">
                                <h5 class="mt-0"><a href="thread.php?thread_id='.$id.'" class="text-dark">' . $thread_title . '</a> </h5>
                                <p>'. substr($thread_desc,0,200) .'...</p> 
                            </div>
                            <P class="font-weight-bold mb-0"> '. $row2['username'] .' - '. $thread_time .' </p>
                        </div>';               
                    } 
                    if ($noResult) {
                        echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                          <p class="display-4">No Result Found</p>
                          <p class="lead">Be the First Person to ask the question.</p>
                        </div>
                      </div>';
                    }
        ?>
    </div>

    <?php  include "components/_footer.php"?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>

</html>