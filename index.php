<?php 
	session_start();
	require("config.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="index.css">
</head>
	<?php include "header.php";?>
	<body id="body">
		<nav class="navbar navbar-expand-lg">
		  <a class="navbar-brand" href="index.php" id="nav-text">CelebrateMate</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		</nav>
		<div class='container mt-3'>
			<div><center><b style="color:#d15c85;font-size:50px">CelebrateMate&#127872</b><br><h1 style="color:#4192b0">Never miss a chance to wish your dearest ones..</center></div>
			<div class='row'>
				<div class='col-md-5 mx-auto'>
					<h3 class='text-center'style="color:#d15c85">LOGIN</h3>
					<?php 
						if(isset($_POST["login"])){
							$_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
							$uname = mysqli_real_escape_string($con, $_POST["uname"]);
							$email = mysqli_real_escape_string($con, $_POST["email"]); // added email
							$upass = mysqli_real_escape_string($con, $_POST["upass"]);
							$sql = "select * from admin where ANAME='{$uname}'  and Email='{$email}'and APASS='{$upass}'";
							$res=$con->query($sql);
							if($res->num_rows>0){
								$row=$res->fetch_assoc();
								$_SESSION["login_info"]=$row;
								header('location:home.php');
							}else{
								echo"<div class='alert alert-danger'>Invalid Login Details.</div>";
							}
						}
					?>
					<form action='index.php' method='post' style="color:#d15c85">
						<div class="form-group">
							<label>User Name</label>
							<input type="text"class="form-control" name='uname'  placeholder="UserName" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="Email"class="form-control" name='email'  placeholder="Email" required>
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" name='upass' placeholder="Password" required>
						</div>
						<div class="form-group">
							<input type='submit' name='login' value='Login' class='btn btn-primary'id="submit">
							<a href="forgot-password.php">Forgot password?</a>
						</div>
					</form>
				</div>
				
			</div>
		</div>

	</body>
</html>