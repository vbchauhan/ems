<head>
<link href="/<?=strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?=strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<title>Priddy Loan System</title>
</head>
<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
top();

if(isset($_POST["fname"])){
	$fname=$_POST["fname"];}else{echo "first name is not Set <br />";}
if(isset($_POST["lname"])){
	$lname=$_POST["lname"];}else{echo "last name is not Set <br />";}
if(isset($_POST["barcode"])){
	$barcode=$_POST["barcode"];}else{echo "barcode is not Set <br />";}
if(isset($_POST["email"])){
	$email=$_POST["email"];}else{echo "Email is not Set <br />";}
if(isset($_POST["pno"])){
	$pno=$_POST["pno"];}else{echo "pno is not Set <br />";}
	
if(isset($_POST["utype"])){
	$utype=$_POST["utype"];}else{echo "utype is not Set <br />";}
	
if(isset($_POST["institution"])){
	$institution=$_POST["institution"];}else{echo "institution is not Set <br />";}
if(isset($_POST["programname"])){
	$department=$_POST["programname"];}else{echo "Program is not Set <br />";}
if(isset($_POST["request_date"])){
	$request_date=$_POST["request_date"];}else{echo "Request Date is not Set <br />";}
if(isset($_POST["itemtype"])){
	$itemtype=$_POST["itemtype"];}else{echo "Item Type is not set <br />";}	
if(isset($_POST["items"])){
	$items=$_POST["items"];}else{echo "Items count is not set <br />";}
	

$userQuery = "Select users_id from users where first_name = '$fname' and last_name = '$lname' and barcode_id = '$barcode'";

$userResult = mysql_query ($userQuery);
$userNum = mysql_num_rows($userResult);


if($userNum >= 1)
{
	$userRow = mysql_fetch_array($userResult, MYSQL_ASSOC);
	$user_id = $userRow['users_id'];	


	
}
else 
{
// Create a new user in database	

$user_type = get_user_type_id($utype);
$inst = get_institution_id($institution);
$program = get_programs_id($department);
//echo $program;
$add_user_query=" INSERT INTO Users
(First_Name,Last_Name,Phone_Number,Email,Barcode_ID,Type_ID,Programs_Department_ID,Institutions_ID)
VALUES
('$fname','$lname','$pno','$email','$barcode','$user_type','$program','$inst')";

$add_user=mysql_query($add_user_query);

//This code will print the confirmation that the player has been registered in the database.
if (!$add_user)
{
	die('Error: ' . mysql_error());
}
else
{
	echo '<h2>New User created in the system.</h2><br>';
$userQuery = "Select users_id from users where first_name = '$fname' and last_name = '$lname' and barcode_id = '$barcode'";

$userResult = mysql_query ($userQuery);
$userNum = mysql_num_rows($userResult);


	if($userNum >= 1)
	{
		$userRow = mysql_fetch_array($userResult, MYSQL_ASSOC);
		$user_id = $userRow['users_id'];	
		
	}
}
	
}

$item_type_id = get_item_type_id($itemtype);


$sql=" INSERT INTO request
(No_of_items,Request_Date,Users_ID,Item_Type_ID)
VALUES
('$items','$request_date','$user_id','$item_type_id')";


$confirm=mysql_query($sql);


//This code will print the confirmation that the player has been registered in the database.
if (!$confirm)
	{
		die('Error: ' . mysql_error());
	}
else 
	{
	echo '<h1>Your request has been successfully sent to the Library Staff.</h1><br><br>
	You will receive an email a week before your iPad is available
	
	Thank you for using the iPad request System';
	
	$to = $email;
	$subject = 'Priddy Reserves - Book Request Details';
	
	$body = 'Dear Patron '.$fname.' '.$lname.',
	
	Thank you for making a request for the Equipment. Your Details are as follows:
		
	Request # : '.$mysql_insert_id().'
	Equipment : '.$itemtype.'
	No of Equipment : '.$items.'
	Barcode : '.$barcode.'
		
	Thank You, 
	Priddy Reserves

	NOTE: This is an auto-generated email. Please contact Madhu Singh at madhus@umd.edu for any further assistance. You might be requested to provide your Request # for faster processing of your queries.';
	
	$from = 'From: Priddy Reserves';
	mail($to, $subject, $body, $from);
	
	// Emailing Request Information to Madhu
	$to = 'madhus@umd.edu,priddyreserves@umd.edu,vchauhan@umd.edu';
	$subject = 'New Book Request';
	$body = '
	A new Equipment Request has been made by '.$fname.' '.$lname.'[Email: '.$email.'] via the Priddy Reserves System. The request details are as follows:
		
		
	Request # : '.$mysql_insert_id().'
	Equipment : '.$itemtype.'
	No of Equipment : '.$items.'
	Barcode : '.$barcode.'
	
';
	mail($to, $subject, $body, $from);
	}
?>