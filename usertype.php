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

function submitusertype(param)
{
	var updatetype;
	if (param==1)
		updatetype = 'updateusertype';
	else if(param ==2)
		updatetype = 'addusertype';
	$.ajax({
		url: 'update.php',
		data: {updatetype : updatetype,Description:$("#description").val(),Type_ID:$("#usertypeid").val()},
		success:function(data){
			alert(data);
			location.reload();
		},
	});
}

function deleteusertype(data)
{
	var isOk = window.confirm("Are you sure?");

	if(isOk) {
	       
	
	$.ajax({
		url :'update.php',
		data : {updatetype:'delusertype', Description:data},
		success:function(result){
			location.reload();
		}
	});
	}
}

function addusertypeInformation()
{
	
	$("#addusertype").html("");
	$("#addusertype").append( '<form onSubmit = "submitusertype(2)"> '+
			'<label style = "width:30%">User Type Description</label>'+
			'<input type = "text" id = "description" style = "width:50%" required/><br>'+
			'<input type = "submit" value = "Submit" />'+
			'</form>'
			);

	
	$("#addusertype").hide();
	$("#addusertype").dialog({
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

function editInformation(usertypeid,department)
{
	//alert('Hi');
	console.log(department);
	
	$("#addusertype").html("");
	$("#addusertype").append( '<form onSubmit = "submitusertype(1)"> '+
			'<label style="width:30%">UserType ID</label>'+
			'<input type = "text" id = "usertypeid" value = '+usertypeid+' readonly/><br>'+
			'<label style="width:30%">Description</label>'+
			'<input type = "text" id = "description" value = "'+department+'" style = "width:50%" /><br>'+
			'<input type = "submit" value = "Submit" />'+
			'</form>'
			);
	
	$("#addusertype").hide();
	$("#addusertype").dialog({
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



<div id="banner" style="width:90%;float:left">Add/Change User Type Information</div>
<?php 
$query = "Select * from User_Types";
$result = mysql_query($query);
$nums = mysql_num_rows($result);
?>
<br><br>
	<div align="center">
		<table width="500" border="0" align="center">
		<TR>
			<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>&nbsp;USER TYPE&nbsp;</strong></TD>
			<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;EDIT&nbsp;</strong></TD>					
			<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;DELETE&nbsp;</strong></TD>					
		</TR>
		<?php
			for($i = 1; $i<=$nums;$i++)
			{
				
			$row = @mysql_fetch_array($result);

		echo '<tr>';
		echo '<INPUT TYPE="hidden" NAME="action" VALUE="del">';
		echo '<TD  NOWRAP valign="middle" ALIGN="left">'.$row["Description"].'&nbsp;</TD>';
		echo '<TD WIDTH="100"  ALIGN="center"><input type = "button" value = "Edit" onClick = "editInformation('.$row['Type_ID'].',\''.$row["Description"].'\')"></TD>';					
		echo '<TD WIDTH="100"  ALIGN="center"><input type = "button" onClick = "deleteusertype(\''.$row['Description'].'\')" value = "Delete"></TD>';
		echo '</tr>';
		
			} 
		?>
		<tr>
			<td align = "right"><input type = "button" onClick = "addusertypeInformation()" value ="Add New User Type"></td>
		</tr>
		</table>
	</div>

<div id = "addusertype" type = "hidden">

</div>

</body>
</html>