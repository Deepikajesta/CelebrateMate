<?php 
	function number_suffix($number){
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		 if ((($number % 100) >= 11) && (($number%100) <= 13)){
			return $number. 'th';
		 }else{
			return $number.$ends[$number % 10];
		 }
	}
	
	$notifications=[];
	$current_month_day=date("m-d");
	$sql="select * from users 
   where 
  DATE_FORMAT(DOB, '%m-%d') = '$current_month_day' 
  OR DATE_FORMAT(reminderDate1, '%m-%d') = '$current_month_day' 
  OR DATE_FORMAT(reminderDate2, '%m-%d') = '$current_month_day' 
  OR DATE_FORMAT(reminderDate3, '%m-%d') = '$current_month_day'";
	$res=$con->query($sql);
	if($res->num_rows>0){
		while($row=$res->fetch_assoc()){
			$users[]=$row;
		}
	}
	foreach($users as $user){
	$days_to_reminder1 = floor(abs(strtotime($user["DOB"]) - strtotime($user["reminderDate1"])) / (24 * 60 * 60));
    $days_to_reminder2 = floor(abs(strtotime($user["DOB"]) - strtotime($user["reminderDate2"])) / (24 * 60 * 60));
$days_to_reminder3 = floor(abs(strtotime($user["DOB"]) - strtotime($user["reminderDate3"])) / (24 * 60 * 60));
			if($current_month_day == date("m-d", strtotime($user["DOB"]))){
               $age=(date("Y")-date("Y",strtotime($user["DOB"])))+1;
              $notifications[]="<i class='fa fa-bell'></i> &#127873Wish <b>{$user["NAME"]}</b> a Happy {$user["Celebration"]}&#127881!<br> This is <b>{$user["NAME"]}</b>'s ".number_suffix($age)." {$user["Celebration"]}&#129321. Date of birth is <b>".date("d-m-Y",strtotime($user["DOB"]))."</b>";
			}
			if($current_month_day== date("m-d", strtotime($user["reminderDate1"]))){
				$notifications[]="<i class='fa fa-bell'></i> Reminder:<b>{$user["NAME"]}</b>'s {$user["Celebration"]} &#127881 is coming up in $days_to_reminder1 days&#129395!Date of celebration is <b>".date("d-m-Y",strtotime($user["DOB"]))."</b>";
			}
			if($current_month_day== date("m-d", strtotime($user["reminderDate2"]))){
				$notifications[]="<i class='fa fa-bell'></i> Reminder: <b>{$user["NAME"]}</b>'s {$user["Celebration"]}&#127881 is coming up in $days_to_reminder2 days&#129395!Date of celebration is <b>".date("d-m-Y",strtotime($user["DOB"]))."</b>";
			}
			if($current_month_day== date("m-d", strtotime($user["reminderDate3"]))){
				$notifications[]="<i class='fa fa-bell'></i> Reminder:<b>{$user["NAME"]}</b>'s {$user["Celebration"]}&#127881 is coming up in $days_to_reminder3 days&#129395!Date of celebration is <b>".date("d-m-Y",strtotime($user["DOB"]))."</b>";
			}
			
	}
 ?>
<link rel="stylesheet" type="text/css" href="navbar.css">
<nav class="navbar navbar-expand-lg" style="background-color:#e89eb2">
	<a class="navbar-brand" href="home.php"style="text-decoration:none" ><b style="font-color:white">CelebrateMate &#127872	</b></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNav" >
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href="home.php"><span class='fa fa-user'></span> Welcome : <?php echo $_SESSION["login_info"]["ANAME"]; ?> </a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="home.php"><span class='fa fa-home'></span> Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="add_reminder.php"><span class='fa fa-plus'></span> Add/Delete Reminder</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class='fa fa-bell'></span>(<?php echo count($notifications);?>)
				</a>
				<?php if(count($notifications)>0): ?>
					<div class="dropdown-menu dropdown-menu-right p-2" aria-labelledby="navbarDropdown">
						<?php foreach($notifications as $row):?>
							<a class="dropdown-item pt-3 pb-3 alert alert-success" href="#"><?php echo $row; ?></a>
						<?php endforeach;?>
					</div>
				<?php endif; ?>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="logout.php">Logout</a>
			</li>
		</ul>
	</div>
</nav>