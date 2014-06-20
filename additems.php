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

function submititem(param)
{
	var updatetype;
	if (param==1)
		updatetype = 'updateitem';
	else if(param ==2)
		updatetype = 'additem';
	$.ajax({
		url: 'update.php',
		data: {updatetype : updatetype,Description:$("#description").val(),Serial_number:$("#serial").val(),Barcode:$("#barcode").val(),Item_Type_ID:$("#typedesc").val()},
		success:function(data){
			location.reload();
			alert(data);
		},
	});
}

function deleteitem(data)
{

	var isOk = window.confirm("Are you sure?");

	if(isOk) {
	       
	
	$.ajax({
		url :'update.php',
		
		data : {updatetype:'delitem', Barcode:data},
		success:function(result){
			location.reload();
			alert(result);
			
		}
	});
	}
}

function addItemInformation()
{
	
	$("#additem").html("");
	$("#additem").append( '<form onSubmit = "submititem(2)"> '+
			'<label>Barcode</label>'+
			'<input type = "number" id = "barcode" required/><br>'+
			'<label>Serial Number</label><input type = "number" id = "serial" length = 20 required/><br>'+
			'<label>Description</label><input type = "text" id = "description" required/><br>'+
			'<label>Item Type</label><select id = "typedesc"></select><br>'+
			'<input type = "submit" value = "Submit" />'+
			'</form>'
			);
	<?php
	$descQuery = 'Select * from Item_Type';
	$result = mysql_query($descQuery);
	while($row = mysql_fetch_array($result)){
	echo '$("#typedesc").append("<option value='.$row['Item_Type_ID'].'>'.$row['Description'].'</option>")';
	} 
	?>
	
	$("#additem").hide();
	$("#additem").dialog({
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

function editInformation(barcode,serial,description,type)
{
	
	console.log(description);
	
	$("#additem").html("");
	$("#additem").append( '<form onSubmit = "submititem(1)"> '+
			'<label>Barcode</label>'+
			'<input type = "text" id = "barcode" value = '+barcode+' readonly/><br>'+
			'<label>Serial Number</label><input type = "number" id = "serial" value = '+serial+' length = 20/><br>'+
			'<label>Description</label><input type = "text" id = "description" value = "'+description+'" /><br>'+
			'<label>Item Type</label><select id = "typedesc"></select><br>'+
			'<input type = "submit" value = "Submit" />'+
			'</form>'
			);
	<?php
	$descQuery = 'Select * from Item_Type';
	$result = mysql_query($descQuery);
	while($row = mysql_fetch_array($result)){
	echo '$("#typedesc").append("<option value='.$row['Item_Type_ID'].'>'.$row['Description'].'</option>")';
	} 
	?>
	
	$("#additem").hide();
	$("#additem").dialog({
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



<div id="banner" style="width:90%;float:left">Add/Change Item Information</div>
<?php 
$query = "Select * from Items";
$result = mysql_query($query);
$nums = mysql_num_rows($result);
?>
<br><br>
	<div align="center">
		<table width="500" border="0" align="center">
		<tr>
			<td align = "right"><input type = "button" onClick = "addItemInformation()" value ="Add New item"></td>
		</tr>
		<TR>
			<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>&nbsp;Item Barcode&nbsp;</strong></TD>
			<TD WIDTH="150" class="tableheading" ALIGN="left"><strong>&nbsp;Short Description&nbsp;</strong></TD>
			<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;Serial Number&nbsp;</strong></TD>
			<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;Item Type&nbsp;</strong></TD>
			<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;EDIT&nbsp;</strong></TD>					
			<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;DELETE&nbsp;</strong></TD>					
		</TR>
		<?php
			for($i = 1; $i<=$nums;$i++)
			{
				
			$row = @mysql_fetch_array($result);

		echo '<tr>';
		echo '<INPUT TYPE="hidden" NAME="action" VALUE="del">';
		echo '<TD  NOWRAP valign="middle" ALIGN="left">'.$row["Barcode"].'&nbsp;</TD>';
		echo '<TD  NOWRAP valign="middle" ALIGN="left">'.$row["Description"].'&nbsp;</TD>';
		echo '<TD  NOWRAP valign="middle" ALIGN="left">'.$row["Serial_number"].'&nbsp;</TD>';
		echo '<TD  NOWRAP valign="middle" ALIGN="left">'.get_item_type_desc($row["Item_Type_ID"]).'&nbsp;</TD>';
		echo '<TD WIDTH="100"  ALIGN="center"><input type = "button" value = "Edit" onClick = "editInformation('.$row['Barcode'].','.$row['Serial_number'].',\''.$row["Description"].'\',\''.get_item_type_desc($row["Item_Type_ID"]).'\')"></TD>';					
		echo '<TD WIDTH="100"  ALIGN="center"><input type = "button" onClick = "deleteitem('.$row['Barcode'].')" value = "Delete"></TD>';
		echo '</tr>';
		
			} 
		?>
		<tr>
			<td align = "right"><input type = "button" onClick = "addItemInformation()" value ="Add New item"></td>
		</tr>
		</table>
	</div>

<div id = "additem" type = "hidden">

</div>

</body>
</html>