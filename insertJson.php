<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tost";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
} 
// //get json data from arduino	
// $string = file_get_contents("http://10.126.11.177/index.json");

// //input to mysql 5.7 database
// $sql = "INSERT INTO table (ijson)
// 		VALUES ("+ $string +")";

//read the json file contents
//$jsondata = file_get_contents('http://10.126.11.184/');
$jsondata = file_get_contents('http://192.168.1.150/');
echo "Json Value = ";
echo $jsondata;
echo "<br>";

//convert json object to php associative array
//$jsondata = utf8_encode($jsondata); //fail
$data = json_decode($jsondata, TRUE);
echo "JsonConvert = ";
var_dump($data);
echo "<br>";

//get the employee details
$cahaya = implode("", $data['cahaya']);
$suhu = implode("", $data['suhu']);

echo "Suhu Value =";
//var_dump($suhu);
echo $suhu;
echo "<br>";

echo "Cahaya Value =";
//var_dump($cahaya);
echo $cahaya;
echo "<br>";

//insert into mysql table
    $sql = "INSERT INTO `table` (`suhu`, `cahaya`)
    		VALUES('$suhu', '$cahaya')";
    if(!mysqli_query($conn,$sql))
    {
        die('Error : ' . mysqli_error($conn));
    } else {
    	echo "New record created successfully";
    }

//exit() connection
$conn->close();
?>
