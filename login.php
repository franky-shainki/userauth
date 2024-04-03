<?php
include 'partials/_dbconnect.php';
$showerror = " ";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hash=password_hash($password, PASSWORD_DEFAULT);
    $sql = "Select * from users where username='$username'";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        
        $showerror='<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>technical error!</strong> sorry we are facing some technical issue.we regret for the inconvenience caused.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {

                $showerror = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>success!</strong> You are logged in.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: index.php");
                exit;
            }
            else{
                $showerror='<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Wrong password!</strong> you have entered wrong Password for @'.$username.'.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';

            }
        }
    } else {
        $showerror='<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Username <strong>@'.$username.' </strong> doesn\'t exist .
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<?php
 require 'partials/nav.php';
?>
<?php
echo $showerror;
?>
<div class="container ">
<h1 >login to iSecure.</h1>
    <form action="/userauth/login.php" method="post">
        <div class="mb-3 col-md-6">
            <label for="username" class="form-label">Username</label>
            <input type="name" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3 col-md-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary col-md-6">login</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>