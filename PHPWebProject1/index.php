<?php
 

class HealthDBAPI {
    // Main method to redeem a code
    public $conn;
    public $stmt;
    function Connect($arg_1, $arg_3) {
        //1-connection info
        //
        //3-servername
        
        /* Connect using SQL Authentication. */

        try
        {
            $this->conn = sqlsrv_connect( $arg_3, $arg_1);

        }
        catch (Exception $exception)
        {
            echo "connection failed";
        }

        if( $this->conn )
        {
            echo "Connection established.\n";
        }
        else
        {
            echo "Connection could not be established.\n";
            die( print_r( sqlsrv_errors(), true));
        }

    }
    function multByFour($arg_1, $arg_2){
        $arg_1=$arg_1*4;
        $arg_2=$arg_2*4;
        
        echo "$arg_1"."  <br />";
        
        echo "$arg_2  ";
    }
    function RunQueery($Querry)
    {
        $this->stmt = sqlsrv_query( $this->conn, $Querry);

        if( $this->stmt === false )
        {
            echo "Error in executing query.</br>";
            die( print_r( sqlsrv_errors(), true));
        }
        
        //echo "".$row[0]."</br>";

        /* Free statement and connection resources. */
        

    }
    function PrintQueery()
    {
        for ($i = 0; $i <= 5; $i++) 
        {
            
            $row = sqlsrv_fetch_array($this->stmt);
            $count = 0 ;

            while ( $count <= 2 ){ 
                
                echo "</br>".$row[$count];
                $count++;
            }
        }  
        
    }
    function freeStmt()
    {
        sqlsrv_free_stmt( $this->stmt);
    }
    function CloseSQL()
    {
        sqlsrv_close($this->conn);
    }
    function getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );
        
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
    
    // Helper method to send a HTTP response code/message
    function sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . getStatusCodeMessage($status);
        header($status_header);
        header('Content-type: ' . $content_type);
        echo $body;
    }
}


// This is the first thing that gets called when this page is loaded
// Creates a new instance of the RedeemAPI class and calls the redeem method
$api = new HealthDBAPI;
//can be traded out with port number
//sqlsrv_connect('10.20.30.40', array('UID'=>'me', 'PWD'=>'pwd', ...)); // port number not required 

$serverName="99.120.147.8";
//connect using sql server authentication
$uid = "developer";
$pwd = "test1";


$connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=>"testdatabase1");
$api->Connect($connectionInfo,$serverName);

$tsql = "SELECT * FROM dbo.tblItWorked";

$api->RunQueery($tsql);
$api->PrintQueery();
$api->CloseSQL();
$api->freeStmt();

?>