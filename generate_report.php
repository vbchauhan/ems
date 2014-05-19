<?PHP
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
//header("Content-type: image/png");
include ("global.php");
include ("layout.php");
include ("functions.php");
include('phpMyGraph.php');
echo $_SESSION["AUTH_USER"];
//if (@$_SESSION["AUTH_USER"]==true){
top(); 
?>
<!DOCTYPE html>
<head>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js"></script>
<link href="/<?=strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link href="/<?=strtolower($_SESSION["SystemNameStr"])?>/css/jquery-ui-1.10.4.custom.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?=strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<script language="javascript" type="text/javascript">

function draw_graph(){
//	window.open("test.php");
    $.ajax({
        url: 'test.php',
       // dataType: 'html',
        success: function(data) {
            var date1 = $("#fromdate").val();
            var date2 = $("#todate").val();
            var type = $("#graphtype").val();
            if($("#graphparam").val()=="date")
           		$('#dataval').html('<img src="generate_by_date.php?date1='+date1+'&date2='+date2+'&type='+type+'" />');
            else if($("#graphparam").val()=="institution")
            	$('#dataval').html('<img src="generate_by_institution.php?date1='+date1+'&date2='+date2+'&type='+type+'" />');
            else if($("#graphparam").val()=="department")
            	$('#dataval').html('<img src="generate_by_department.php?date1='+date1+'&date2='+date2+'&type='+type+'" />');
            else if($("#graphparam").val()=="usertype")
            	$('#dataval').html('<img src="generate_by_usertype.php?date1='+date1+'&date2='+date2+'&type='+type+'" />');
        }
    });

    return false;
}

</script>
</head>
<body>

<div id="container" >

<div id="banner" style="width:90%;float:left">EQUIPMENT REPORTS</div>

<div id="menu" style="width:22%;height:60%;float:left;">
<label>Enter From Date</label><br>
<input type = "Date" id = "fromdate" value="<?php echo date('Y-m-d'); ?>"><br>
<label>Enter To Date</label><br>
<input type = "Date" id = "todate" value="<?php echo date('Y-m-d'); ?>"><br>
<label>Graph Parameters</label><br>
<select id = "graphparam">
  <option value="date">By Date</option>
  <option value="institution">By Institution</option>
  <option value="usertype">By User Type</option>
  <option value="department">By Program</option>
</select><br>
<label>Graph Type</label><br>
<select id = "graphtype">
  <option value="line">Line Graph</option>
  <option value="bar">Bar Graph</option>
</select><br>
<input type = "button" value="Submit" id ="datesubmit" onclick ="draw_graph()">
</div>

<div id="content" style="width:73%;float:left;margin-left:10px;border:0px">
<div id = "dataval"></div>

</div>

</div>

<BR>

<?PHP 
bottom(); 
/*} //End of the IF statement
else
	{ // if person is not allowed to access page throw up a 404 error
	top();
	echo print_r($_SESSION);
	echo "<h1>You have to log in to view this page</h1>	";
	header("HTTP/1.0 404 Not Found");
	exit;
	}*/
?>

</body>
</html>
