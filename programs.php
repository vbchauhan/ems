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

function submitprogram(param)
{
	var updatetype;
	if (param==1)
		updatetype = 'updateprogram';
	else if(param ==2)
		updatetype = 'addprogram';
	$.ajax({
		url: 'update.php',
		data: {updatetype : updatetype,Department_Name:$("#department").val(),Program_ID:$("#programid").val()},
		success:function(data){
			alert(data);
			location.reload();
		},
	});
}

function deleteprogram(data)
{
	var isOk = window.confirm("Are you sure?");

	if(isOk) {
	       
	
	$.ajax({
		url :'update.php',
		data : {updatetype:'delprogram', Department_Name:data},
		success:function(result){
			location.reload();
		}
	});
	}
}

function addprogramInformation()
{
	
	$("#addprogram").html("");
	$("#addprogram").append( '<form onSubmit = "submitprogram(2)"> '+
			'<label style = "width:30%">Program/Department Name</label>'+
			'<input type = "text" id = "department" style = "width:50%"/><br>'+
			'<input type = "submit" value = "Submit" />'+
			'</form>'
			);

	
	$("#addprogram").hide();
	$("#addprogram").dialog({
		resizable: true,
		modal: true,
		width:800,
		height:400,
		buttons: {
		Ok: function() {
		$(this).dialog('close');
		} //end OK button
		}//end buttons

		});//end dialog
	
}

function editInformation(programid,department)
{
	//alert('Hi');
	console.log(department);
	
	$("#addprogram").html("");
	$("#addprogram").append( '<form onSubmit = "submitprogram(1)"> '+
			'<label style="width:30%">Program/Department ID</label>'+
			'<input type = "text" id = "programid" value = '+programid+' readonly/><br>'+
			'<label style="width:30%">Department</label>'+
			'<input type = "text" id = "department" value = "'+department+'" style = "width:50%" /><br>'+
			'<input type = "submit" value = "Submit" />'+
			'</form>'
			);
	
	$("#addprogram").hide();
	$("#addprogram").dialog({
		resizable: true,
		modal: true,
		width:800,
		height:400,
		buttons: {
		Ok: function() {
		$(this).dialog('close');
		location.reload();
		} //end OK button
		}//end buttons
		
		});//end dialog
	
	
}
</script>
</head>
<body>



<div id="banner" style="width:90%;float:left">Add/Change Program/Department Information</div>
<?php 
$query = "Select * from Programs_Department";
$result = mysql_query($query);
$nums = mysql_num_rows($result);
?>
<br><br>
	<div align="center">
		<table width="500" border="0" align="center">
		<TR>
			<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>&nbsp;PROGRAMS/DEPARTMENT&nbsp;</strong></TD>
			<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;EDIT&nbsp;</strong></TD>					
			<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;DELETE&nbsp;</strong></TD>					
		</TR>
		<?php
			for($i = 1; $i<=$nums;$i++)
			{
				
			$row = @mysql_fetch_array($result);

		echo '<tr>';
		echo '<INPUT TYPE="hidden" NAME="action" VALUE="del">';
		echo '<TD  NOWRAP valign="middle" ALIGN="left">'.$row["Department_Name"].'&nbsp;</TD>';
		echo '<TD WIDTH="100"  ALIGN="center"><input type = "button" value = "Edit" onClick = "editInformation('.$row['Programs_Department_ID'].',\''.$row["Department_Name"].'\')"></TD>';					
		echo '<TD WIDTH="100"  ALIGN="center"><input type = "button" onClick = "deleteprogram(\''.$row['Department_Name'].'\')" value = "Delete"></TD>';
		echo '</tr>';
		
			} 
		?>
		<tr>
			<td align = "right"><input type = "button" onClick = "addprogramInformation()" value ="Add New Program/Department"></td>
		</tr>
		</table>
	</div>

<div id = "addprogram" type = "hidden">

</div>

</body>
</html>