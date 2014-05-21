<?php
include ("global.php");
include ("layout.php");
include ("functions.php");

if($_GET['updatetype'] == 'updateitem')
{
	$query = "Update Items SET Description ='".$_GET['Description']."',Serial_number='".$_GET['Serial_number']."',Item_Type_ID=".$_GET['Item_Type_ID']." where Barcode ='".$_GET['Barcode']."'";
	$result = mysql_query($query);
	if($result)
		echo 'Record update successfully';
	else
		echo 'Record could not be updated';
	
}
else if($_GET['updatetype'] == 'additem')
{
	$query = "Insert into Items (Description,Serial_number,Barcode,Item_Type_ID) values ('".$_GET['Description']."','".$_GET['Serial_number']."','".$_GET['Barcode']."',".$_GET['Item_Type_ID'].")";
	$result = mysql_query($query);
	if($result)
		echo 'Record added successfully';
	else
		echo 'Record could not be added';

}
elseif ($_GET['updatetype']=='delitem')
{
	$query ="Delete from items where Barcode ='".$_GET['Barcode']."'";
	$result = mysql_query($query);
	if($result)
		echo 'Record deleted successfully';
	else
		echo 'Record could not be deleted';
}

if($_GET['updatetype'] == 'updateprogram')
{
	$query = "Update Programs_Department SET Department_Name ='".$_GET['Department_Name']."' where Programs_Department_ID ='".$_GET['Program_ID']."'";
	$result = mysql_query($query);
	if($result)
		echo 'Record update successfully';
	else
		echo 'Record could not be updated';

}
else if($_GET['updatetype'] == 'addprogram')
{
	$query = "Insert into Programs_Department (Department_Name) values ('".$_GET['Department_Name']."')";
	$result = mysql_query($query);
	if($result)
		echo 'Record added successfully';
	else
		echo 'Record could not be added';

}
elseif ($_GET['updatetype']=='delprogram')
{
	$query ="Delete from Programs_Department where Department_Name ='".$_GET['Department_Name']."'";
	$result = mysql_query($query);
	if($result)
		echo 'Record deleted successfully';
	else
		echo 'Record could not be deleted';
}

if($_GET['updatetype'] == 'updateinstitution')
{
	$query = "Update Institutions SET Name ='".$_GET['Institution_Name']."' where Institutions_ID ='".$_GET['Institution_ID']."'";
	$result = mysql_query($query);
	if($result)
		echo 'Record update successfully';
	else
		echo 'Record could not be updated';

}
else if($_GET['updatetype'] == 'addinstitution')
{
	$query = "Insert into Institutions (Name) values ('".$_GET['Institution_Name']."')";
	$result = mysql_query($query);
	if($result)
		echo 'Record added successfully';
	else
		echo 'Record could not be added';

}
elseif ($_GET['updatetype']=='delinstitution')
{
	$query ="Delete from Institutions where Name ='".$_GET['Institution_Name']."'";
	$result = mysql_query($query);
	if($result)
		echo 'Record deleted successfully';
	else
		echo 'Record could not be deleted';
}

if($_GET['updatetype'] == 'updateitemtype')
{
	$query = "Update Item_Type SET Description ='".$_GET['Description']."' where Item_Type_ID ='".$_GET['Item_Type_ID']."'";
	$result = mysql_query($query);
	if($result)
		echo 'Record update successfully';
	else
		echo 'Record could not be updated';
}
else if($_GET['updatetype'] == 'additemtype')
{
	$query = "Insert into Item_Type (Description) values ('".$_GET['Description']."')";
	$result = mysql_query($query);
	if($result)
		echo 'Record added successfully';
	else
		echo 'Record could not be added';

}
elseif ($_GET['updatetype']=='delitemtype')
{
	$query ="Delete from Item_Type where Description ='".$_GET['Description']."'";
	$result = mysql_query($query);
	if($result)
		echo 'Record deleted successfully';
	else
		echo 'Record could not be deleted';
}

if($_GET['updatetype'] == 'updateusertype')
{
	$query = "Update User_Types SET Description ='".$_GET['Description']."' where Type_ID ='".$_GET['Type_ID']."'";
	$result = mysql_query($query);
	if($result)
		echo 'Record update successfully';
	else
		echo 'Record could not be updated';

}
else if($_GET['updatetype'] == 'addusertype')
{
	$query = "Insert into User_Types (Description) values ('".$_GET['Description']."')";
	$result = mysql_query($query);
	if($result)
		echo 'Record added successfully';
	else
		echo 'Record could not be added';

}
elseif ($_GET['updatetype']=='delusertype')
{
	$query ="Delete from User_Types where Description ='".$_GET['Description']."'";
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
		$query = "Update login SET password ='".md5($_GET['newpassword'])."' where username ='".$_GET['username']."'";
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
	$query = "Insert into login (username,password,Users_ID) values ('".$_GET['username']."','".md5($_GET['newpassword'])."',501)";
	$result = mysql_query($query);
	if($result)
		echo 'Record added successfully';
	else
		echo 'Record could not be added';

}
elseif ($_GET['updatetype']=='deluser')
{
	$query ="Delete from login where username ='".$_GET['username']."'";
	$result = mysql_query($query);
	if($result)
		echo 'Record deleted successfully';
	else
		echo 'Record could not be deleted';
}

?>