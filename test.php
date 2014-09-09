<html>

<head>
<?php
include ("global.php");
include ("layout.php");
include ("functions.php");

?>
</head>
<body>





<?php
$bg = '#eeeeee'; // Set the background color.

echo '<table align="center" cellspacing="0" cellpadding="5">
			<tr class = "BackgroundColorChange">
	<td align="left"><b>Equipment Type</a></b></a></td>
	<td align="left"><b>Available</b></a></td>
	<td align="left"><b>Next Due</b></a></td>
	</tr>';

// Get information using the webservice call
$data = download_availableitems_data();

foreach($data as $datarow) {
	if($datarow['Available'] > 0)
		$nextDue = "Available Now";
	else
		$nextDue = $datarow['Earliest_due'];
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
	echo '<tr bgcolor="' . $bg . '" class = "tablecontent"">
				<td align="left">'.$datarow['Type'].'</td>
				<td align="left">'.$datarow['Available'].'</td>
				<td align="left">'.$nextDue.'</td>
				</tr>';

}
echo '</table>'; 

?>
<br>
<br>
<br>
</body>
</html>