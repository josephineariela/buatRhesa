<?php

/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/esp32-esp8266-mysql-database-php/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
*/

//PHPmyAdmin Initialization
$servername = "localhost";
$dbname = "esp_data";
$username = "root";
$password = "raspberry";
$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $sensor = $temp = $hum = "";

//Getting data from ESP32-S
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $sensor = test_input($_POST["sensor"]);
        $temp = test_input($_POST["temp"]);
        $hum = test_input($_POST["hum"]);
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO SensorData (sensor, temp, hum) VALUES ('" . $sensor . "', '" . $temp . "', '" . $hum . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }   

    //Ambil data dari tabel database SensorData
    $sql = "SELECT id, sensor, temp, hum, reading_time FROM SensorData ORDER BY id DESC";

    echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>ID</td> 
        <td>Sensor</td> 
        <td>Temp</td> 
        <td>Hum</td> 
        <td>Timestamp</td> 
      </tr>';
 
    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $row_id = $row["id"];
            $row_sensor = $row["sensor"];
            $row_temp = $row["temp"];
            $row_hum = $row["hum"];  
            $row_reading_time = $row["reading_time"];

            echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_sensor . '</td> 
                <td>' . $row_temp . '</td> 
                <td>' . $row_hum . '</td> 
                <td>' . $row_reading_time . '</td> 
              </tr>';
        }
        $result->free();
    }

    $conn->close();
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
