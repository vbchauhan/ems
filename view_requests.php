<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
//if (canupdate()) {
?>
<?php

if(isset($_GET["id"]) ){
$id=$_GET["id"];
	if(isset($_GET["cancel"]) ){
	$query = "delete from request WHERE Request_ID=$id";
	mysql_query($query);
		}
	else	
		{
		$query = "UPDATE request
		SET status='reserved' WHERE Request_ID=$id";
		mysql_query($query);
		}
}
		
	if(isset($_GET["sort"]) ){
		$sort=$_GET["sort"];
		}
	else{
		$sort="Request_Date";
		}
	if(isset($_GET["order"]) ){
		$order=$_GET["order"];
		}
	else{
		$order="asc";
	}
?>
<head>
<link href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<title>Priddy Loan System</title>
</head>
<div id="banner" "style:width="90%"";>EQUIPMENT MANAGEMENT SYSTEM</div>
	<div id="topnavi">
	<div id="topnavi">
			<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>"<?php if ($CurrentRequestURLarr[2]=="") print ' class="selected"'?>>Home</a>
 			<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/reserved.php"<?php if ($CurrentRequestURLarr[2]=="webadmin") print ' class="selected"'?>>View Reservations</a> 
			<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/view_requests.php"<?php ?>>Refresh</a>
			    		<?php 
    		
    		if (@$_SESSION["AUTH_USER"]==true) 
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/logout.php">LOGOFF</a>';
					else
						{
						$LoginSelectStr='';
						if ($CurrentRequestURLarr[2]=="login") $LoginSelectStr=' class="selected"';
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/index.php"'.$LoginSelectStr.'>LOGIN</a>'; 
						}?>
	</div>	
</div>	
<?php

$image=$_SESSION["SystemNameStr"]."/css/images/delete-icon.png";
echo "<H1> iPad Requests sorted as per $sort $order</H1>"; 
$data = download_aleph_data();
//echo $data[0]['Title'];
$sql = array();
foreach ($data as $datarow){
	$sql[] = '("'.$datarow['Title'].'","'.$datarow['Barcode'].'","'.$datarow['Callno'].'","'.$datarow['IS'].'","'.$datarow['Last_return'].'","'.$datarow['Loan'].'","'.$datarow['Due'].'","'.ltrim($datarow['User'],'0').'","'.$datarow['Status'].'","'.$datarow['Institution'].'","'.$datarow['Bk-start'].'","'.$datarow['Bk-end'].'")';
}
mysql_query('Truncate table aleph_data');
$abc = mysql_query('INSERT INTO aleph_data (Title, Barcode,Callno,IS_no,Last_return,Loan,Due,Aleph_ID,Status_id,Institution,Booking_date_from,Booking_date_to) VALUES '.implode(',', $sql));

$query = "SELECT Request_ID,No_of_items,Request_Date,Users_ID,Item_Type_ID FROM request order by $sort $order ";
$result = mysql_query($query); // Run the query.
echo '<table cellpadding="0" cellspacing="0" class="db-table"> <tr>';
if ($order=="asc"){
echo '<table align="center" cellspacing="0" cellpadding="5">
<tr class = "BackgroundColorChange">
	<td align="left"><a href="" class = "Textwhite"><b>User ID</b></a></td>				
	<td align="left"><a href="view_requests.php?sort=First_Name&order=desc" class = "Textwhite"><b>First Name</b></a></td>
	<td align="left"><a href="view_requests.php?sort=lname&order=desc" class = "Textwhite"><b>Last Name</a></b></a></td>
	<td align="left"><a href="view_requests.php?sort=barcode&order=desc" class = "Textwhite"><b>Barcode</b></a></td>
	<td align="left"><a href="view_requests.php?sort=email&order=desc" class = "Textwhite"><b>Email</b></a></td>
	<td align="left"><a href="view_requests.php?sort=pno&order=desc" class = "Textwhite"><b>Phone</b></a></td>
	<td align="left"><a href="view_requests.php?sort=utype&order=desc" class = "Textwhite"><b>User Type</b></a></td>
	<td align="left"><a href="view_requests.php?sort=institution&order=desc" class = "Textwhite"><b>Institutions</b></a></td>
	<td align="left"><a href="view_requests.php?sort=department&order=desc" class = "Textwhite"><b>Department</b></a></td>
	<td align="left"><a href="view_requests.php?sort=request_date&order=desc" class = "Textwhite"><b>Request Date</b></a></td>
	<td align="left"><a href="view_requests.php?sort=ipads&order=desc" class = "Textwhite"><b>Item Type Requested</b></a></td>
	<td align="left"><a href="view_requests.php?sort=ipads&order=desc" class = "Textwhite"><b>No Of Items</b></a></td>
	<!--<td align="left"><b>Status</b></td>-->
	<td align="left"><b>Action</b></td>
	
</tr>';
}
else{
echo '<table align="center" style = "background-color :#564b47; color : white" cellspacing="0" cellpadding="5">
<tr class = "BackgroundColorChange">
	<td align="left"><a href="" class = "Textwhite"><b>User ID</b></a></td>	
	<td align="left"><a href="view_requests.php?sort=First_Name&order=asc" class = "Textwhite"><b>First Name</b></a></td>
	<td align="left"><a href="view_requests.php?sort=lname&order=asc" class = "Textwhite"><b>Last Name</a></b></a></td>
	<td align="left"><a href="view_requests.php?sort=barcode&order=asc" class = "Textwhite"><b>Barcode</b></a></td>
	<td align="left"><a href="view_requests.php?sort=email&order=asc" class = "Textwhite"><b>Email</b></a></td>
	<td align="left"><a href="view_requests.php?sort=pno&order=asc" class = "Textwhite"><b>Phone</b></a></td>
	<td align="left"><a href="view_requests.php?sort=utype&order=asc" class = "Textwhite"><b>User Type</b></a></td>
	<td align="left"><a href="view_requests.php?sort=institution&order=asc" class = "Textwhite"><b>Institutions</b></a></td>
	<td align="left"><a href="view_requests.php?sort=department&order=asc" class = "Textwhite"><b>Department</b></a></td>
	<td align="left"><a href="view_requests.php?sort=request_date&order=asc" class = "Textwhite"><b>Request Date</b></a></td>
	<td align="left"><a href="view_requests.php?sort=ipads&order=asc" class = "Textwhite"><b>Item Type Requested</b></a></td>
	<td align="left"><a href="view_requests.php?sort=ipads&order=asc" class = "Textwhite"><b>No Of Items</b></a></td>	
	<!--<td align="left"><b>Status</b></td>-->
	<td align="left"><b>Action</b></td>
	
</tr>';
}

// Fetch and print all the records.
$bg = '#eeeeee'; // Set the background color.
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

$query_users = "SELECT * FROM users where Users_ID =".$row['Users_ID'];
$userResult = mysql_query($query_users); // Run the query.
$userRow = mysql_fetch_array($userResult, MYSQL_ASSOC);

if($userRow['Aleph_ID'] != '')
{
	$alephResult = mysql_query('Select * from aleph_data where Aleph_ID ="'.$userRow['Aleph_ID'].'"');
	$alephRow = mysql_fetch_array($alephResult, MYSQL_ASSOC);
	if ($alephRow['Aleph_ID'] && $row['Request_Date'] == $alephRow['Loan'])
	{
		$query_item = "SELECT * FROM items where barcode =".$alephRow['Barcode'];
		$itemResult = mysql_query($query_item); // Run the query.
		$itemRow = mysql_fetch_array($itemResult, MYSQL_ASSOC);
		$queryUpdate = "Insert into loans (Loan_Date , Return_Date , Due_Date , Request_accept_date , Booking_date_from , Booking_date_to , Request_ID , Items_ID , Users_ID )	values ('".date('Y-m-d',strtotime($alephRow['Loan']))."','".date('Y-m-d',strtotime($alephRow['Due']))."','".date('Y-m-d',strtotime($alephRow['Due']))."','".$row['Request_Date']."','".date('Y-m-d',strtotime($alephRow['Booking_date_from']))."','".date('Y-m-d',strtotime($alephRow['Booking_date_to']))."','".$row['Request_ID']."','".$itemRow['Items_ID']."','".$userRow['Users_ID']."');";
		mysql_query($queryUpdate);
		//echo "Success";
	}
	//else
		//echo "Error";
}

	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
	echo '<tr bgcolor="' . $bg . '" class = "tablecontent">
		<td align="left">' . $userRow['Aleph_ID'] . '</td>
		<td align="left">' . $userRow['First_Name'] . '</td>
		<td align="left">' . $userRow['Last_Name'] . '</td>
		<td align="left">' . $userRow['Barcode_ID'] . '</td>
		<td align="left">' . $userRow['Email'] . '</td>
		<td align="left">' . $userRow['Phone_Number'] . '</td>
		<td align="left">' . get_user_type_desc($userRow['Type_ID']) . '</td>
		<td align="left">' . get_institution_name($userRow['Institutions_ID']) . '</td>
		<td align="left">' . get_programs_name($userRow['Programs_Department_ID']). '</td>
		<td align="left">' . $row['Request_Date']. '</td>
		<td align="left">' . get_item_type_desc($row['Item_Type_ID']) . '</td>
		<td align="left">' . $row['No_of_items'] . '</td>
		<td align="left"><a href="editRequest.php?id=' . $row['Request_ID'] . '" target="_blank"> <img src="images/edit-icon.png" width="28" height="28"></a></td>
		<!--<td align="left"><a href="test.php" onclick = "compareitems()">Reserve</a></td>-->
		<td align="left"><a href="view_requests.php?id=' . $row['Request_ID'] . '&cancel=1" onclick="confirmdelete()"><img src="images/delete-icon.png" width="28" height="28"></a></td>
		</tr>
	';
}
echo '</table>';
//} //End of If Can Update
/*else
	{ // if person is not allowed to access page throw up a 404 error
	header("HTTP/1.0 404 Not Found");
	top();
	echo "<h1>Only Admin can view this page</h1>";
	exit;
	}*/
?>
<script language="javascript" type="text/javascript">
function confirmdelete(){
var c=confirm("Are you sure? Once Cancelled the action cannot be undone!");
if(c==false){
	window.location="view_requests.php?";
	}
else
{return false;}
}
</script>