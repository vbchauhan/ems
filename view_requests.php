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
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    var $cells = $("td");

    $("#requestsearch").keyup(function() {
        var val = $.trim(this.value).toUpperCase();
        if (val === "")
            $cells.parent().show();
        else {
            $cells.parent().hide();
            $cells.filter(function() {
                return -1 != $(this).text().toUpperCase().indexOf(val);
            }).parent().show();
        }
    });
});
$('th').click(function(){
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){table.append(rows[i])}
})
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).html() }
</script>
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
?>
<div>
	<H1> iPad Requests </H1>
	<div style = "float:right">
	<label>Search</label>
	<input type = "search" id = "requestsearch" />
	</div><br><br>
</div>
<?php 
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

echo '<table id = "requestdata" align="center" cellspacing="0" cellpadding="5">
<tr class = "BackgroundColorChange">
	<th align="left"><a href="" class = "Textwhite"><b>User ID</b></a></th>				
	<th align="left"><a href="" class = "Textwhite"><b>First Name</b></a></th>
	<th align="left"><a href="" class = "Textwhite"><b>Last Name</a></b></a></th>
	<th align="left"><a href="" class = "Textwhite"><b>Barcode</b></a></th>
	<th align="left"><a href="" class = "Textwhite"><b>Email</b></a></th>
	<th align="left"><a href="" class = "Textwhite"><b>Phone</b></a></th>
	<th align="left"><a href="" class = "Textwhite"><b>User Type</b></a></th>
	<th align="left"><a href="" class = "Textwhite"><b>Institutions</b></a></th>
	<th align="left"><a href="" class = "Textwhite"><b>Department</b></a></th>
	<th align="left"><a href="" class = "Textwhite"><b>Request Date</b></a></th>
	<th align="left"><a href="" class = "Textwhite"><b>Item Type Requested</b></a></th>
	<th align="left"><a href="" class = "Textwhite"><b>No Of Items</b></a></th>
	<!--<th align="left"><b>Status</b></th>-->
	<th align="left"><b>Action</b></th>
	
</tr>';



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
		<td align="left">' . check_user_id($userRow['Aleph_ID']) . '</td>
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
		<td align="left"><a href="editRequest.php?id=' . $row['Request_ID'] . '" > <img src="images/edit-icon.png" width="28" height="28"></a></td>
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