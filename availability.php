<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="/ems/css/main.css" rel="stylesheet" media="screen">
<title>Priddy Loan System</title>
<link rel="shortcut icon" href="/ems/favicon.ico" type="image/x-icon">
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<?php
include ("global.php");
include ("layout.php");
include ("functions.php");

?>
</head>
<body>

<div id="banner">EQUIPMENT MANAGEMENT SYSTEM</div>

	<div id="container">
		<div id="topnavi">
    		<?php 
    		//	if (@$_SESSION["AUTH_USER"]==true) {
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/request.php">Request iPad</a>';
			?>            
		</div>
<div style = "text-align:center;width:1000px;padding: 20px 0 10px;font-size:18px;font-weight:bold">Equipment Availability</div>
<?php
$bg = '#eeeeee'; // Set the background color.

echo '<table align="center" cellspacing="0" cellpadding="5">
			<tr class = "BackgroundColorChange">
	<td align="left"><b>Equipment Type</a></b></a></td>
	<td align="left"><b>Available</b></a></td>
	<td align="left"><b>Total</b></a></td>
	</tr>';

// Get information using the webservice call
$data = download_availableitems_data();

foreach($data as $datarow) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
	echo '<tr bgcolor="' . $bg . '" class = "tablecontent">
				<td align="left">'.$datarow['Type'].'</td>
				<td align="left">'.$datarow['Available'].'</td>
				<td align="left">'.$datarow['Total'].'</td>
				</tr>';

}
echo '</table>'; 

?>
<br>
<br>
<br>
</body>
</html>