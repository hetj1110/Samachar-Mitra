<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: welcome.php");
    exit;
}
require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: welcome.php");
                            
                        }
                    }

                }

    }
}    

}

?>



<html>

<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="demo.css">
      <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>SAMACHAR MITRA</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">SAMACHAR MITRA</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">

      <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
        
      </ul>
    </div>
  </nav>

        <div class="all">

            <div class="section">

                <div class="container">

                    <div class="row full-height justify-content-center">

                        <div class="col-12 text-center align-self-center py-5">

                            <div class="section pb-5 pt-5 pt-sm-2 text-center">

                                <label for="reg-log"></label> 

                                <div class="card-3d-wrap mx-auto">
                                    <div class="card-3d-wrapper">
                                       
                                       <form action="" method="post">

                                        <!-- card front part....... -->
                                        <div class="card-front">

                                            <div class="center-wrap">
                                                <div class="section text-center">
                                                   
                                                   
                                                    <h4 class="mb-4 pb-3">Log In</h4>
                                                    
                                                    <!-- login field  -->
                                                    <div class="form-group">
                                                        <input type="text" name="username" class="form-style" placeholder="Your UserName" id="email" autocomplete="off">
                                                        <i class="input-icon uil uil-at"></i>
                                                    </div>

                                                    <!-- password field -->
                                                    <div class="form-group mt-2">
                                                        <input type="password" name="password" class="form-style" placeholder="Your Password" id="password" autocomplete="off">
                                                        <i class="input-icon uil uil-lock-alt"></i>
                                                    </div>


                                                    <!-- login button -->
                                                    <!-- <button class="btn mt-4" id="loginButton" onclick="home.html">Login</button> -->
                                                    <button type="submit" class="btn btn-primary">Login</button>

                                                    <!-- forgot password -->
                                                    <p class="mb-0 mt-4 text-center"><a href="#0" class="link">Forgot your password?</a></p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
</body>

</html>
