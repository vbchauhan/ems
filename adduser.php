<?php
include ("global.php");
include ("layout.php");
include ("functions.php");
top(); 
?>
<!DOCTYPE html>
<head>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js"></script>
<link href="/<?=strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link href="/<?=strtolower($_SESSION["SystemNameStr"])?>/css/jquery-ui-1.10.4.custom.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?=strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<title>Priddy Loan System</title>
<script language="javascript" type="text/javascript">
// Submit user information and store it in database
function submituser(param)
{
	if (param==1 && $("#newpassword").val()==$("#confirmnewpassword").val())
		{
			$.ajax({
				url: 'update.php',
				data: {updatetype : 'updateuser',username:$("#username").val(),oldpassword:$("#oldpassword").val(),newpassword:$("#newpassword").val(),confirmnewpassword:$("#confirmnewpassword").val(),password:document.getElementById("password").value},
				success:function(data){
					alert(data);
					location.reload();
				},
			});
			
		}
	else if(param ==2 && $("#newpassword").val()==$("#confirmnewpassword").val())
	{
		
		$.ajax({
			url: 'update.php',
			data: {updatetype : 'adduser',username:$("#username").val(),newpassword:$("#newpassword").val()},
			success:function(data){
				alert(data);
				location.reload();
			},
		});
	}
	else{
		alert("New Password and Confirm Password does not match.");
	}
}
// Delete user information from database
function deleteuser(data)
{
	var isOk = window.confirm("Are you sure?");

	if(isOk && document.getElementById("users").rows.length > 3) {
	       
	
	$.ajax({
		url :'update.php',
		data : {updatetype:'deluser', username:data},
		success:function(result){
			location.reload();
		}
	});
	}
	else{
		alert("Cannot delete the user " + data +". Atleast one user is required.");
	}
}
// Add new user information in the dialog box
function addUserInformation()
{
	
	$("#adduser").html("");
	$("#adduser").append( '<form onSubmit = "submituser(2)"> '+
			'<label style="width:30%">Username</label>'+
			'<input type = "text" id = "username" required/><br>'+
			'<label style="width:30%">Password</label>'+
			'<input type = "password" id = "newpassword" style = "width:50%" required/><br>'+
			'<label style="width:30%">Confirm Password</label>'+
			'<input type = "password" id = "confirmnewpassword" style = "width:50%" required/><br>'+
			'<input type = "submit" value = "Submit" />'+
			'</form>'
			);

	
	$("#adduser").hide();
	$("#adduser").dialog({
		resizable: true,
		modal: true,
		width:800,
		height:400,
		buttons: {
		Close: function() {
		$(this).dialog('close');
		} //end OK button
		}//end buttons

		});//end dialog
	
}
// Edit current user information
function editInformation(username,password)
{

	
	
	$("#adduser").html("");
	$("#adduser").append( '<form onSubmit = "submituser(1)"> '+
			'<label style="width:30%">Username</label>'+
			'<input type = "text" id = "username" value = '+username+' readonly/><br>'+
			'<label style="width:30%">Old Password</label>'+
			'<input type = "password" id = "oldpassword" style = "width:50%" required/><br>'+
			'<label style="width:30%">New Password</label>'+
			'<input type = "password" id = "newpassword" style = "width:50%" required/><br>'+
			'<label style="width:30%">Confirm Password</label>'+
			'<input type = "password" id = "confirmnewpassword" style = "width:50%" required/><br>'+
			'<input type = "submit" value = "Submit" />'+
			'<input type = "hidden" value = "'+password+'" id="password">'+
			'</form>'
			);
	
	$("#adduser").hide();
	$("#adduser").dialog({
		resizable: true,
		modal: true,
		width:800,
		height:400,
		buttons: {
		Close: function() {
		$(this).dialog('close');
		location.reload();
		} //end OK button
		}//end buttons
		
		});//end dialog
	
	
}
</script>
</head>
<body>



<div id="banner" style="width:90%;float:left">Add/Change User Information</div>
<?php 
$query = "Select * from login";
$result = mysql_query($query);
$nums = mysql_num_rows($result);
?>
<br><br>
	<div align="center">
		<table width="500" border="0" align="center" id = "users">
		<TR>
			<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>&nbsp;Users&nbsp;</strong></TD>
			<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;EDIT&nbsp;</strong></TD>					
			<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;DELETE&nbsp;</strong></TD>					
		</TR>
		<?php
			for($i = 1; $i<=$nums;$i++)
			{
				
			$row = @mysql_fetch_array($result);

		echo '<tr>';
		echo '<INPUT TYPE="hidden" NAME="action" VALUE="del">';
		echo '<TD  NOWRAP valign="middle" ALIGN="left">'.$row["username"].'&nbsp;</TD>';
		echo '<TD WIDTH="100"  ALIGN="center"><input type = "button" value = "Change Password" onClick = "editInformation(\''.$row['username'].'\',\''.$row["password"].'\')"></TD>';					
		echo '<TD WIDTH="100"  ALIGN="center"><input type = "button" onClick = "deleteuser(\''.$row['username'].'\')" value = "Delete"></TD>';
		echo '</tr>';
		
			} 
		?>
		<tr>
			<td align = "right"><input type = "button" onClick = "addUserInformation()" value ="Add New User"></td>
		</tr>
		</table>
	</div>

<div id = "adduser" type = "hidden">

</div>

</body>
</html>