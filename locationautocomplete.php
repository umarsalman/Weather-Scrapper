<?php
//Assuming we have a Database which contains CitiesTable
$hostname="";
$username="";
$password="";
$db="";
$conn=new mysqli($hostname,$username,$password,$db);
$searchitem=$_GET['city'];
//Getting the City names similar to the input entered by the user
$sqlquery="select * from CitiesTable where cityname LIKE %".$searchitem."%";
$queryresult=$conn->query($sqlquery);
$suggestedresult=array();
while($row=$queryresult->fetch_assoc())
{
	array_push($suggestedresult,$row['cityname']);
}
//sending the result as json to the client
echo json_encode($suggestedresult);
?>