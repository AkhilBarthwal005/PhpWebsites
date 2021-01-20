<?php
  session_start();
  include "_dbconnect.php";
echo '  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">Let\'s Discuss</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          TOP 10 categories
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
          $sql = "SELECT * FROM `category` LIMIT 10";
          $result = mysqli_query($conn,$sql);
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['category_id'];
            $title = $row['category_name'];
            echo '<a class="dropdown-item" href="/threadslist.php?cat_id='.$id.'">'.$title.'</a>
               <div class="dropdown-divider"></div>';
          }
          echo '</div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact Us</a>
        </li>
      </ul>
      <div class="row">';
      if (isset($_SESSION['loggedin']) and $_SESSION['loggedin'] == true) {
      echo '<form class="form-inline my-2 my-lg-0" method="GET" action="search.php">
        <input class="form-control mr-sm-2" name="search_query" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
        <p class ="text-light my-0 mx-2"> Welcome '. $_SESSION['username'] . '</p>
        <a href="components/_logout.php" class="btn btn-outline-success mr-3">logOut</a>
      </form>';
      }
      else{
        echo '<form class="form-inline my-2 my-lg-0" method="GET" action="search.php">
        <input class="form-control mr-sm-2" name="search_query" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <button class="btn btn-outline-success ml-3" data-toggle="modal" data-target="#loginModal">Sing in</button>
        <button class="btn btn-outline-success ml-2 mr-2" data-toggle="modal" data-target="#singupModal">Sing Up</button>';
      }
    
    echo'</div>
    </div>
  </nav>';

  // here we are including the files.
  include "components/_loginModal.php";
  include "components/_singupModal.php";

  // showing alerts for singup
  if (isset($_GET['singupsuccess']) and $_GET['singupsuccess']=="true") {
 
    echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
              <strong>Success!</strong> You should now login using your email and password.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>';
  }
  else if (isset($_GET['singupsuccess']) and $_GET['singupsuccess']=="false") {
    echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
              <strong>Error! </strong>'.$_GET['error'].'
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>';
  }

  // showing alerts for login
  else if (isset($_GET['loginsuccess']) and $_GET['loginsuccess']=="true") {
 
    echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
              <strong>Success!</strong> You have successfully loggedin.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>';
  }
  else if (isset($_GET['loginsuccess']) and $_GET['loginsuccess']=="false") {
    echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
              <strong>Error! </strong>'.$_GET['error'].'
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>';
  }
  else if (isset($_GET['logoutsuccess']) and $_GET['logoutsuccess']=="true") {
    echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
              <strong>Success! </strong> You have been successfully logout.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>';
  }
  
?>