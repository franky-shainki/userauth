<?php
include 'partials/_dbconnect.php';
$showerror=" ";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $existsql = "Select * from users where username='$username'";
    $result = mysqli_query($conn,$existsql);
    $exists = mysqli_num_rows($result);
    if ($exists==0) {
        if ($password == $cpassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = "INSERT INTO `users` (`username`, `email`, `password`, `date/time`) VALUES ('$username', '$email', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $insert);
            if (!$result) {
                $showerror='<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>technical error!</strong> sorry we are facing some technical issue.we regret for the inconvenience caused.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
            else {
                $showerror= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>congrats!</strong> You have been registered successfully.you can log in now.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';

                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: index.php");
                exit;

            }
        } else {
            $showerror='<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>oh no!</strong> passwords did not match.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    } else {
        $showerror='<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>@' . $username . '</strong>This username already exists .
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
<?php require 'partials/nav.php';
?>

<?php
echo $showerror;
?>
<div class="container ">
<h1 >SignUp to iSecure.</h1>
    <form action="/userauth/signup.php" method="post">
        <div class="mb-3 col-md-6">
            <label for="username" class="form-label">Username</label>
            <input type="name" maxlength="20" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3 col-md-6">
            <label for="email" class="form-label">Email address</label>
            <input type="email" maxlength="50" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3 col-md-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" minlength="8" maxlength="20" class="form-control" name="password" id="password" required>
            <div id="passwordHelp" class="form-text">minimum 8 / maximum 20 characters.</div>
        </div>
        <div class="mb-3 col-md-6">
            <label for="cpassword" class="form-label">Confirm Password</label>
            <input type="password" minlength="8" maxlength="20" class="form-control" name="cpassword" id="cpassword" required>
            <div id="cpasswordhelp" class="form-text">Make sure you enter the same password.</div>
        </div>
        <button type="submit" class="btn btn-primary col-md-6">Submit</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>