<?php    
    //Set content-type header
    header("Content-type: image/png");

    //Include phpMyGraph5.0.php
include ("global.php");
include ("layout.php");
include ("functions.php");
include ("phpgraphlib.php");
    
	$date1 =$_GET['date1'];
	
	$date2 = $_GET['date2'];
	
    $data = array();
    $dateQuery = "select count(Loan_Date) as total,loan_date from loans where Loan_Date between '".$date1."' and '".$date2."' group by Loan_Date ";
    //echo $dateQuery;
    $result = mysql_query($dateQuery); // Run the query.
    //echo print_r($result);
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
    	$data[$row['loan_date']] = $row['total'];

    	//array_push($data,$temp);

    }
    //Set data

    //echo print_r($data);

    //Create PHPGraphLib instance
    $graph = new PHPGraphLib(700,500);
	$graph->addData($data);
	$graph->setTitle('Results by Date');
	$graph->setLegend(true);
	$graph->setXValuesHorizontal(true);
	
    //Parse
    if($_GET['type'] == 'line')
    {
   		$graph->setBars(false);
		$graph->setLine(true);
		$graph->setDataPoints(true);
		$graph->setDataPointColor('maroon');
		$graph->setDataValues(true);
		$graph->setDataValueColor('maroon');
		$graph->setGoalLine(.0025);
		$graph->setGoalLineColor('red');
    }
   	else
   	{
   		$graph->setBars(true);
   		$graph->setDataPoints(true);
   		$graph->setDataPointColor('maroon');
   		$graph->setDataValues(true);
   		$graph->setDataValueColor('maroon');
   		$graph->setGoalLine(.0025);
   		$graph->setGoalLineColor('red');
   		$graph->setGradient('red', 'maroon');
   	}
   	
   	$graph->createGraph();
?>