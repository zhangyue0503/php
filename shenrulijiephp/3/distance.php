<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/30
 * Time: 下午5:16
 */
?>
<html>
<head></head>
<body>
<?php
$zip  = 64154;
echo "<h1>Nearest stores to $zip</h1>";
$dbc = mysqli_connect("localhost",'root','root','books');
$q = "SELECT latitude,longitude FROM zip_codes WHERE zip_code='$zip' AND latitude IS NOT NULL";
$r = mysqli_query($dbc,$q);

if(mysqli_num_rows($r)==1){
    list($lat,$long) = mysqli_fetch_array($r,MYSQLI_NUM);
    $q = "SELECT name, CONCAT_WS('<br>', address1, address2), city, state, stores.zip_code, phone, 
    ROUND(return_distance($lat,$long,latitude,longitude)) AS distance FROM stores LEFT JOIN zip_codes USING (zip_code) ORDER BY distance ASC LIMIT 3";
//    $q = "SELECT name, CONCAT_WS('<br>', address1, address2), city, state, stores.zip_code, phone, ROUND(DEGREES(ACOS(SIN(RADIANS($lat))
//* SIN(RADIANS(latitude))
//+ COS(RADIANS($lat))
//* COS(RADIANS(latitude))
//* COS(RADIANS($long - longitude)))) * 69.09) AS distance FROM stores LEFT JOIN zip_codes USING (zip_code) ORDER BY distance ASC LIMIT 3";
    $r = mysqli_query($dbc,$q);

    if(mysqli_num_rows($r)>0){
        while($row = mysqli_fetch_array($r,MYSQLI_NUM)){
            echo "<h2>$row[0]</h2>
                <p>$row[1]<br/>".ucfirst(strtolower($row[2])).",$row[3] $row[4]<br/>$row[5]<br/>
                (approximately $row[6] miles)</p>\n";
        }
    }else{
        echo '<p class="error">No stores matched the search.</p>';
    }
}else{
    echo '<p class="error">An invalid zip code was entered.</p>';
}

?>
</body>

</html>
