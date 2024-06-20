<?php
$conn = mysqli_connect("localhost", "root", "Deepika@123", "db_birthday_reminder");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["reset_password"])) {
    $token = $_POST["token"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    
    // Verify token
    $sql = "select * from admin where reset_token = '$token'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // Token is valid, reset password
        if ($new_password == $confirm_password) {
            $new_token = rand(0, 999999);
            $sql = "update admin set APASS = '$new_password', reset_token = '$new_token' where reset_token = '$token'";
            mysqli_query($conn, $sql);
            if (mysqli_query($conn, $sql)) {
                alert("Password reset successfully");
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            alert( "New password and confirm password do not match");
        }
    } else {
        echo "Invalid token";
    }
}
?>
<html>
<head>
    <link rel="stylesheet" href="password.css">
    <style>
        label{
            font-size:30px;
        }
        input{
            width:150px;
            height:30px;
        }
        </style>
</head>
    <body>
<form onsubmit="return validateForm()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<h1>Reset Password</h1>
    <label>Token</label>
  <input type="text" class="form-control" name="token" required><br><br>
    
        <label>New Password</label>
        <input type="password" class="form-control" id="password" name="new_password" required><br><br>
    
    
        <label>Confirm Password</label>
        <input type="password" class="form-control" name="confirm_password" required><br><br>
    
    <button type="submit" name="reset_password" class="btn btn-primary">Reset Password</button>
    <button><a href="index.php">Back to Login</a></button>

</form>
<script>
    function validateForm() {
    const password = document.getElementById("password").value;
    if (password.length < 7) {
      alert("Password must be at least 7 characters long");
    }
    if (!/[A-Z]/.test(password)) {
      alert("Password must contain at least one uppercase letter");
    }
    if (!/[a-z]/.test(password)) {
      alert("Password must contain at least one lowercase letter");
    }
    if (!/\d/.test(password)) {
      alert("Password must contain at least one number");
    }
    if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
      alert("Password must contain at least one special character");
    }
}
</script>
</body>
</html>
