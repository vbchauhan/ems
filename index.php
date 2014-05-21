<?php 

include ("global.php");
include ("layout.php");
include ("functions.php");


top();			
?>
<html>
<head>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>

<?php 
//session_start();
//if(isset($_SESSION['AUTH_USER_NAME']))
//{
//echo "<script type='text/javascript'>document.write('Welcome " . $_SESSION['AUTH_USER_NAME'] . "');</script>"; 
//echo "<script type='text/javascript'>$(document).ready(function(){ $('#div1').hide() });</script>";
//}
?>

</head>

<body>

<?php



if (@$_SESSION["AUTH_USER"]==true)
{

	$bg = '#eeeeee'; // Set the background color.
	echo '<table align="center" cellspacing="0" cellpadding="5">
			<tr class = "BackgroundColorChange">
	<td align="left"><b>Barcode</a></b></a></td>
	<td align="left"><b>Call No</b></a></td>
	<td align="left"><b>Last Return</b></a></td>
	<td align="left"><b>Loan Date</b></a></td>
	<td align="left"><b>Due Date</b></a></td>
	<td align="left"><b>User</b></a></td>
	<td align="left"><b>Start</b></a></td>
	<td align="left"><b>End</b></a></td>	
	<td align="left"><b>Institution</b></a></td></tr>';
	
	$data = download_aleph_data();
	foreach($data as $datarow) {
		if($datarow['Title'] == "Shady Grove Library iPad")
		{
			$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
			echo '<tr bgcolor="' . $bg . '" class = "tablecontent">
						<td align="left">'.$datarow['Barcode'].'</td>
						<td align="left">'.$datarow['Callno'].'</td>
						<td align="left">'.validate_date($datarow['Last_return']).'</td>
						<td align="left">'.validate_date($datarow['Loan']).'</td>
						<td align="left">'.validate_date($datarow['Due']).'</td>
						<td align="left">'.$datarow['User'].'</td>
						<td align="left">'.$datarow['Bk-start'].'</td>
						<td align="left">'.$datarow['Bk-end'].'</td>
						<td align="left">'.$datarow['Institution'].'</td></tr>';
		//		echo "Key: ".$key." Data: ".$data[1]."<br />";
		}
	}
	echo '</table>';
?>

<?php 
} 
if ($_SESSION["AUTH_USER"]==false)
{
if (@$message) 
	print '<div align="center"><font class="messagetext"><b>'.$message.'&nbsp;</b></font></div>';
else
	print '<br>';

?>

<div id="div1">
<BR>
		<H1>WELCOME TO THE PRIDDY LIBRARY MANAGEMENT SYSTEM</H1>
<BR>
<BR>
<H3>
<BR>
<BR>
To use this system you will need to login, <a href="/<?=strtolower($_SESSION["SystemNameStr"])?>/login.php" target="_self">click here to login</a>.<b>(STAFF USE ONLY)</b><BR>
<BR> 
<?php 

//	$GroupQuery = "select loangroup FROM loangroups WHERE ((groupvisible='1') and (viewitemstatuswithoutlogin='1'))";
//	$GroupResult = @mysql_query($GroupQuery);
//	$GroupNums = mysql_num_rows($GroupResult);
//	if ($GroupNums>=1)
//		{
?>
<BR>
<!--Otherwise you can see the status of items the loan system by <a href="/equipment/view/index.php" target="_self">clicking here for view only access</a>.-->
To request a Hold on the iPad, please submit a request by filling the form  <a href="/<?=strtolower($_SESSION["SystemNameStr"])?>/request.php" target="_self">Click here to access the Form</a>
</H3>
</div>

<?php 
//		} //END if ($GroupNums>=1)
} //END if (@$_SESSION["AUTH_USER"]==false)
bottom();
?>


</body>
</html>