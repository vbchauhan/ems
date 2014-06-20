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

function submitinstitution(param)
{
	var updatetype;
	if (param==1)
		updatetype = 'updateinstitution';
	else if(param ==2)
		updatetype = 'addinstitution';
	$.ajax({
		url: 'update.php',
		data: {updatetype : updatetype,Institution_Name:$("#institution").val(),Institution_ID:$("#institutionid").val()},
		success:function(data){
			alert(data);
			location.reload();
		},
	});
}

function deleteinstitution(data)
{
	var isOk = window.confirm("Are you sure?");

	if(isOk) {
	       
	
	$.ajax({
		url :'update.php',
		data : {updatetype:'delinstitution', Institution_Name:data},
		success:function(result){
			location.reload();
		}
	});
	}
}

function addinstitutionInformation()
{
	
	$("#addinstitution").html("");
	$("#addinstitution").append( '<form onSubmit = "submitinstitution(2)"> '+
			'<label style = "width:30%">Institution Name</label>'+
			'<input type = "text" id = "institution" style = "width:50%" required/><br>'+
			'<input type = "submit" value = "Submit" />'+
			'</form>'
			);

	
	$("#addinstitution").hide();
	$("#addinstitution").dialog({
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

function editInformation(institutionid,institution)
{
	//alert('Hi');
	console.log(institution);
	
	$("#addinstitution").html("");
	$("#addinstitution").append( '<form onSubmit = "submitinstitution(1)"> '+
			'<label style="width:30%">Institution ID</label>'+
			'<input type = "text" id = "institutionid" value = '+institutionid+' readonly/><br>'+
			'<label style="width:30%">Institution</label>'+
			'<input type = "text" id = "institution" value = "'+institution+'" style = "width:50%" /><br>'+
			'<input type = "submit" value = "Submit" />'+
			'</form>'
			);
	
	$("#addinstitution").hide();
	$("#addinstitution").dialog({
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



<div id="banner" style="width:90%;float:left">Add/Change Institution Information</div>
<?php 
$query = "Select * from Institutions";
$result = mysql_query($query);
$nums = mysql_num_rows($result);
?>
<br><br>
	<div align="center">
		<table width="500" border="0" align="center">
		<TR>
			<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>&nbsp;INSTITUTION&nbsp;</strong></TD>
			<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;EDIT&nbsp;</strong></TD>					
			<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;DELETE&nbsp;</strong></TD>					
		</TR>
		<?php
			for($i = 1; $i<=$nums;$i++)
			{
				
			$row = @mysql_fetch_array($result);

		echo '<tr>';
		echo '<INPUT TYPE="hidden" NAME="action" VALUE="del">';
		echo '<TD  NOWRAP valign="middle" ALIGN="left">'.$row["Name"].'&nbsp;</TD>';
		echo '<TD WIDTH="100"  ALIGN="center"><input type = "button" value = "Edit" onClick = "editInformation('.$row['Institutions_ID'].',\''.$row["Name"].'\')"></TD>';					
		echo '<TD WIDTH="100"  ALIGN="center"><input type = "button" onClick = "deleteinstitution(\''.$row['Name'].'\')" value = "Delete"></TD>';
		echo '</tr>';
		
			} 
		?>
		<tr>
			<td align = "left"><input type = "button" onClick = "addinstitutionInformation()" value ="Add New Institution"></td>
		</tr>
		</table>
	</div>

<div id = "addinstitution" type = "hidden">

</div>

</body>
</html>