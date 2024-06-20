<?php
// Connect to database
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/NEW/birthday-reminder/vendor/phpmailer/phpmailer/src/Exception.php';
require '/var/www/html/NEW/birthday-reminder/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '/var/www/html/NEW/birthday-reminder/vendor/phpmailer/phpmailer/src/SMTP.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = mysqli_connect("localhost", "root", "Deepika@123", "db_birthday_reminder");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["forgot_password"])) {
  $email = $_POST["email"];
  // Validate email address
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address.";
  } else {
    $sql = "select * from admin WHERE Email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      $token = generate_token(); // generate a random token
    //   echo($token);
      $sql = "update admin set reset_token = '$token' WHERE Email = '$email'";
      mysqli_query($conn, $sql);
      send_password_reset_email($email, $token); 
      // send email with reset link
      echo "Password reset link sent to your email address.";
      header("Location: reset_password.php");
     exit;
    } else {
      echo "Email address not found.";
    }
    error_reporting(E_ALL);
ini_set('display_errors', 1);
  }
}
    
function generate_token() {
    $token = rand(100000, 999999);
    return $token;
}



function send_password_reset_email($email,$token) {
  $mail = new PHPMailer(true);
  try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
    $mail->isSMTP(); // Send using SMTP
    $mail->Host = 'smtp.gmail.com'; // Your SMTP server
    $mail->SMTPAuth = true; 
    $mail->Username = 'celebratemate287@gmail.com'; // Your Gmail address
    $mail->Password = 'gujciyrwekpvpwhb'; // Your Gmail password
    $mail->SMTPSecure = 'tls'; 
    $mail->Port = 587; 
    //Recipients
    $mail->setFrom('celebratemate287@gmail.com', 'CelebrateMate'); // Your Gmail address and name
    $mail->addAddress($email); // Add a recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Password Reset';
    $mail->Body = 'Enter the following token to reset your password: ' . $token;
        // $mail->AltBody = 'Click on the link to reset your password: (link unavailable)' . $token;

    $mail->send();
    echo 'Password reset email sent';
  } catch (Exception $e) {
    echo "Error sending email: " . $mail->ErrorInfo;
  }
}



// HTML form
?>
<html>
  <head>
    <link rel="stylesheet" href="password.css">
</head>
<body>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="form">
    <div class="form-group">
      <h1>Forgot Password</h1>
     <label>Email</label>
      <input type="email" class="form-control" name="email" placeholder="Enter your email address" required><br><br>
      <button type="submit" name="forgot_password" class="btn btn-primary">Reset Password</button>
    </div>
  </form>
</body>
</html>

