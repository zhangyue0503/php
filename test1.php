<?php
$conn = new mysqli("192.168.1.100","root","","moumou");

print_r($conn);

$sql = "select * from mm_member limit 0,10";
$result = $conn->query($sql);

while($row = $result->fetch_array()){
    print_r($row);
}


echo 111;
?>

