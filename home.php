<?php 
	session_start();
	require("config.php");
	
	if(!isset($_SESSION["login_info"])){
		header("location:index.php");
	}
	
	$users=[];
	$current_month_day=date("m-d");
	$current_year=date("Y");
$sql = "select * from users 
where 
  (DATE_FORMAT(DOB, '%m-%d') = '$current_month_day' OR 
   DATE_FORMAT(reminderDate1, '%m-%d') = '$current_month_day' OR 
   DATE_FORMAT(reminderDate2, '%m-%d') = '$current_month_day' OR 
   DATE_FORMAT(reminderDate3, '%m-%d') = '$current_month_day') 
  AND WISH_YEAR <> '$current_year'";
	$res=$con->query($sql);
	if($res->num_rows>0){
		while($row=$res->fetch_assoc()){
			$users[]=$row;
		}
	}
foreach($users as $user){      

	// Account details
	$apiKey = urlencode('Njg3ODc1Njc0NDQ0MzU0NDYxNGQ1NTYyNzA3OTQxMzk=');
	
	// Message details
	$numbers = array(919392573228);
	$sender = urlencode('TXTLCL');
	
	if($current_month_day == date("m-d", strtotime($user["DOB"]))){
		$message ="<h3>Wish <b>{$user["NAME"]}</b> a Happy {$user["Celebration"]}🎉!<br> This is <b>{$user["NAME"]}</b>'s "."$age"." year {$user["Celebration"]}🥳. Date of celebration is <b>".date("d-m-Y",strtotime($user["DOB"]))."</b></h3>";
	}
	if($current_month_day== date("m-d", strtotime($user["reminderDate1"]))){
		$message ="<i class='fa fa-bell'></i> Reminder: <b>{$user["NAME"]}</b>'s {$user["Celebration"]}🎉 is coming up in $days_to_reminder1 days!🥳. Date of celebration is <b>".date("d-m-Y",strtotime($user["DOB"]))."</b>";
	}
	if($current_month_day== date("m-d", strtotime($user["reminderDate2"]))){
		$message ="<i class='fa fa-bell'></i> Reminder: <b>{$user["NAME"]}</b>'s {$user["Celebration"]}🎉 is coming up in $days_to_reminder2 days!🥳. Date of celebration is <b>".date("d-m-Y",strtotime($user["DOB"]))."</b>";		
		}
	if($current_month_day== date("m-d", strtotime($user["reminderDate3"]))){
		$message ="<i class='fa fa-bell'></i> Reminder: <b>{$user["NAME"]}</b>'s {$user["Celebration"]}🎉 is coming up in $days_to_reminder3 days!🥳. Date of celebration is <b>".date("d-m-Y",strtotime($user["DOB"]))."</b>";		
	}
 
	$numbers = implode(',', $numbers);
 
	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message,"template" =>"749947   ");
 
	// Send the POST request with cURL
	$ch = curl_init('https://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/NEW/birthday-reminder/vendor/phpmailer/phpmailer/src/Exception.php';
require '/var/www/html/NEW/birthday-reminder/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '/var/www/html/NEW/birthday-reminder/vendor/phpmailer/phpmailer/src/SMTP.php';

foreach($users as $user){
    $mail = new PHPMailer(true);
	$age=(date("Y")-date("Y",strtotime($user["DOB"])))+1;
	$days_to_reminder1 = floor(abs(strtotime($user["DOB"]) - strtotime($user["reminderDate1"])) / (24 * 60 * 60));
$days_to_reminder2 = floor(abs(strtotime($user["DOB"]) - strtotime($user["reminderDate2"])) / (24 * 60 * 60));
$days_to_reminder3 = floor(abs(strtotime($user["DOB"]) - strtotime($user["reminderDate3"])) / (24 * 60 * 60));
    try {
        $mail->isSMTP(); 
        $mail->Host = 'smtp.gmail.com'; // Your SMTP server
        $mail->SMTPAuth = true; 
        $mail->Username = 'celebratemate287@gmail.com'; // Your Gmail address
        $mail->Password = 'gujciyrwekpvpwhb		'; // Your Gmail password
        $mail->SMTPSecure = 'tls'; 
        $mail->Port = 587; 

        $mail->setFrom('celebratemate287@gmail.com', 'CelebrateMate'); // Your Gmail address and name
        $mail->addAddress('deepikajesta287@gmail.com'); // Recipient's email address

        $mail->isHTML(true);
		
			if($current_month_day == date("m-d", strtotime($user["DOB"]))){
				$mail->Subject = 'Wish Your Greetings';
				$mail->Body="<h3>Wish <b>{$user["NAME"]}</b> a Happy {$user["Celebration"]}🎉!<br> This is <b>{$user["NAME"]}</b>'s "."$age"." year {$user["Celebration"]}🥳. Date of celebration is <b>".date("d-m-Y",strtotime($user["DOB"]))."</b></h3>";
			}
			if($current_month_day== date("m-d", strtotime($user["reminderDate1"]))){
				$mail->Subject="Reminder<:Upcoming Celebrations";
				$mail->Body="<i class='fa fa-bell'></i> Reminder: <b>{$user["NAME"]}</b>'s {$user["Celebration"]}🎉 is coming up in $days_to_reminder1 days!🥳. Date of celebration is <b>".date("d-m-Y",strtotime($user["DOB"]))."</b>";
			}
			if($current_month_day== date("m-d", strtotime($user["reminderDate2"]))){
				$mail->Subject="Reminder<:Upcoming Celebrations";
				$mail->Body="<i class='fa fa-bell'></i> Reminder: <b>{$user["NAME"]}</b>'s {$user["Celebration"]}🎉 is coming up in $days_to_reminder2 days!🥳. Date of celebration is <b>".date("d-m-Y",strtotime($user["DOB"]))."</b>";		
				}
			if($current_month_day== date("m-d", strtotime($user["reminderDate3"]))){
				$mail->Subject="Reminder<:Upcoming Celebrations";
				$mail->Body="<i class='fa fa-bell'></i> Reminder: <b>{$user["NAME"]}</b>'s {$user["Celebration"]}🎉 is coming up in $days_to_reminder3 days!🥳. Date of celebration is <b>".date("d-m-Y",strtotime($user["DOB"]))."</b>";		
			}
			
        $mail->send();

        $sql = "update users set WISH_YEAR='{$current_year}' where ID='{$user["ID"]}'";
        $con->query($sql);

    } catch (Exception $e) {
		echo "Mail send Failed!!! " . $e->getMessage();
	}
	
}

?> 
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="home.css">
</head>
	<?php include "header.php";?>
	<body id="bd">
		<?php include "navbar.php"; ?>
		<div class='container mt-4'>
			<div class='row'>
				
				<div class='col-md-4'>
					<?php foreach($notifications as $row):?>
					  <div class="alert alert-primary mb-3 pt-4 pb-4" href="#"><?php echo $row; ?></div>
					<?php endforeach;?>
				</div>
				<div class='col-md-8' >
					<div class="jumbotron"id="div">
						<h1 class="display-4">Celebrate Mate</h1></br>
						<!-- <hr class="my-4"> -->
						<p class="lead">In this project we create birthdays and anniversaries reminder system to wish your dearest ones.</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>  
		