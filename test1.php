<?php 
include ("global.php");
include ("layout.php");
include ("functions.php");


$query = "SELECT Request_ID,No_of_items,Request_Date,Users_ID,Item_Type_ID FROM request order by Request_ID ";
$result = mysql_query($query); // Run the query.
$data = download_aleph_data();
//echo $data[0]['Title'];
$sql = array();
foreach ($data as $datarow){
	$sql[] = '("'.$datarow['Title'].'","'.$datarow['Barcode'].'","'.$datarow['Callno'].'","'.$datarow['IS'].'","'.$datarow['Last_return'].'","'.$datarow['Loan'].'","'.$datarow['Due'].'","'.ltrim($datarow['User'],'0').'","'.$datarow['Status'].'","'.$datarow['Institution'].'")';
}
mysql_query('Truncate table aleph_data');
$abc = mysql_query('INSERT INTO aleph_data (Title, Barcode,Callno,IS_no,Last_return,Loan,Due,Aleph_ID,Status_id,Institution) VALUES '.implode(',', $sql));

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
		$queryUpdate = "Insert into loans (Loan_Date , Return_Date , Due_Date , Request_accept_date , Booking_date_from , Booking_date_to , Request_ID , Items_ID , Users_ID )	values ('".date('Y-m-d',strtotime($alephRow['Loan']))."','".date('Y-m-d',strtotime($alephRow['Due']))."','".date('Y-m-d',strtotime($alephRow['Due']))."','".$row['Request_Date']."','".date('Y-m-d',strtotime($alephRow['Loan']))."','".date('Y-m-d',strtotime($alephRow['Loan']))."','".$row['Request_ID']."','".$itemRow['Items_ID']."','".$userRow['Users_ID']."');";
		mysql_query($queryUpdate);
		echo "Success";
		}
		else 
			echo "Error";
	}	

}

?>