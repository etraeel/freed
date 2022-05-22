<?php

require '../vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$database = "freeDomain";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

    $sql = 'SELECT * FROM `domains` ORDER BY `date` ASC LIMIT 1';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $url = 'https://azaronline.com/api/whois/?domain=' . (string)$row['name'];

            try {
                $client = new GuzzleHttp\Client();
                $res = $client->request('GET', $url);
                $result = $res->getBody();
                $result = json_decode($result, true);

                if (isset($result) && $result[0]['status'] == 'available') {

                    $sql2 = 'UPDATE domains SET status=2,date=current_timestamp WHERE id=' . (string)$row['id'];
                    $result2 = mysqli_query($conn, $sql2);
                } elseif (isset($result) && $result[0]['status'] == 'unAvailable') {

                    $sql2 = 'UPDATE domains SET status=1,date=current_timestamp WHERE id=' . (string)$row['id'];
                    $result2 = mysqli_query($conn, $sql2);
                }
            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                echo $e;
            }

        }

    } else {
        echo "0 results";
    }

}

$conn->close();
return "ok";
?>
