<?php
include 'connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        echo "Both fields are required.";
        exit;
    }

    // Prepare and execute SQL query
    $sql = "SELECT id, name, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Successful login
            // echo "Welcome, " . htmlspecialchars($user['name']) . "!";
            // // You can start a session and store user details here
            // session_start();
            // $_SESSION['user_id'] = $user['id'];
            // $_SESSION['name'] = $user['name'];
            header("Location: https://www.google.com");
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid email or password.');</script>";
        }
    } else {
        // User not found
        echo "<script>alert('Invalid email or password.');</script>";
    }

    $stmt->close();
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"
        id="bootstrap-css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Bootstrap 4 Login/Register Form</title>
</head>

<body>
    <div id="logreg-forms">
        <form class="form-signin" method="POST" action="index.php">
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Sign in</h1>
            <div class="social-login">
                <button class="btn facebook-btn social-btn" type="button"
                    onclick="goto('http://www.facebook.com')"><span><i class="fab fa-facebook-f"></i> Sign
                        in with Facebook</span> </button>
                <button class="btn google-btn social-btn" type="button" onclick="goto('http://www.google.com')"><span><i
                            class="fab fa-google-plus-g"></i> Sign
                        in with Google+</span> </button>
            </div>
            <p style="text-align:center"> OR </p>
            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required=""
                autofocus="">
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required="">

            <button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> Sign in</button>
            <a href="#" id="forgot_pswd">Forgot password?</a>
            <hr>
            <!-- <p>Don't have an account!</p>  -->
            <button class="btn btn-primary btn-block" type="button" id="btn-signup"><i class="fas fa-user-plus"></i>
                Sign up New Account</button>
        </form>

        <form action="/reset/password/" class="form-reset">
            <input type="email" id="resetEmail" class="form-control" placeholder="Email address" required=""
                autofocus="">
            <button class="btn btn-primary btn-block" type="submit">Reset Password</button>
            <a href="#" id="cancel_reset"><i class="fas fa-angle-left"></i> Back</a>
        </form>

        <form method="POST" action="/signup.php" class="form-signup">
            <div class="social-login">
                <button class="btn facebook-btn social-btn" type="button"><span><i class="fab fa-facebook-f"></i> Sign
                        up with Facebook</span> </button>
            </div>
            <div class="social-login">
                <button class="btn google-btn social-btn" type="button"><span><i class="fab fa-google-plus-g"></i> Sign
                        up with Google+</span> </button>
            </div>

            <p style="text-align:center">OR</p>

            <input type="text" name="name" id="user-name" class="form-control" placeholder="Full name" required="" autofocus="">
            <input type="email" name="email" id="user-email" class="form-control" placeholder="Email address" required autofocus="">
            <input type="password" name="password" id="user-pass" class="form-control" placeholder="Password" required autofocus="">
            <input type="password" name="confirm_password" id="user-repeatpass" class="form-control" placeholder="Repeat Password" required
                autofocus="">

            <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-user-plus"></i> Sign Up</button>
            <a href="#" id="cancel_signup"><i class="fas fa-angle-left"></i> Back</a>
        </form>
        <br>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="main.js"></script>
</body>

</html>