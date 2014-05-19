<?PHP
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
top(); 
?>
<H1><strong>SYSTEM ADMIN PAGE</strong></H1>
<BR>
<div align="center">
<table width="350" border="0">
	<!--  	<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form1" METHOD="post" ACTION="people.php">
				<INPUT TYPE="hidden" NAME="action" VALUE="list">
				<INPUT TYPE="hidden" NAME="Submit" VALUE="Submit">
				<INPUT TYPE="hidden" NAME="sortorder" VALUE="fname">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="MANAGE STAFF LOGIN ACCOUNTS">
				</FORM>
                This manages the user accounts used to login to the Asset Loan System.<BR><BR>       
            </td>
		</tr>-->
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form2" METHOD="post" ACTION="additems.php">
				<INPUT TYPE="hidden" NAME="action" VALUE="selectloangroup">
				<INPUT TYPE="hidden" NAME="Submit" VALUE="Submit">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="MANAGE SYSTEM ITEMS">
				</FORM> 
                This Manages the items within the system.<BR><BR>
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form3" METHOD="post" ACTION="programs.php">
				<INPUT TYPE="hidden" NAME="action" VALUE="list">
				<INPUT TYPE="hidden" NAME="Submit" VALUE="Submit">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="MANAGE PROGRAMS/DEPARTMENT">
				</FORM>
              	This Manages the Program/Departments.<BR><BR>
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form3" METHOD="post" ACTION="itemtype.php">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="MANAGE ITEM TYPE">
				</FORM>
              	This section Manages Item Type.<BR><BR>
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form3" METHOD="post" ACTION="usertype.php">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="MANAGE USER TYPE">
				</FORM>
              	This section manages User Types<BR><BR>
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form3" METHOD="post" ACTION="institution.php">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="MANAGE INSTITUTIONS">
				</FORM>
              	This section manages Institutions<BR><BR>
            </td>
		</tr>
</table>
</div>
<?PHP 
bottom(); 
?>