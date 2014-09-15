<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");

?>
<head>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js"></script>
<link href="css/main.css" rel="stylesheet" media="screen">
<link href="css/jquery-ui-1.10.4.custom.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<title>Priddy Loan System</title>
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

function getDetails(data){


var rowData = data.split('||');
console.log(rowData);
                           	
$("#datatable").append("<tr class = 'BackgroundColorChange'><th>Description</th><th>Barcode</th><th>Loan Date</th><th>Return Date</th><th>Due Date</th><th>Request Date</th></tr>");                            
var bg = '#ffffff';

for(var i =0;i<rowData.length;i++)
	{
		if(rowData[i])
		{
		var splitRow = rowData[i].split(',');
		if (bg == '#eeeeee')
			bg = '#ffffff';
		else
			bg = '#eeeeee';

		$("#datatable").append(
		 "<tr bgcolor='"+ bg+"' class = 'tablecontent' style = 'color:black'>"+
		 "<td align='left'>"+splitRow[0]+"</td>"+
		 "<td align='left'>"+splitRow[1]+"</td>"+
		 "<td align='left'>"+splitRow[2]+"</td>"+
		 "<td align='left'>"+splitRow[3]+"</td>"+
		 "<td align='left'>"+splitRow[4]+"</td>"+
		 "<td align='left'>"+splitRow[5]+"</td>"+
		 "</tr>"

			);
		}
	}

$("#dialog").hide();
$("#dialog").dialog({
	resizable: true,
	modal: true,
	width:800,
	height:400,
	buttons: {
	Ok: function() {
	$(this).dialog('close');
	} //end cancel button
	}//end buttons

	});//end dialog
console.log(data);
}
</script>
</head>

<body style = "margin-left:10px;margin-right:10px">
<div id="banner" style="width:90%;margin-left:0px">EQUIPMENT MANAGEMENT SYSTEM</div>
	<div id="topnavi">
	<div id="topnavi">
			<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>"<?php if ($CurrentRequestURLarr[2]=="") print ' class="selected"'?>>Home</a>
 			<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/view_requests.php"<?php if ($CurrentRequestURLarr[2]=="webadmin") print ' class="selected"'?>>View Requests</a> 
			
			<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/reserved.php?refresh=1"<?php ?>>Refresh</a>
			    		<?PHP 
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
<div>
	<H1> View Reservations </H1>
	<div style = "float:right">
	<label>Search</label>
	<input type = "search" id = "requestsearch" />
	</div><br><br>
</div>

<?php
if ($_GET['refresh'] == 1)
	refresh();

$query = "select Loan_Date, count(Items_ID) as Total_Items, Request_ID, Users_ID from loans where Loan_Date >= now()-interval 3 month group by Request_ID";
$result = mysql_query($query); // Run the query.
echo '<table cellpadding="0" cellspacing="0" class="db-table"> <tr>';

echo '<table align="center" cellspacing="0" cellpadding="5">
<tr class = "BackgroundColorChange">
	<th align="left"><b>First Name</b></th>
	<th align="left"><b>Last Name</a></b></th>
	<th align="left"><b>Barcode</b></th>
	<th align="left"><b>Email</b></th>
	<th align="left"><b>Phone</b></th>
	<th align="left"><b>User Type</b></th>
	<th align="left"><b>Institutions</b></th>
	<th align="left"><b>Department</b></th>
	<th align="left"><b>Request Date</b></th>
	<th align="left"><b>#iPad_Requested</b></th>
	<th align="left"><b>Action</b></th>
	
</tr>';

// Fetch and print all the records.
$bg = '#eeeeee'; // Set the background color.
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

	$queryUser = "Select * from users where Users_ID ='".$row['Users_ID']."'";
	$userResult = mysql_query($queryUser);
	$userRow = mysql_fetch_array($userResult, MYSQL_ASSOC);
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
	echo '<tr bgcolor="' . $bg . '"class = "tablecontent">
		<td align="left">' . $userRow['First_Name']. '</td>
		<td align="left">' . $userRow['Last_Name']. '</td>
		<td align="left" style = "text-align:center">' . $userRow['Barcode_ID']. '</td>
		<td align="left">' . $userRow['Email']. '</td>
		<td align="left" style = "text-align:center">' . $userRow['Phone_Number'] . '</td>
		<td align="left" style = "text-align:center">' . get_user_type_desc($userRow['Type_ID']). '</td>
		<td align="left" style = "text-align:center">' . get_institution_name($userRow['Institutions_ID']) . '</td>
		<td align="left">' . get_programs_name($userRow['Programs_Department_ID']) . '</td>
		<td align="left" style = "text-align:center">' . $row['Loan_Date'] . '</td>
		<td align="left" style = "text-align:center"><b>' . $row['Total_Items'] . '</b></td>
		<td align="left"><a href="reserved.php?data=' . $row['Request_ID'] . '">Details</td>
		</tr>
	';
}
echo '</table>';
?>
<div id ="dialog" ><table id = "datatable" align='center' style = 'background-color :#564b47; color : white' cellspacing='0' cellpadding='5' class='db-table'></table></div>
<?php 
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$query = "delete from request WHERE requestID=$id";
	mysql_query($query);
	}
if(isset($_GET["data"]))
	{
		$data = '';
		$result = mysql_query("Select * from loans where Request_ID = ".$_GET["data"]);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
		$itemQuery = "Select * from items where Items_ID = ".$row['Items_ID'];
		$itemResult = mysql_query($itemQuery);
		$itemRow = mysql_fetch_array($itemResult, MYSQL_ASSOC);
		$data = $data.$itemRow['Description'].','.$itemRow['Barcode'].','.$row['Loan_Date'].','.$row['Return_Date'].','.$row['Due_Date'].','.$row['Request_accept_date'].'||';
		}
		//echo $data;
		echo '<script type="text/javascript">getDetails("'.$data.'");</script>';
	}

?>
</body>
