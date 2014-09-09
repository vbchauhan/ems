<?php
include ("global.php");
include ("layout.php");
include ("functions.php");

if($_GET['updatetype'] == 'updateitem')
{
	$query = "Update items SET Description ='".$_GET['Description']."',Serial_number='".$_GET['Serial_number']."',Item_Type_ID=".$_GET['Item_Type_ID']." where Barcode ='".$_GET['Barcode']."';";
	$result = mysql_query($query);
	if($result)
		echo 'Record update successfully';
	else
		echo 'Record could not be updated';
	
}
else if($_GET['updatetype'] == 'additem')
{
	$query = "Insert into items (Description,Serial_number,Barcode,Item_Type_ID) values ('".$_GET['Description']."','".$_GET['Serial_number']."','".$_GET['Barcode']."',".$_GET['Item_Type_ID'].");";
	$result = mysql_query($query);
	if($result)
		echo 'Record added successfully';
	else
		echo 'Record could not be added';

}
elseif ($_GET['updatetype']=='delitem')
{
	$query ="Delete from items where Barcode ='".$_GET['Barcode']."';";
	$result = mysql_query($query);
	if($result)
		echo 'Record deleted successfully';
	else
		echo 'Record could not be deleted';
}

if($_GET['updatetype'] == 'updateprogram')
{
	$query = "Update programs_department SET Department_Name ='".$_GET['Department_Name']."' where Programs_Department_ID ='".$_GET['Program_ID']."';";
	$result = mysql_query($query);
	if($result)
		echo 'Record update successfully';
	else
		echo 'Record could not be updated';

}
else if($_GET['updatetype'] == 'addprogram')
{
	$query = "Insert into programs_department (Department_Name) values ('".$_GET['Department_Name']."');";
	$result = mysql_query($query);
	if($result)
		echo 'Record added successfully';
	else
		echo 'Record could not be added';

}
elseif ($_GET['updatetype']=='delprogram')
{
	$query ="Delete from programs_department where Department_Name ='".$_GET['Department_Name']."';";
	$result = mysql_query($query);
	if($result)
		echo 'Record deleted successfully';
	else
		echo 'Record could not be deleted';
}

if($_GET['updatetype'] == 'updateinstitution')
{
	$query = "Update institutions SET Name ='".$_GET['Institution_Name']."' where Institutions_ID ='".$_GET['Institution_ID']."';";
	$result = mysql_query($query);
	if($result)
		echo 'Record update successfully';
	else
		echo 'Record could not be updated';

}
else if($_GET['updatetype'] == 'addinstitution')
{
	$query = "Insert into institutions (Name) values ('".$_GET['Institution_Name']."');";
	$result = mysql_query($query);
	if($result)
		echo 'Record added successfully';
	else
		echo 'Record could not be added';

}
elseif ($_GET['updatetype']=='delinstitution')
{
	$query ="Delete from institutions where Name ='".$_GET['Institution_Name']."';";
	$result = mysql_query($query);
	if($result)
		echo 'Record deleted successfully';
	else
		echo 'Record could not be deleted';
}

if($_GET['updatetype'] == 'updateitemtype')
{
	$query = "Update item_type SET Description ='".$_GET['Description']."' where Item_Type_ID ='".$_GET['Item_Type_ID']."';";
	$result = mysql_query($query);
	if($result)
		echo 'Record update successfully';
	else
		echo 'Record could not be updated';
}
else if($_GET['updatetype'] == 'additemtype')
{
	$query = "Insert into item_type (Description) values ('".$_GET['Description']."');";
	$result = mysql_query($query);
	if($result)
		echo 'Record added successfully';
	else
		echo 'Record could not be added';

}
elseif ($_GET['updatetype']=='delitemtype')
{
	$query ="Delete from item_type where Description ='".$_GET['Description']."';";
	$result = mysql_query($query);
	if($result)
		echo 'Record deleted successfully';
	else
		echo 'Record could not be deleted';
}

if($_GET['updatetype'] == 'updateusertype')
{
	$query = "Update user_types SET Description ='".$_GET['Description']."' where Type_ID ='".$_GET['Type_ID']."';";
	$result = mysql_query($query);
	if($result)
		echo 'Record update successfully';
	else
		echo 'Record could not be updated';

}
else if($_GET['updatetype'] == 'addusertype')
{
	$query = "Insert into user_types (Description) values ('".$_GET['Description']."');";
	$result = mysql_query($query);
	if($result)
		echo 'Record added successfully';
	else
		echo 'Record could not be added';

}
elseif ($_GET['updatetype']=='delusertype')
{
	$query ="Delete from user_types where Description ='".$_GET['Description']."';";
	$result = mysql_query($query);
	if($result)
		echo 'Record deleted successfully';
	else
		echo 'Record could not be deleted';
}

if($_GET['updatetype'] == 'updateuser')
{
	if (md5($_GET['oldpassword'])==$_GET['password'])
	{
		$query = "Update login SET password ='".md5($_GET['newpassword'])."' where username ='".$_GET['username']."';";
		$result = mysql_query($query);
		if($result)
			echo 'Record update successfully';
		else
			echo 'Record could not be updated';
	}
	else{
		echo 'Incorrect old password';
	}

}
else if($_GET['updatetype'] == 'adduser')
{
	$query = "Insert into login (username,password,Users_ID) values ('".$_GET['username']."','".md5($_GET['newpassword'])."',501);";
	$result = mysql_query($query);
	if($result)
		echo 'Record added successfully';
	else
		echo 'Record could not be added';

}
elseif ($_GET['updatetype']=='deluser')
{
	$query ="Delete from login where username ='".$_GET['username']."';";
	$result = mysql_query($query);
	if($result)
		echo 'Record deleted successfully';
	else
		echo 'Record could not be deleted';
}

?>