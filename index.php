<?php 

include ("global.php");
include ("layout.php");
include ("functions.php");


top();			
?>
<html>
<head>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<style>

a{
  text-decoration: none;
  border-bottom: 1px solid #564b47;
  color: #564b47;
}

</style>

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

if ($_GET['refresh'] == 1)
	refresh();

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
	<td align="left"><b>Booking Start Date</b></a></td>
	<td align="left"><b>Booking End Date</b></a></td>	
	</tr>';
// Get the data into database using the web service call	
	$data = download_aleph_data();
	$finaldata['ipad'] = array();
	$finaldata['laptop'] = array();
	$finaldata['laptop_charger'] = array();
	$finaldata['vga_cables'] = array();
	$finaldata['headphones'] = array();
	$finaldata['recorder'] = array();
	$finaldata['accessories'] = array();

	foreach($data as $datarow)
	{
		if($datarow['Title'] == "VGA Cables")
			array_push($finaldata['vga_cables'],$datarow);
  		elseif($datarow['Title'] == "Headphones No 9")
  			array_push($finaldata['headphones'],$datarow);
  		elseif($datarow['Title'] == "SG Laptop Charger")
  			array_push($finaldata['laptop_charger'],$datarow);
  		elseif($datarow['Title'] == "Shady Grove Library iPad")
  			array_push($finaldata['ipad'],$datarow);
  		elseif($datarow['Title'] == "Shady Grove circulating laptop")
  			array_push($finaldata['laptop'],$datarow);
  		elseif($datarow['Title'] == "TASCAM Linear PCM Recorder DR-40")
  			array_push($finaldata['recorder'],$datarow);
  		elseif($datarow['Title'] == "Touchscreen Accessories for 1200R")
  			array_push($finaldata['accessories'],$datarow);
	}
	$keys = array_keys($finaldata);
	$datarow = "";
	for($i=0;$i<sizeof($keys);$i++)
	{
		$key = $keys[$i];
		foreach($finaldata[$key] as $datarow) {
			if(!is_null($datarow['Title']))
			{
				$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
				echo '<tr bgcolor="' . $bg . '" class = "tablecontent">
							<td align="left">'.$datarow['Barcode'].'</td>
							<td align="left">'.$datarow['Callno'].'</td>
							<td align="left">'.validate_date($datarow['Last_return']).'</td>
							<td align="left">'.validate_date($datarow['Loan']).'</td>
							<td align="left">'.validate_date($datarow['Due']).'</td>
							<td align="left">'.$datarow['User'].'</td>
							<td align="left">'.validate_date($datarow['Bk-start']).'</td>
							<td align="left">'.validate_date($datarow['Bk-end']).'</td>
							</tr>';
			//		echo "Key: ".$key." Data: ".$data[1]."<br />";
			}
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
<?php 

//	$GroupQuery = "select loangroup FROM loangroups WHERE ((groupvisible='1') and (viewitemstatuswithoutlogin='1'))";
//	$GroupResult = @mysql_query($GroupQuery);
//	$GroupNums = mysql_num_rows($GroupResult);
//	if ($GroupNums>=1)
//		{
?>
<div align="left" style="border:2px solid #000; width:61%; height:50%; margin-left:200px; margin-top:70px">
<table width="80%" border="0" cellspacing="1" cellpadding="1" align="center" style="margin-top:10px; margin-bottom:20px; background-color:#FFF">
  <tr class="tabletitle2">
    <td height="49" colspan="2"><div align="center"><strong>View records</strong></div></td>
    <td colspan="2"><div align="center"><strong>Make requests</strong></div></td>
  </tr>
  <tr>
    <td width="19%" height="39"><div>
      <div align="right"><a href="login.php"><img src="images/login.png" width="64" height="64" />      </a></div>
    </div></td>
    <td width="40%"><div align="left"><a href="login.php"><strong style="color:#564b47">Login</strong></a><b>(STAFF ONLY)</b></div></td>
    <td width="19%"><div align="right"><a href="requestallequipment.php"><img src="images/laptopipad.jpg" width="64" height="64" /></a></div></td>
    <td width="55%"><div align="left"><a href="requestallequipment.php"><strong style="color:#564b47">Current bookings</strong></a></div></td>
  </tr>
  <tr>
    <td height="67"><div>
      <div align="right"><a href="availability.php"><img src="images/ipad-cart2.jpg" width="64" height="64" />      </a></div>
    </div></td>
    <td height="67"><div align="left"><a href="availability.php"><strong style="color:#564b47">Check availability</strong></a></div></td>
    <td><div align="right"><a href="request.php"><img src="images/ipad.png" width="64" height="64" /></a></div></td>
    <td><div align="left"><a href="request.php"><strong style="color:#564b47">Advance iPad booking</strong></a></div></td>
  </tr>
</table>
</div>
 

<!--Otherwise you can see the status of items the loan system by <a href="/equipment/view/index.php" target="_self">clicking here for view only access</a>.-->
<!--
To access the system, click here to <a href="login.php" target="_self">login</a>.<b>(STAFF USE ONLY)</b><BR>
To request iPad(s) in advance, submit this <a href="request.php" target="_self">form</a><br><br><br>
To check-out an equipment now, submit this <a href="requestallequipment.php" target="_self">form</a><br><br><br>
To check the Availability of Equipments at the Library, click <a href="availability.php" target="_self">here</a>
 -->
</H3>
</div>

<?php 
//		} //END if ($GroupNums>=1)
} //END if (@$_SESSION["AUTH_USER"]==false)
bottom();
?>


</body>
</html>