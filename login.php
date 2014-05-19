<?PHP
session_start();
//session_destroy();
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
// Get variables
$action=@$_POST["action"]; // Check if a POST action is present.

if ($action)
	{
	$fuid=@$_POST["fuid"];						// LoginID
	$fpw=@$_POST["fpw"];						// Login pw
//	$lgroup=@$_POST["lgroup"];					// Loan Group	
	}
else
	{
	$action=@$_GET["action"];					// action (add,edit,delete)
	$fuid=@$_GET["fuid"];						// LoginID
	$fpw=@$_GET["fpw"];							// Login pw
//	$lgroup=@$_GET["lgroup"];					// Loan Group
	}

// Check submitted password
if ($action=='submitpw')
	{

	$CheckQuery = "select l.username,l.password,u.Type_ID,u.First_Name,u.Last_Name FROM login l join users u on l.Users_ID = u.Users_ID AND l.username='".strtolower($fuid)."'";
	$CheckResult = @mysql_query($CheckQuery);
	$CheckNum = mysql_num_rows($CheckResult);
	If ($CheckNum>=1)
		{
		$CheckRow = @mysql_fetch_array($CheckResult);
			{
			if (($fpw)==$CheckRow["password"])
				{
				$_SESSION["AUTH_USER"]= true;
				//$_SESSION['AUTH_USER_NAME']=$CheckRow["First_Name"].' '.$CheckRow["Last_Name"];
				//$_SESSION["AUTH_USER_TYPE"]='ADMIN';
				//download_aleph_data();
				Header("Location: index.php"); 
				//exit;
				}
			else
				{
				$message = 'Invalid loginid or password!';
				$_SESSION["AUTH_USER"]=false;
				} 
			}
		}
	}
top();

?>
<BR><H1 align="left">SYSTEM LOGIN PAGE</H1><BR>
<BR>
<div align="center">
<form name="form1" method="post" action="login.php">
<INPUT TYPE="hidden" NAME="action" VALUE="submitpw">
<?PHP	if (@$message) 
			print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';
		else
			print '<BR>';
		echo $_SESSION['AUTH_USER'];
		?>
<table width="200" border="0" style="border:#000000 2px solid; width:375px;">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td width="30">LoginID:</td>
    <td width="160" align="left"><input type="text" name="fuid" size="15" /></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Password:</td>
    <td align="left"><input type="password" name="fpw" size="35" /></td>
    <td>&nbsp;</td>    
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><input type="submit" value="Submit" style="text-align:center;" /></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
</form>
<? focus('form1','fuid'); ?>
</DIV>
<BR>
<?PHP 
bottom();
//session_end();
?>