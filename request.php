<?php 
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
//$dbok = mysql_connect('localhost', 'madhus', 'ijfsdIfd93ru');
//$db_selected = mysql_select_db('equipment', $dbok);
//$_SESSION["SystemNameStr"]='EQUIPMENT';
if(isset($_GET["barcode"]) ){

	$barcode =$_GET["barcode"];
	$userQuery = "Select * from users where barcode_id = '$barcode'";
	$userResult = mysql_query ($userQuery);
	$userNum = mysql_num_rows($userResult);
	//echo $userQuery;
	if($userNum >= 1)
	{
		$userRow = mysql_fetch_array($userResult, MYSQL_ASSOC);

		$result = $userRow['First_Name'].'||'.$userRow['Last_Name'].'||'.$userRow['Email'].'||'.$userRow['Phone_Number'].'||'.get_user_type_desc($userRow['Type_ID']).'||'.get_programs_name($userRow['Programs_Department_ID']).'||'.get_institution_name($userRow['Institutions_ID']);
		header('Content-type: application/json');
		echo json_encode($result);

	}
	else
	echo "User Not Found. Go ahead and fill the data to create a new user. This will also create a new request.";
}
?>
<head>
<link href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<title>Priddy Loan System</title>
<script>

function getUserInfo(){
	var barcode = document.getElementById('barcode').value;
	if( barcode == null || barcode == "")
	alert("Please enter the barcode number found behind you ID");
	else
	{
		$.ajax({
			  url: 'request.php?barcode='+barcode,
			  async: false,
			  dataType: 'json',
			  success : function (data) {
				alert('data');
				console.log(data);
			      },
	      	  error : function(json){
	      		console.log(json);
		      	  var x = json.responseText.split("<");
		      	  if(x[0].indexOf('||')>-1)
		      	  {
		      	  var y = x[0].split("||");
		      	  console.log(y);
		      	  var fname = y[0].split("\"");
		      	  var lname = y[3].split("\"");
		      	  var user = y[4].split("\"");
		      	  var program = y[5].split("\"");
		      	  var inst = y[6].split("\"");
		      	  $("#fname").val(fname[1]);
		      	  $("#lname").val(y[1]);
		      	  $("#email").val(y[2]);
		      	  $("#pno").val(lname[0]);
		      	  $("#utype").val(user[0]);
		      	  $("#institution").val(inst[0]);
		      	  $("#programname").val(program[0]);
		      	  }
		      	  else
		      	  {
			      	  $("#NoUserFound").html(x[0]);
		      	  }
	      	  }
			    
			});
		return false;
	}
}
function validateForm()
{
var a=document.forms["registration"]["fname"].value;
var b=document.forms["registration"]["lname"].value;
var c=document.forms["registration"]["barcode"].value;
var d=document.forms["registration"]["email"].value;
var e=document.forms["registration"]["pno"].value;
var f=document.forms["registration"]["ipads"].value;


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
    		<?PHP if (@$_SESSION["AUTH_USER"]==true) 
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/login/logout.php">LOGOFF</a>';
					else
						{
						$LoginSelectStr='';
						if ($CurrentRequestURLarr[2]=="login") $LoginSelectStr=' class="selected"';
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/login.php"'.$LoginSelectStr.'>Staff LOGIN</a>'; 
						}?>
			<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>"<?php if ($CurrentRequestURLarr[2]=="") print ' class="selected"'?>></a>
            
	</div>	
</div>	
<h1>Equipment Request Form</h1>
<label id="NoUserFound" style = "width :100%"></label><br>
<input type='button' name='getuserinfo' id = 'getuserinfo' onClick = "getUserInfo()" value = "Get Information"/>
<form name="registration" action="sendRequest.php" method="post" onsubmit="return validateForm(this)">
	<table border="1">
		<tr>
			<td><label for='barcode' ><b>Barcode:</b></label></td>
			<td><input type='number' name='barcode' id='barcode' max="99999999999999" style="width:98%"/ required placeholder="Barcode Number"></td>
			
		</tr>
		<tr>
		
			<td colspan="2" style ="font-size :0.8em">
				<b>Click <a target="_blank" style = "color: blue;text-decoration : underline" href = "http://shadygrove.umd.edu/library/services/find-lib-barcode">Here</a> to find your Library Barcode Number</b>
			</td>
		</tr>
		<tr>
			<td><label for='fname' ><b>First Name:</b></label></td>
			<td><input type='text' name='fname' id='fname' maxlength="50" style="width:98%" required placeholder="First Name"/></td>
		</tr>
		<tr>
			<td><label for='Last Name' ><b>Last Name:</b></label></td>
			<td><input type='text' name='lname' id='lname' maxlength="50" style="width:98%"/ required placeholder="Last Name"></td>
		</tr>
		<tr>
			<td><label for='Email' ><b>Email:</b></label></td>
			<td><input type='text' name='email' id='email' maxlength="50" style="width:98%"/ required placeholder="Enter a valid email address"></td>
		</tr>
		<tr>
			<td><label for='phone' ><b>Phone Number:</b></label></td>
			<td><input type='number' name='pno' id='pno' maxlength="10" style="width:98%"/ placeholder="Enter a valid phone number"></td>
		</tr>
		<tr>
			<td>
				<label for='User Type:' ><b> User Type:</b></label></td>
			<td>
				<select name="utype" id = "utype">
				<?php 
				// Build the query
				$query = "SELECT description FROM user_types ORDER BY description ASC";
				$result = mysql_query ($query);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				echo'<option value="'.$row['description'].'">'.$row['description'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for='Institution' ><b>Institution:</b></label></td>
			<td>	
				<select name="institution" id = "institution">
				<?php 
	// Build the query
				$query = "SELECT name FROM institutions ORDER BY name ASC";
				$result = mysql_query ($query);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				echo '<option value="'.$row['name'].'" selected="selected">'.$row['name'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
		<tr>
			<td><label for='programname' ><b>Program:</b></label></td>
			<td>	
				<select name="programname" id = "programname">
				<?php 
	// Build the query
				$query = "SELECT department_name FROM programs_department ORDER BY department_name ASC";
				$result = mysql_query ($query);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				echo '<option value="'.$row['department_name'].'" selected="selected">'.$row['department_name'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for='Date needed' ><b>Date needed:</b></label></td>
			<td><input type='date' name='request_date' id='request_date' value = "<?php echo date('Y-m-d'); ?>" maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td><label for='itemtype' ><b>Item Type:</b></label></td>
			<td>	
				<select name="itemtype">
				<?php 
	// Build the query
				$query = "SELECT description FROM item_type ORDER BY description ASC";
				$result = mysql_query ($query);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				echo '<option value="'.$row['description'].'" selected="selected">'.$row['description'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for='No of Items:' ><b> No. of Items :</b></label></td>
			<td><input type='number' name='items' id='items' max="25" style="width:98%"/ value = "1" required placeholder="Quantity"></td>
		</tr>
		<tr>
		
			<td colspan="2" style ="font-size :0.8em">
				<input type='checkbox' id ="agreecheck" required/><b>I agree to the Equipment Loan <a style = "color: blue;text-decoration : underline" href = "termsandcondition.php">Terms and Conditions</b></a>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type='submit' value='Submit Request'/>
			</td>
			
		</tr>
	</table>
	
	</form>