<?php


$servername = "localhost";
$username = "root";
$password = "123456";
$database = "freeDomain";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

    $sql = 'SELECT * FROM `domains` ORDER BY `date` ASC LIMIT 1';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $domain = $row['name'];
            $status = '1';
            $subDomain = explode('.' , $domain);

            if($subDomain[1] == "ir"){
                $status = shell_exec('whois ' . $domain . ' | grep "domain"');
            }else {
                $status = shell_exec('whois ' . $domain . ' | grep "Expiry Date"');
            }

            if($status == null){
                $sql = 'UPDATE domains SET status=2,date=current_timestamp WHERE id=' . (string)$row['id'];
                $result = mysqli_query($conn, $sql);
            }else{
                $sql = 'UPDATE domains SET status=1,date=current_timestamp WHERE id=' . (string)$row['id'];
                $result = mysqli_query($conn, $sql);
            }
        }

    } else {
        echo "0 results";
    }
}

$conn->close();

?>
