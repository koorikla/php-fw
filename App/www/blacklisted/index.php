<?php 

$host = getenv('postgre_host');
$user = getenv('postgre_user'); 
$pass = getenv('postgre_pass'); 
$db = getenv('postgre_db'); 
$alertemail = getenv('alerts_email'); 


//Connect to postgre and create a table for IP's if it dosen't exist
$db_handle = @pg_connect("host=$host dbname=$db user=$user password=$pass");
if ($db_handle) {} else { echo 'Connection attempt to relational db failed.'; }
$query = "CREATE TABLE IF NOT EXISTS IP(id serial PRIMARY KEY, IP_str VARCHAR ( 50 ) UNIQUE NOT NULL, URI VARCHAR ( 50 ) NOT NULL, created_on TIME)";  
@pg_query($db_handle, $query) or die("Cannot execute query: $query\n"); 


//Connect to postgre and query for blocked IP's
$query = "SELECT IP_str, created_on, id FROM IP";
$result = pg_exec($db_handle, $query);
$blacklist=array();

//Put the blocked IP's into a array
if ($result) {
for ($row = 0; $row < pg_num_rows($result); $row++) {
$IP = pg_fetch_result($result, $row, 'IP_str');
array_push($blacklist, $IP);
}

//print_r($blacklist);


} else {
echo "The query failed with the following error:<br>";
echo pg_errormessage($db_handle);
}
pg_close($db_handle);



//array of blocked ip's for testing
//$deny = array("111.111.111", "222.222.222", "333.333.333"); 

$deny = $blacklist;


//Check if the ip is already blocked
if (in_array ($_SERVER['REMOTE_ADDR'], $deny)) {

    //If the user is blocked respond 444
    header("HTTP/1.1 444 Connection Closed Without Response");
   exit();
}
else{
    //If the ip is not blocked respond 444 and extra steps
    header("HTTP/1.1 444 Connection Closed Without Response");    
    $db_handle = @pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n"); 

    //Get the visitor ip, path and request date
    $visitor = $_SERVER['REMOTE_ADDR'];
    $path_only = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $date = date("Y-m-d:H:i:s");

    //Send out email alert
    $message = "IP=$visitor\r\nPath=$path_only\r\nBlocked at=$date";
    $message = wordwrap($message, 70, "\r\n");
    @mail($alertemail, 'Blocked', $message);


    //Add the user IP to postgresql blacklist table
    $query = "INSERT INTO IP(IP_str, URI, created_on) VALUES('$visitor', '$path_only' , '$date')"; 
    @pg_query($db_handle, $query); 
    @pg_close($db_handle);
    exit();

} ?>