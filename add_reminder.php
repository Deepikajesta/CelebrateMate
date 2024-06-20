<?php 
	session_start();
	require("config.php");
	
	if(!isset($_SESSION["login_info"])){
		header("location:index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
		<link rel="stylesheet" href="add.css">
</head>
	<?php include "header.php";?>
	<body>
		<?php include "navbar.php"; ?>
		<div class='container mt-4'>
			<div class='row'>
				<div class='col-md-4'>
					<h3 class='text-muted text-center'>ADD DETAILS&#127880</h3>
					<?php 
						if(isset($_POST["reg"])){
							$_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
							$name=mysqli_real_escape_string($con,$_POST["name"]);
							$email=mysqli_real_escape_string($con,$_POST["email"]);
							$celebration=mysqli_real_escape_string($con,$_POST["celebration"]);
							$dob=date("Y-m-d",strtotime($_POST["dob"]));
							
							$reminder_date_1=date("Y-m-d",strtotime($_POST["reminder_date_1"]));
                            $reminder_date_2=date("Y-m-d",strtotime($_POST["reminder_date_2"]));
                            $reminder_date_3=date("Y-m-d",strtotime($_POST["reminder_date_3"]));
                            // echo "$reminder_date_1";
							$sql="insert into users (NAME,EMAIL,Celebration,DOB,WISH_YEAR,reminderDate1,reminderDate2,reminderDate3) values ('{$name}','{$email}','{$celebration}','{$dob}','-','{$reminder_date_1}','{$reminder_date_2}','{$reminder_date_3}')";
							if($con->query($sql)){
								// //$user_id=mysqli_insert_id($con);
								// $sql1="insert into reminders(reminderDate1,reminderDate2,reminderDate3) values ('{$reminder_date_1}','{$reminder_date_2}','{$reminder_date_3}')";
								// if($reminder_con->query($sql1)){
								// echo"<div class='alert alert-success'>Added Success</div>";
							// }else{
							// 	echo"<div class='alert alert-danger'>Failed Try Again</div>";
							// }
					      	}
						     else{
							echo"<div class='alert alert-danger'>Failed Try Again</div>";	
						      }
					}
					?>
					<form action='add_reminder.php' method='post' autocomplete='off'>
						<div class="form-group">
							<label>Name &#128100</label>
							<input type="text" class="form-control"  name='name' placeholder="Name" required>
						</div>
						<div class="form-group">
							<label>Email &#128231</label>
							<input type="email" class="form-control" name='email' placeholder="Email" required >
						</div>
						<div class="form-group">
							<label>Celebration(Birthday/Anniversary)&#127882</label>
							<input type="text" class="form-control" name='celebration' placeholder="Celebration" required >
						</div>
						<div class="form-group">
							<label>Date Of Celebration&#128197</label>
							<input type="date" class="form-control " name='dob' placeholder="dd-mm-yyyy" required>
						</div>
						<div class="form-group">
                            <label>Reminder Date 1&#128276</label>
                               <input type="date" class="form-control " name="reminder_date_1"placeholder="dd-mm-yyyy">	
                        </div>
                        <div class="form-group">
                            <label>Reminder Date 2&#128276</label>
                               <input type="date" class="form-control " name="reminder_date_2" placeholder="dd-mm-yyyy">
                        </div>
                        <div class="form-group">
                            <label>Reminder Date 3&#128276</label>
                            <input type="date" class="form-control" name="reminder_date_3" placeholder="dd-mm-yyyy">
                        </div>
						<div class="form-group">
							<input type='submit' name='reg' value='Submit' class='btn btn-primary'>
						</div>
					</form>
				</div>
				<div class='col-md-8'>
					<table class='table table-bordered mt-5'>
						<thead>
							<tr>
								<td>S.No</td>
								<td>Name</td>
								<td>Email</td>
								<td>Celebration</td>
								<td>DOB</td>
								<td>Delete</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								$sql="select * from users order by ID desc";
								$res=$con->query($sql);
								if($res->num_rows>0){
									$i=0;
									while($row=$res->fetch_assoc()){
										$i++;
										echo "
										<tr>
											<td>{$i}</td>
											<td>{$row["NAME"]}</td>
											<td>{$row["EMAIL"]}</td>
											<td>{$row["Celebration"]}</td>
											<td>".date("d-m-Y",strtotime($row["DOB"]))."</td>
											<td><a href='delete_reminder.php?id={$row["ID"]}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are You Sure ?\")'>Delete</a></td>
										</tr>";
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>