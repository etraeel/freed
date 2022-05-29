<?php


$servername = "localhost";
$username = "root";
$password = "123456";
$database = "freeDomain";

$network = shell_exec("curl -I http://google.com");
if ($network == null) {
    var_dump("network is not connected!!");
    die();
}

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
                $commandResult = shell_exec('whois ' . $domain . ' | grep "No entries found in the selected source"');
            }else {
                $commandResult = shell_exec('whois ' . $domain . ' | grep "No match for domain"');
            }
            $status = strpos($commandResult , "No" );

            if(is_int($status)){
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
