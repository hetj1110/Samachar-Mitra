<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 8){
    $password_err = "Password cannot be less than 8 characters";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
}


// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        // Set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
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

                                <label for="reg-log"></label> -->

                                <div class="card-3d-wrap mx-auto">
                                    <div class="card-3d-wrapper">
                                       
                                       <form action="" method="post">

                                        <!-- card back part......... -->
                                        <form action="" method="post">
                                        <div class="card-back">

                                            <div class="center-wrap">
                                                <div class="section text-center">

                                                    <h4 class="mb-4 pb-3">Sign Up</h4>

                                                    <!-- user name -->
                                                    <div class="form-group">
                                                        <input type="text" name="username" class="form-style" placeholder="Your Full Name" id="logname" autocomplete="off">
                                                        <i class="input-icon uil uil-user"></i>
                                                    </div>

                                                    
                                                    <!-- email -->
                                                    <div class="form-group mt-2">
                                                        <input type="email" name="email" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off">
                                                        <i class="input-icon uil uil-at"></i>
                                                    </div>


                                                    
                                                    <!-- password  -->
                                                    <div class="form-group mt-2">
                                                        <input type="password" name="password" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off">
                                                        <i class="input-icon uil uil-lock-alt"></i>
                                                    </div>

                                                    <!-- confirm password -->
                                                    <div class="form-group mt-2">
                                                        <input type="password" name="confirm_password" class="form-style" placeholder="Confirm Password" id="logpass" autocomplete="off">
                                                        <i class="input-icon uil uil-lock-alt"></i>
                                                    </div>

                                 

                                                    <!-- Sign Up Button -->
                                                    <!-- <button class="btn mt-4">signup</button> -->
                                                    <button type="submit" class="btn btn-primary">Sign in</button>


                                                </div>

                                            </div>
                                        </div>
                                        </form>

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