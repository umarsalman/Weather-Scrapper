

<?php
/* this code works if there is a connection with mysql database */ 
$host="";

$user="";

$pwd="";

$db="";

/* establishing a connection with the mysql database */

$con=new mysqli($host,$user,$pwd,$db);

$itemssearched=$_GET['cityname'];


/* finding the cities which are matching with the pattern or input entered by the client */

$que="select * from Cities where cname LIKE %".$itemssearched."%";

$result=$con->query($que);

$output=array();

/*iterating through the array obtained as output from the above qyuery */

while($iterator=$result->fetch_assoc())
{
	array_push($output,$iterator['cname']);
}
echo json_encode($output);

/* send the output as a json file */
?>