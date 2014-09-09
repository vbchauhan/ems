<?php
// include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
include ("global.php");
if (isset ( $_GET ['id'] )) {
	$requestID = $_GET ['id'];
}
$query = "select * from request where Request_ID=$requestID";
$result = mysql_query ( $query );
$row = mysql_fetch_array ( $result, MYSQL_ASSOC );
$query_users = "SELECT * FROM users where Users_ID =" . $row ['Users_ID'];
$userResult = mysql_query ( $query_users ); // Run the query.
$userRow = mysql_fetch_array ( $userResult, MYSQL_ASSOC );
?>
<head>
<link href="css/main.css"
	rel="stylesheet" media="screen">
<link rel="shortcut icon"
	href="favicon.ico"
	type="image/x-icon">
<title>Priddy Loan System</title>
<script>
function validateForm()
{
var a=document.forms["registration"]["fname"].value;
var b=document.forms["registration"]["lname"].value;
var c=document.forms["registration"]["barcode"].value;
var d=document.forms["registration"]["email"].value;
var e=document.forms["registration"]["pno"].value;
var f=document.forms["registration"]["items"].value;


if (a==null || a=="" || b==null || b=="" || c==null || c=="" || d==null || d=="")
  {
  alert("None of the text boxes can be empty");
  return false;
  }
/*A function call to ValidateSelect and checking if the function returns in false.*/
  if(validateSelect()==false)
  {return false;}
/*A function Call to FileCheck and checking if user wants to continue without selecting a upload*/  
  if(filecheck()==false)
  {return false;}
}

</script>
</head>
<div id="banner" "style:width="90%"";>EQUIPMENT MANAGEMENT SYSTEM</div>
<div id="topnavi">
    		<?PHP
						
if (@$_SESSION ["AUTH_USER"] == true)
							print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/logout.php">LOGOFF</a>';
						else {
							$LoginSelectStr = '';
							if ($CurrentRequestURLarr [2] == "login")
								$LoginSelectStr = ' class="selected"';
							print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/login.php"' . $LoginSelectStr . '>Staff LOGIN</a>';
						}
						?>
		

</div>
</div>

<h1>Edit the Ipad Request Information</h1>
<form name="registration" action="editRequestConf.php" method="post"
	onsubmit="return validateForm(this)">
	<table border="1">
		<tr>
			<td><label for='fname'><b>Barcode:</b></label></td>
			<td><input type='text' name='barcode' id='barcode'
				value=<?php echo $userRow["Barcode_ID"] ?> maxlength="50"
				style="width: 98%" readonly/></td>
		</tr>
		<tr>
			<td><label for='Last Name'><b>Patron ID:</b></label></td>
			<td><input type='text' name='alephid' id='alephid' 	value="<?php echo $userRow["Aleph_ID"] ?>" maxlength="50" required placeHolder = "Get System ID from Aleph"
				style="width: 98%" /></td>
		</tr>
		<tr>
			<td><label for='Last Name'><b>First Name:</b></label></td>
			<td><input type='text' name='fname' id='fname'
				value= "<?php echo $userRow["First_Name"] ?>" maxlength="50"
				style="width: 98%" readonly/></td>
		</tr>
		<tr>
			<td><label for='barcode'><b>Last Name:</b></label></td>
			<td><input type='text' name='lname' id='lname'
				value= "<?php echo $userRow["Last_Name"] ?>" maxlength="50"
				style="width: 98%" readonly/></td>
		</tr>
		<tr>
			<td><label for='Email'><b>Email:</b></label></td>
			<td><input type='text' name='email' id='email'
				value= "<?php echo $userRow["Email"] ?>" maxlength="50"
				style="width: 98%" readonly/></td>
		</tr>
		<tr>
			<td><label for='Email'><b>Phone Number:</b></label></td>
			<td><input type='text' name='pno' id='pno'
				value= "<?php echo $userRow["Phone_Number"] ?>" maxlength="50"
				style="width: 98%" readonly/></td>
		</tr>
		<tr>
			<td><label for='User Type:'><b> User Type:</b></label></td>
			<td><select name="utype" style="width: 99%">
				<?php
				// Build the query
				$utypequery = "SELECT * FROM user_types ORDER BY Description ASC";
				$utyperesult = mysql_query ( $utypequery );
				while ( $utyperow = mysql_fetch_array ( $utyperesult, MYSQL_ASSOC ) ) {
					if ($userRow ['Type_ID'] == $utyperow ['Type_ID']) {
						echo '<option value="' . $utyperow ['Description'] . '" disabled="disabled">' . $utyperow ['Description'] . '</option>';
					} else {
						echo '<option value="' . $utyperow ['Description'] . '">' . $utyperow ['Description'];
					}
				}
				?>
				</select></td>
		</tr>
		<tr>
			<td><label for='Institution'><b>Institution:</b></label></td>
			<td><select name="institution">
				<?php
				// Build the query
				$ins = "SELECT * FROM institutions ORDER BY name ASC";
				$insresult = mysql_query ( $ins );
				while ( $insrow = mysql_fetch_array ( $insresult, MYSQL_ASSOC ) ) {
					if ($userRow ['Institutions_ID'] == $insrow ['Institutions_ID']) {
						echo '<option value="' . $insrow ['Name'] . '" disabled="disabled">' . $insrow ['Name'] . '</option>';
					} else {
						echo '<option value="' . $insrow ['Name'] . '">' . $insrow ['Name'];
					}
				}
				?>
				</select></td>
		</tr>
		<tr>
		
		
		<tr>

			<td><label for='department'><b>Department:</b></label></td>
			<td><select name="department">
				<?php
				// Build the query
				$ins = "SELECT * FROM programs_department ORDER BY Department_Name ASC";
				$insresult = mysql_query ( $ins );
				while ( $progrow = mysql_fetch_array ( $insresult, MYSQL_ASSOC ) ) {
					if ($userRow ['Programs_Department_ID'] == $progrow ['Programs_Department_ID']) {
						echo '<option value="' . $progrow ['Department_Name'] . '" disabled="disabled">' . $progrow ['Department_Name'] . '</option>';
					} else {
						echo '<option value="' . $progrow ['Department_Name'] . '">' . $progrow ['Department_Name'];
					}
				}
				?>
				</select> <input type='hidden' name='request' value=<?php echo $requestID;?>></td>
				</select> <input type='hidden' name='userid' value=<?php echo $row["Users_ID"];?>></td>
		</tr>
		<tr>
			<td><label for='Date needed'><b>Date needed:</b></label></td>
			<td><input type='text' name='request_date' id='request_date'
				value=<?php echo $row["Request_Date"] ?> maxlength="50"
				style="width: 98%" /></td>
		</tr>
		
			<td><label for='itemtype'><b>Item Type:</b></label></td>
			<td><select name="itemtype">
				<?php
				// Build the query
				$itemtype = "SELECT * FROM item_type ORDER BY Description ASC";
				$itemresult = mysql_query ( $itemtype );
				while ( $typerow = mysql_fetch_array ( $itemresult, MYSQL_ASSOC ) ) {
					if ($userRow ['Item_Type_ID'] == $typerow ['Item_Type_ID']) {
						echo '<option value="' . $typerow ['Description'] . '" selected="selected">' . $typerow ['Description'] . '</option>';
					} else {
						echo '<option value="' . $typerow ['Description'] . '">' . $typerow ['Description'];
					}
				}
				?>
				</select> <input type='hidden' name='request'
				value=<?php echo $requestID;?>></td>
		</tr>
		<tr>
			<td><label for='No of items:'><b> No. of Items :</b></label></td>
			<td><input type='text' name='items' id='items' maxlength="50"
				value=<?php echo $row["No_of_items"] ?> style="width: 98%" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type='submit'
				value='Submit Request' /></td>
		</tr>
	</table>
</form>