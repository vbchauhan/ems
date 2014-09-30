<?PHP
function focus($form,$field)
	{
	print '<SCRIPT TYPE="text/javascript" LANGUAGE="javascript">';
	print 'document.'.$form.'.'.$field.'.focus();';
	print '</SCRIPT>';
	} // END function focus($form,$field)


function leftstr($str,$len)
	{
	$length=strlen($str);
	if ( $len > $length ) $len=$length;
	$tempstr=substr($str, 0, $len);
	return ($tempstr);
	} //END function leftstr($str,$len)


function rightstr($str,$len)
	{
	$length=strlen($str);
	if ( $len > $length ) $len=$length;
	$tempstr=substr($str, $length-$len, $len);
	return ($tempstr);
	} //END function rightstr($str,$len)
	
function dateDiff($dt1, $dt2, $timeZone = 'GMT') {
$tZone = new DateTimeZone($timeZone);
$dt1 = new DateTime($dt1, $tZone);
$dt2 = new DateTime($dt2, $tZone);
$ts1 = $dt1->format('Y-m-d');
$ts2 = $dt2->format('Y-m-d');
$diff = abs(strtotime($ts1)-strtotime($ts2));
$diff/= 3600*24;
return $diff;
}

function countdays($fromdate,$todate)
	{
	$datetime1 = new DateTime($fromdate);
	$datetime2 = new DateTime($todate);
	$interval = $datetime1->diff($datetime2);
	$DifDays=intval($interval->format('%a'));
	return $DifDays;
	} //END function countdays($fromdate,$todate)


function displaymailto($EmailAddresses, $ShortCaption, $LongCaption)
	{
	$resultstr=0;
	if (strlen($EmailAddresses)>=2)
		{
		print '<DIV Align="right">';
		if (strlen($EmailAddresses)<=1500)
			{
			print '[<A HREF="mailto:'.$EmailAddresses.'">'.$ShortCaption.'</A>]';
			$resultstr=1;
			} //END if (strlen($EmailAddresses)<=1500)
		else 
			{
			$_SESSION["EmailAddresses"]=$EmailAddresses; // Pass the emails via a session variable to the displayemailaddresses web page.
			print '[<A HREF="/'.strtolower($_SESSION["SystemNameStr"]).'/email_list.php" TARGET="_blank">'.$LongCaption.'</A>]';
			$resultstr=2;
			} //END ELSE if (strlen($EmailAddresses)<=1500)
		print '</DIV>';
		} //END if (strlen($EmailAddresses)>=2)
	return $resultstr;
	} //END function displaymailto($EmailAddresses, $ShortCaption, $LongCaption)


function pwHash($input) 
	{ 
	return leftstr(str_rot13(base64_encode(hash('sha512', $input))),200); 
	} //END pwHash($input)

function canupdate() 
	{ 
	if (@$_SESSION["AUTH_USER_TYPE"]=='ADMIN')
		return true;
	else
		return false;
	} //END canupdate()


function lookupbarcode($barcodedata,$LoanOverride)
	{
	$ListQuery = "SELECT * FROM loansystem WHERE ((itembarcode='".$barcodedata."') and (itemvisible='1'))";
	$ListResult = @mysql_query($ListQuery);
	$ListNum = mysql_num_rows($ListResult);

	if ($ListNum>=1)
		{
		$ListQueryRow = @mysql_fetch_array($ListResult);
		$stitle=$ListQueryRow["shortitemtitle"];
		if ($LoanOverride>=1)
			$maxloandays='MaxLoan '.$LoanOverride.' days';			
		else
			$maxloandays='MaxLoan '.$ListQueryRow["warningred"].' days';
		
		if ($ListQueryRow["itemloanflag"]==1)
			$loanflag='ITEM IS ON LOAN ALREADY!!';
		else
			$loanflag='Available To Be Loaned';
		
		$OutputStr=strtoupper($barcodedata).', '.$stitle.', '.$maxloandays.', '.$loanflag;
		return $OutputStr;
		} //END if ($ListNum>=1)
	else
		return '';

	} //END function lookupbarcode($barcodedata)


function IsItemOnLoan($barcodedata)
	{
	$ListQuery = "SELECT * FROM loansystem WHERE (itembarcode='".$barcodedata."')";
	$ListResult = @mysql_query($ListQuery);
	$ListNum = mysql_num_rows($ListResult);

	if ($ListNum>=1)
		{
		$ListQueryRow = @mysql_fetch_array($ListResult);
		$stitle=$ListQueryRow["shortitemtitle"];
		if ($ListQueryRow["itemloanflag"]==1)
			$OutputStr=1;
		else
			$OutputStr=0;
		
		return $OutputStr;
		} //END if ($ListNum>=1)
	else
		return '';
	} //END IsItemOnLoan($barcodedata)


function lookupperson($ssid,$semail,$sname,$sphone)
	{
	// function will return the following if a record is found
	// staffid,email,name,phone,isstaffmemeber,uid
	
	$csid=strtolower($ssid);
	$cemail=strtolower($semail);
//	$cname=strtolower($sname);
//	$cphone=strtolower($sphone);
	
	if ((strlen($csid))<=1) $csid='99999988899999999a';
	if ((strlen($cemail))<=1) $cemail='99999988899999999a';
//	if ((strlen($cphone))<1) $cphone='99999988899999999a';				

	if ((strlen($cname))<1) 
		{
//		$cname='99999988899999999a';
//		$cnamefirst='99999988899999999a';
//		$cnamelast='99999988899999999a';
		} //END if (strlen($cname)<=1)
	else
		{
		$namebreak=strpos($cname,' ');
		if ($namebreak>=3)
			{
			$cnamefirst=leftstr($cname,$namebreak);
			$cnamelast=rightstr($cname,(strlen($cname)-($namebreak+1)));			
			} //END if ($namebreak>=3)
			else
				{
				$cnamefirst=$cname;
				$cnamelast=$cname;
				} //END ELSE if ($namebreak>=3)			
		} //END ELSE if (strlen($cname)<=1)

		$LookupQuery = "SELECT			
							uid,
							loginid,
							email,
							lastname,
							firstname,
							proxycardno,
							barcode,
							phone
						FROM people WHERE 
								((LOWER(loginid)='".strtolower($csid)."') or 
								(LOWER(email)='".strtolower($cemail)."') or 
								(LOWER(proxycardno)='".strtolower($csid)."') or 
								(LOWER(barcode)='".strtolower($csid)."'))";						
		$LookupResult = @mysql_query($LookupQuery);
		$LookupNum = mysql_num_rows($LookupResult);

		if ($LookupNum>=1)
			{
			$LookupQueryRow = @mysql_fetch_array($LookupResult);
			$OutputStr=$LookupQueryRow["loginid"].','.$LookupQueryRow["email"].','.$LookupQueryRow["firstname"].' '.$LookupQueryRow["lastname"].','.$LookupQueryRow["phone"].',1,'.$LookupQueryRow["uid"];
			return $OutputStr;
			} //END if ($LookupNum>=1)
		else
			{
			$LookupQuery2 = "SELECT
								uid,
								staffid,
								email,
								name,
								phone
							FROM namecache WHERE 
									((LOWER(staffid)='".$csid."') or 
									(LOWER(email)='".strtolower($cemail)."'))";						
			$LookupResult2 = @mysql_query($LookupQuery2);
			$LookupNum2 = mysql_num_rows($LookupResult2);
			$LookupQueryRow2 = @mysql_fetch_array($LookupResult2);			
			if ($LookupNum2>=1)
				{
				$LookupQueryRow = @mysql_fetch_array($LookupResult);
				$OutputStr=$LookupQueryRow2["staffid"].','.$LookupQueryRow2["email"].','.$LookupQueryRow2["name"].','.$LookupQueryRow2["phone"].',0,'.$LookupQueryRow2["uid"];
				return $OutputStr;							
				} //END if ($LookupNum2>=1)
			else
				{
				return '';					
				} //END ELSE if ($LookupNum2>=1)

			} //END ELSE if ($LookupNum>=1)
	} //END lookupperson($ssid,$semail,$sname,$sphone)


function loanstatus($AmberNum,$RedNum,$OverrideNum,$StartDate)
	{
	$OutputStr='';
	$DayCount = dateDiff($StartDate,date('Y-m-d'));	
	if ($OverrideNum>=1)
		{
		// Figure out the Amber Alert number
		$AmberCountNum=$OverrideNum-3;
		if ($AmberCountNum<=0) $AmberCountNum=$OverrideNum-1; 
		if ($AmberCountNum<=0) $AmberCountNum=$OverrideNum+1;  // disable the amber alert...	
		if ($DayCount <= ($AmberCountNum)) $OutputStr = 'green';
		if ($DayCount >= $AmberCountNum) $OutputStr = 'amber';
		if ($DayCount >= $OverrideNum) $OutputStr = 'red';		
		} //END if ($OverrideNum>=1)
	else
		{
		if ($DayCount <= $AmberNum) $OutputStr = 'green';
		if ($DayCount >= $AmberNum) $OutputStr = 'amber';
		if ($DayCount >= $RedNum) $OutputStr = 'red';
		} //END if ($OverrideNum>=1)
	return $OutputStr;
	} //END loanstatus($AmberNum,$RedNum,$OverrideNum,$StartDate)


function text_protect($InputStr)
	{
		// Put your Encryption here.
		// this function is uesed on the MYSQL UserID and password.		
		return $InputStr;
	} // END text_protect($InputStr)
	

function text_unprotect($InputStr)
	{
	// Put your Decryption here.
	// this function is uesed on the MYSQL UserID and password.
	return $InputStr;
	} // END text_unprotect($InputStr)
	
function get_user_type_id($InputStr)
	{
		$ListQuery = "SELECT * FROM user_types WHERE (description='".$InputStr."')";
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		if($ListNum >=1)
		{
			$ListQueryRow = @mysql_fetch_array($ListResult);
			$type_id=$ListQueryRow["Type_ID"];
		}
		if($type_id)
			return $type_id;
		else
			return "";
	} // End get_user_type_id
	
function get_institution_id($InputStr)
	{
		$ListQuery = "SELECT * FROM institutions WHERE (name='".$InputStr."')";
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		if($ListNum >=1)
		{
			$ListQueryRow = @mysql_fetch_array($ListResult);
			$inst_id=$ListQueryRow["Institutions_ID"];
		}
		if($inst_id)
			return $inst_id;
		else
			return "";
	} // End get_institution_id
	
function get_programs_id($InputStr)
	{
		$ListQuery = "SELECT * FROM programs_department WHERE (department_name='".$InputStr."')";
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		if($ListNum >=1)
		{
			$ListQueryRow = @mysql_fetch_array($ListResult);
			$prog_id=$ListQueryRow["Programs_Department_ID"];
		}
		if($prog_id)
			return $prog_id;
		else
			return "";
	} // End get_programs_id

function get_item_type_id($InputStr)
	{
		
		$ListQuery = "SELECT * FROM item_type WHERE (description='".$InputStr."')";
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);

		if($ListNum >=1)
		{
			$ListQueryRow = @mysql_fetch_array($ListResult);
			$item_id=$ListQueryRow["Item_Type_ID"];
		}
		if($item_id)
			return $item_id;
		else
			return "";
	} // End get_item_type_id

function get_status_id($InputStr)
	{
		$ListQuery = "SELECT * FROM status WHERE (description='".$InputStr."')";
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		if($ListNum >=1)
		{
			$ListQueryRow = @mysql_fetch_array($ListResult);
			$status_id=$ListQueryRow["Status_ID"];
		}
		if($status_id)
			return $status_id;
		else
			return "";
	} // End get_status_id

function get_user_type_desc($InputStr)
	{
		$ListQuery = "SELECT * FROM user_types WHERE (type_id='".$InputStr."')";
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		if($ListNum >=1)
		{
			$ListQueryRow = @mysql_fetch_array($ListResult);
			$type_id=$ListQueryRow["Description"];
		}
		if($type_id)
			return $type_id;
		else
			return "";
	} // End get_user_type_desc
	
function get_institution_name($InputStr)
	{
		$ListQuery = "SELECT * FROM institutions WHERE (institutions_id='".$InputStr."')";
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		if($ListNum >=1)
		{
			$ListQueryRow = @mysql_fetch_array($ListResult);
			$inst_id=$ListQueryRow["Name"];
		}
		if($inst_id)
			return $inst_id;
		else
			return "";
	} // End get_institution_name
	
function get_programs_name($InputStr)
	{
		$ListQuery = "SELECT * FROM programs_department WHERE (programs_department_id='".$InputStr."')";
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		if($ListNum >=1)
		{
			$ListQueryRow = @mysql_fetch_array($ListResult);
			$prog_id=$ListQueryRow["Department_Name"];
		}
		if($prog_id)
			return $prog_id;
		else
			return "";
	} // End get_programs_name
	
function get_item_type_desc($InputStr)
	{
	
		$ListQuery = "SELECT * FROM item_type WHERE (item_type_id='".$InputStr."')";
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
	
		if($ListNum >=1)
		{
			$ListQueryRow = @mysql_fetch_array($ListResult);
			$item_id=$ListQueryRow["Description"];
		}
		if($item_id)
			return $item_id;
		else
			return "";
	} // End get_item_type_desc
	
function get_status_desc($InputStr)
	{
		$ListQuery = "SELECT * FROM status WHERE (status_id='".$InputStr."')";
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		if($ListNum >=1)
		{
			$ListQueryRow = @mysql_fetch_array($ListResult);
			$status_id=$ListQueryRow["Description"];
		}
		if($status_id)
			return $status_id;
		else
			return "";
	} // End get_status_desc	
// end of file functions.php

function download_aleph_data()
{
	$file = new SimpleXMLElement(file_get_contents("http://catalog.umd.edu/cgi-bin/cpsgequip"));
	//echo $file->table;
	$items = $file ->body -> table[0]->tr;
	$summary = $file -> body -> table[1]->tr;
	//$file = fopen("test.txt","w");
	$data = array();
	$line = '';
	for ($i = 0; ;$i++)
	{
		if($items[0]->th[$i] != "")
		{
			$header[0][$i] = $items[0]->th[$i];
		}
		else
			break;
	
	}
	//echo sizeof($items[1]->td);
	for ($i = 1; $i<sizeof($items) ;$i++)
	{
		for ($j = 0; $j<sizeof($items[$i]);$j++)
		{
			$line_items[$i - 1][$j] = $items[$i]->td[$j];
			//fwrite($file, $line_items[$i - 1][$j].",");
			
		}
		$line['Title'] = $items[$i]->td[0];
		$line['Barcode'] = $items[$i]->td[1];
		$line['Callno'] = $items[$i]->td[2];
		$line['IS'] = $items[$i]->td[3];
		$line['Last_return'] = date('Y-m-d',strtotime($items[$i]->td[4]));
		$line['Loan'] = date('Y-m-d',strtotime($items[$i]->td[5]));
		$line['Due'] = date('Y-m-d',strtotime($items[$i]->td[6]));
		$line['User'] = $items[$i]->td[7];
		$line['Status'] = $items[$i]->td[8];
		$line['Institution'] = $items[$i]->td[9];
		$line['Bk-start'] = $items[$i]->td[10];
		$line['Bk-end'] = $items[$i]->td[11];
		//fwrite($file,"\n");
		array_push($data,$line);
		$line = '';
	}
	//echo print_r($data);
	for ($i = 0; ;$i++)
	{
		if($summary[0]->th[$i] != "")
		{
			$header[1][$i] = $summary[0]->th[$i];
		}
		else
			break;
	
	}
	for ($i = 1; $i<sizeof($summary) ;$i++)
	{
		for ($j = 0; $j<sizeof($summary[$i]->td);$j++)
		{
			$item_summary[$i - 1][$j] = $summary[$i]->td[$j];
		}
	}
	//for ($i= 0;;$i++)

	//fclose($file);
	return $data;
	//echo "Data Written to file";
}
function download_availableitems_data()
{
	$file = new SimpleXMLElement(file_get_contents("http://catalog.umd.edu/cgi-bin/cpsgequip"));
	echo $file->table;
	$summary = $file -> body -> table[1]->tr;
	$data = array();
	$line = '';
	for ($i = 1; $i<sizeof($summary) ;$i++)
	{
	
		$line['Type']=$summary[$i]->td[0];
		$line['Sublib'] = $summary[$i]->td[1];
		$line['Coll'] = $summary[$i]->td[2];
		$line['Available'] = $summary[$i]->td[3];
		$line['Total'] = $summary[$i]->td[4];
		$line['Earliest_due'] = date('Y-m-d',strtotime($summary[$i]->td[5]));
		array_push($data,$line);
		$line = '';
	}
	
	return $data;
}
function validate_date($date)
{
	$phpdate = strtotime($date);
	$mysqldate = date('Y-m-d',$phpdate);
	if ($mysqldate == "1970-01-01" || $mysqldate == "1969-12-31")
		return "-";
	else
		return $mysqldate;
	 
		
}
function compareitems()
{
	echo print_r($returnedarray[0]);
}
function setPostData($var)
{
	$_SESSION['data'] = $var;

}
function check_user_id($user_id){
	if ($user_id == "")
		return "";
	else 
		return str_pad($user_id,12,'0',STR_PAD_LEFT);
}
function refresh(){
	$data = download_aleph_data();
	//echo $data[0]['Title'];
	$sql = array();
	foreach ($data as $datarow){
		$sql[] = '("'.$datarow['Title'].'","'.$datarow['Barcode'].'","'.$datarow['Callno'].'","'.$datarow['IS'].'","'.$datarow['Last_return'].'","'.$datarow['Loan'].'","'.$datarow['Due'].'","'.ltrim($datarow['User'],'0').'","'.$datarow['Status'].'","'.$datarow['Institution'].'","'.$datarow['Bk-start'].'","'.$datarow['Bk-end'].'")';
	}
	mysql_query('Truncate table aleph_data');
	$abc = mysql_query('INSERT INTO aleph_data (Title, Barcode,Callno,IS_no,Last_return,Loan,Due,Aleph_ID,Status_id,Institution,Booking_date_from,Booking_date_to) VALUES '.implode(',', $sql));
	
	$query = "SELECT Request_ID,No_of_items,Request_Date,Users_ID,Item_Type_ID FROM request";
	$result = mysql_query($query); // Run the query.
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	
		$query_users = "SELECT * FROM users where Users_ID =".$row['Users_ID'];
		$userResult = mysql_query($query_users); // Run the query.
		$userRow = mysql_fetch_array($userResult, MYSQL_ASSOC);
	
		if($userRow['Aleph_ID'] != '')
		{
			$alephResult = mysql_query('Select * from aleph_data where Aleph_ID ="'.$userRow['Aleph_ID'].'"');
			while ($alephRow = mysql_fetch_array($alephResult, MYSQL_ASSOC))
			{
			if ($alephRow['Aleph_ID'] && $row['Request_Date'] == $alephRow['Loan'])
			{
				$query_item = "SELECT * FROM items where barcode =".$alephRow['Barcode'];
				$itemResult = mysql_query($query_item); // Run the query.
				$itemRow = mysql_fetch_array($itemResult, MYSQL_ASSOC);
				$queryUpdate = "Insert into loans (Loan_Date , Return_Date , Due_Date , Request_accept_date , Booking_date_from , Booking_date_to , Request_ID , Items_ID , Users_ID )	values ('".date('Y-m-d',strtotime($alephRow['Loan']))."','".date('Y-m-d',strtotime($alephRow['Due']))."','".date('Y-m-d',strtotime($alephRow['Due']))."','".$row['Request_Date']."','".date('Y-m-d',strtotime($alephRow['Booking_date_from']))."','".date('Y-m-d',strtotime($alephRow['Booking_date_to']))."','".$row['Request_ID']."','".$itemRow['Items_ID']."','".$userRow['Users_ID']."');";
				mysql_query($queryUpdate);
				//echo "Success";
			}
			//else
			//echo "Error";
			}
		}
	}
}


?>