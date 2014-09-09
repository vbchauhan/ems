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
<link href="css/main.css" rel="stylesheet" media="screen">
<link href="css/jquery-ui-1.10.4.custom.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<title>Priddy Loan System</title>
<script language="javascript" type="text/javascript">

function submititemtype(param)
{
	var updatetype;
	if (param==1)
		updatetype = 'updateitemtype';
	else if(param ==2)
		updatetype = 'additemtype';
	$.ajax({
		url: 'update.php',
		data: {updatetype : updatetype,Description:$("#description").val(),Item_Type_ID:$("#itemtypeid").val()},
		success:function(data){
			location.reload();
		},
	});
}

function deleteitemtype(data)
{
	var isOk = window.confirm("Are you sure?");

	if(isOk) {
	       
	
	$.ajax({
		url :'update.php',
		data : {updatetype:'delitemtype', Description:data},
		success:function(result){
			location.reload();
		}
	});
	}
}

function additemtypeInformation()
{
	
	$("#additemtype").html("");
	$("#additemtype").append( '<form onSubmit = "submititemtype(2)"> '+
			'<label style = "width:30%">Item Description</label>'+
			'<input type = "text" id = "description" style = "width:50%" required/><br>'+
			'<input type = "submit" value = "Submit" />'+
			'</form>'
			);

	
	$("#additemtype").hide();
	$("#additemtype").dialog({
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

function editInformation(itemtypeid,description)
{
	//alert('Hi');
	
	$("#additemtype").html("");
	$("#additemtype").append( '<form onSubmit = "submititemtype(1)"> '+
			'<label style="width:30%">Item Type ID</label>'+
			'<input type = "text" id = "itemtypeid" value = '+itemtypeid+' readonly/><br>'+
			'<label style="width:30%">Description</label>'+
			'<input type = "text" id = "description" value = "'+description+'" style = "width:50%" /><br>'+
			'<input type = "submit" value = "Submit" />'+
			'</form>'
			);
	
	$("#additemtype").hide();
	$("#additemtype").dialog({
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

<H1><strong>Add/Change Item Type Information</strong></H1>

<?php 
$query = "Select * from item_type";
$result = mysql_query($query);
$nums = mysql_num_rows($result);
?>
<br><br>
	<div align="center">
		<table width="500" border="0" align="center">
		<TR>
			<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>&nbsp;ITEM TYPE&nbsp;</strong></TD>
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
		echo '<TD WIDTH="100"  ALIGN="center"><input type = "button" value = "Edit" onClick = "editInformation('.$row['Item_Type_ID'].',\''.$row["Description"].'\')"></TD>';					
		echo '<TD WIDTH="100"  ALIGN="center"><input type = "button" onClick = "deleteitemtype(\''.$row['Description'].'\')" value = "Delete"></TD>';
		echo '</tr>';
		
			} 
		?>
		<tr>
			<td align = "left"><input type = "button" onClick = "additemtypeInformation()" value ="Add New Item Type"></td>
		</tr>
		</table>
	</div>

<div id = "additemtype" type = "hidden">

</div>

</body>
</html>