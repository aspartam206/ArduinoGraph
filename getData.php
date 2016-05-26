<?php

//include 'connection.php';
// It reads a json formatted text file and outputs it.

// $string = file_get_contents("http://10.126.11.177/index.json");
// echo $string;

// Instead you can query your database and parse into JSON.

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

$sql = mysqli_query($conn, "SELECT * FROM `tost`.`table`");

$rows = array();
//flag is not needed
$flag = true;
$table = array();
$table['cols'] = array(

    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'id', 'type' => 'string'),
    array('label' => 'suhu', 'type' => 'number'),
    array('label' => 'cahaya', 'type' => 'number')

);

$rows = array();
while($r = mysqli_fetch_assoc($sql)) {
    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $r['id']); 

    // Values of each slice
    $temp[] = array('v' => (float) $r['suhu']);
    $temp[] = array('v' => (float) $r['cahaya']); 
    $rows[] = array('c' => $temp);
}

$table['rows'] = $rows;
$jsonTable = json_encode($table);
echo $jsonTable;
?>
