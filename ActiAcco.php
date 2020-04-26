<?php
 
 //activate membership registration
 if (!isset($_GET['activationcode']))
 	{
   		header("location:index.php");
 	}

 $activationcode  = trim(stripslashes(htmlspecialchars($_GET['activationcode'])));
 
  require_once("classes/Config.php");

 $member = new Member();
 $result = $member->activateMembershipAccount($activationcode);

 $status = $result["status"];
 $nextPage = $result["nextPage"];

 if ($status=="failed")
 	{
 		//echo "<br>Inside failed block";
 		header("location:".$nextPage);
 	}
 else if ($status=="expired")
 {
 	//echo "<br>Inside expired block.";
 	session_start();
 	$_SESSION['505msg'] = "Dear User, <br/><br/>An email has been sent to your email to activate your account.<br/><br/>Thank you.";
 	header("location:".$nextPage); 

 }
 else if ($status=="success")
 {
 	$_SESSION['memberLogin'] = 'mtabernacle2018';
 	header("location:".$nextPage);

 }







?>