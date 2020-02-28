<?php

$api_key_value = "tPmAT5Ab3j7F9";

$servername = "localhost";

// REPLACE with your Database name
$dbname = "esp_data";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "raspberry";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}   

//Ambil data dari tabel database SensorData
$sql = "SELECT id, sensor, temp, hum, reading_time FROM SensorData ORDER BY id DESC";

// $records = mysqli_query($dbconnect,$sql);
// $numResults = mysqli_num_rows($records);
// $row = mysqli_fetch_assoc($records);

if ($result = $conn->query($sql)) {
    // for($i=0; $i<($numResults) ; $i++){
    //     if ($i == $numResults-1){
    while ($row = $result->fetch_assoc()) {
            $row_temp = $row["temp"];
            $row_hum = $row["hum"];
            echo $row_temp;
            echo $row_hum;
    //     }
    // }
    }
    $result->free();
}

$conn->close();



// for($i=0; $i<($numResults) ; $i++){
//     $row = mysqli_fetch_assoc($records);
//     if ($i == $numResults-1){
//         echo $row["temp"];
//         echo $row["hum"];
//     }
// }

//$sql= "DELETE FROM `SensorData` WHERE 1";

mysqli_query($dbconnect, $sql);

?>