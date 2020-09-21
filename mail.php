<?php
$email = "omari.ayoub90@gmail.com";
$name="ayoub omari";
$password="123456";


$to = $email;
		$subject = "HTML email";

		$message = "
				<html>
				<head>
				<title>Notification Email</title>
				</head>
				<body>
				<p><b>Dear ".$name."</b>,<br/> An account has been made for you,<br/> 
				please use below credintails in order to login </p>
				<p><a href='http://pmo.ses-jo.com/'>click here to visit website</a></p>
				<table>
				<tr>
				<th>Email</th>
				<th>Password</th>
				</tr>
				<tr>
				<td>".$email."</td>
				<td>".$password."</td>
				</tr>
				</table>
				</body>
				</html>
				";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <subconstructor@ses-jo.com>' . "\r\n";
			//$headers .= 'Cc: subconstructor@ses-jo.com' . "\r\n";

			mail($to,$subject,$message,$headers);
?>