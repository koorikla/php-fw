<?php
$headers = apache_request_headers();

foreach ($headers as $header => $value) {
    echo "$header: $value <br />\n";
}
//curl --header "X-MyHeader: 123" localhost:8080
?>

<?php

$host = getenv('postgre_host');
$user = getenv('postgre_user'); 
$pass = getenv('postgre_pass'); 
$db = getenv('postgre_db'); 
$alertemail = getenv('alerts_email'); 

$db_handle = pg_connect("host=$host dbname=$db user=$user password=$pass");

if ($db_handle) {

echo 'Connection attempt succeeded.';

$path_only = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
echo $path_only;

} else {  
echo 'Connection attempt failed.';

}

echo "<h3>Connection Information</h3>";
echo "DATABASE NAME:" . pg_dbname($db_handle) . "<br>";
echo "HOSTNAME: " . pg_host($db_handle) . "<br>";
echo "PORT: " . pg_port($db_handle) . "<br>";
echo "Connect url:" . $_SERVER['REMOTE_ADDR'] . "<br>";

echo "<h3>Checking the query status</h3>";

$query = "SELECT IP_str, created_on, id, URI FROM IP";


$result = pg_exec($db_handle, $query);


if ($result) {

echo "The query executed successfully.<br>";

echo "<h3>Print IP's:</h3>";

for ($row = 0; $row < pg_num_rows($result); $row++) {


$userID = pg_fetch_result($result, $row, 'id');
echo $userID ." ";    

$IP = pg_fetch_result($result, $row, 'IP_str');
echo $IP ." ";

$path = pg_fetch_result($result, $row, 'URI');
echo $path ." ";

$date = pg_fetch_result($result, $row, 'created_on');

echo $date ."<br>";



}

} else {

echo "The query failed with the following error:<br>";

echo pg_errormessage($db_handle);

}

pg_close($db_handle);

?>





