<?php
 

class HealthDBAPI {
    // Main method to redeem a code
   
    function redeem() {
        echo "Hello, PHP!"."  <br />";
    }
    function multByFour($arg_1, $arg_2){
        $arg_1=$arg_1*4;
        $arg_2=$arg_2*4;
        
        echo "$arg_1"."  <br />";
        
        echo "$arg_2  ";
    }
   
}


// This is the first thing that gets called when this page is loaded
// Creates a new instance of the RedeemAPI class and calls the redeem method
$api = new HealthDBAPI;
$api->redeem();

$api->multByFour(3,5);

//can be traded out with port number
//sqlsrv_connect('10.20.30.40', array('UID'=>'me', 'PWD'=>'pwd', ...)); // port number not required 
$serverName="99.120.147.8";
//connect using sql server authentication
$uid = "developer";
$pwd = "test1";

$connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=>"testdatabase1");

/* Connect using Windows Authentication. */

try
{
	$conn = sqlsrv_connect( $serverName, $connectionInfo);

}
catch (Exception $exception)
{
    echo "connection failed";
}

if( $conn )
{
    echo "Connection established.\n";
}
else
{
    echo "Connection could not be established.\n";
    die( print_r( sqlsrv_errors(), true));
}

$tsql = "SELECT * FROM dbo.tblItWorked";
$stmt = sqlsrv_query( $conn, $tsql);

if( $stmt === false )
{
    echo "Error in executing query.</br>";
    die( print_r( sqlsrv_errors(), true));
}

/* Retrieve and display the results of the query. */
for ($i = 0; $i <= 5; $i++) 
{
    
    $row = sqlsrv_fetch_array($stmt);
    $count = 0 ;

    while ( $count <= 2 ){ 
        
        echo "</br>".$row[$count];
        $count++;
    }
}
//echo "".$row[0]."</br>";

/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);




sqlsrv_close( $conn);

?>