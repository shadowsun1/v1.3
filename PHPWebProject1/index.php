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
            //die( print_r( sqlsrv_errors(), true));
            $errors = sqlsrv_errors();
            if( ($errors = sqlsrv_errors() ) != null) {
                foreach( $errors as $error ) {
                    //echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                    //echo "code: ".$error[ 'code']."<br />";
                    //echo "message: ".$error[ 'message']."<br />";
                }
            }
            die(print_r($error['message'],true));
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
        for ($i = 0; $i <= 20; $i++) 
        {
            
            $row = sqlsrv_fetch_array($this->stmt);
            $count = 0 ;
           
            
            if($row[$count] == NULL)
                break;
            echo "</br>";
            while ( $count <= 6 ){ 
                if($row[$count] == NULL)
                    break;
                
                echo"["; 
                echo $row[$count];
                $count++;
                echo "]";
                
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
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->getStatusCodeMessage($status);
        header($status_header);
        header('Content-type: ' . $content_type);
        echo $body;
    }
    
    function pushData()
    {
        // Check for required parameters
        //$_POST is a data field that is passed along with the URL c code style
        if (isset($_POST["PatientId"]) && isset($_POST["DataType"]) && isset($_POST["DataValue"])) {
            
            // Put parameters into local variables
            $PatientId = $_POST["PatientId"];
            $DataType = $_POST["DataType"];
            $DataValue = $_POST["DataValue"];
            
            echo $PatientId;
            echo $DataType;//pulse OR temp
            echo $DataValue;//test value for making sure the queries work
            
           
            $querryString='INSERT INTO [dbo].[HealthData] ([PatientId], [DataType], [DataValue], [DataTimeStamp]) VALUES ('.$PatientId.',N\''.$DataType.'\','.$DataValue.',SYSDATETIME())';
            echo $querryString;
            $this->RunQueery($querryString);
            $result = "succes";
            /*
             * curl -F "rw_app_id=1" -F "code=test" -F "device_id=test" http://www.wildfables.com/promos/
            {"unlock_code":"com.razeware.wildfables.unlock.test"}
             *call that is used in this program */
            // Look up code in database
            //$user_id = 0;
            //$stmt = $this->db->prepare('SELECT id, unlock_code, uses_remaining FROM rw_promo_code WHERE rw_app_id=? AND code=?');
            //$stmt->bind_param("is", $rw_app_id, $code);
            //$stmt->execute();
            //$stmt->bind_result($id, $unlock_code, $uses_remaining);
            //while ($stmt->fetch()) {
            //    break;
            //}
            //$stmt->close();
            //fail examples
            // Bail if code doesn't exist
            //if ($id <= 0) {
            //    sendResponse(400, 'Invalid code');
            //    return false;
            //}
            
            //// Bail if code already used		
           // if ($uses_remaining <= 0) {
            //    sendResponse(403, 'Code already used');
            //    return false;
            ///}	
            
            // Check to see if this device already redeemed	
            //$stmt = $this->db->prepare('SELECT id FROM rw_promo_code_redeemed WHERE device_id=? AND rw_promo_code_id=?');
            //$stmt->bind_param("si", $device_id, $id);
            //$stmt->execute();
            //$stmt->bind_result($redeemed_id);
            //while ($stmt->fetch()) {
            //    break;
            //}/
            //$stmt->close();
            
            // Bail if code already redeemed
            //if ($redeemed_id > 0) {
            //    sendResponse(403, 'Code already used');
            //    return false;
            //}
            
            //// Add tracking of redemption
            //$stmt = $this->db->prepare("INSERT INTO rw_promo_code_redeemed (rw_promo_code_id, device_id) VALUES (?, ?)");
            //$stmt->bind_param("is", $id, $device_id);
            //$stmt->execute();
            //$stmt->close();
            
            //// Decrement use of code
            //$this->db->query("UPDATE rw_promo_code SET uses_remaining=uses_remaining-1 WHERE id=$id");
            //$this->db->commit();
            
            //// Return unlock code, encoded with JSON
            //$result = array(
            //    "unlock_code" => $unlock_code,
            //);
            $this->sendResponse(200, json_encode($result));////sends back $result as a json ecndoed string
            return true;
        }
        //recieved unrecieved alerts
        else if (isset($_POST["RecieveAlerts"])&&isset($_POST["PatientId"]))
        {
            $PatientId = $_POST["PatientId"];
            
            $LastAlertRecieved = $_POST["Recieve Alerts"];
            
            $this->RunQueery('SELECT alertData FROM DBO.DoctorAlertData AS t WHERE t.PatientId = \''.$PatientId.'\' and t.AlertId >= \''.$LastAlertRecieved.'\'');
            $row1 = sqlsrv_fetch_array($this->stmt);
            
            
            //$this->PrintQueery();
            $result = "".$row1[0]."";
            $this->sendResponse(200, json_encode($result));////sends back $result as a json ecndoed string
            return true;
        }
        
        else if (isset($_POST["FirstName_LastName"])) {///create new patient ID
            if($_POST["FirstName_LastName"] == "")
            {
                echo "nothing inputted";
                $this->sendResponse(400, 'Invalid request');
                return false;
            }
           
            // Put parameters into local variables
            $PatientName = $_POST["FirstName_LastName"];
           
            
            echo $PatientName."</br>";
            //check to see if name is in datbase already
            $this->RunQueery('SELECT PrimaryID FROM DBO.UserData AS t WHERE t.FirstName_LastName = \''.$PatientName.'\'');
            $row = sqlsrv_fetch_array($this->stmt);
            if($row[0] != NULL)
            {
                
                $this->sendResponse(400, 'Invalid request: Name Already Exists');
                return false;
            }
            
            
            $this->freeStmt();
            $querryString='INSERT INTO [dbo].[UserData] ([FirstName_LastName]) VALUES (N\''.$PatientName.'\')';
            echo $querryString;
            
            $this->RunQueery($querryString);
            
            $this->freeStmt();
            
            $this->RunQueery('SELECT PrimaryID FROM DBO.UserData AS t WHERE t.FirstName_LastName = \''.$PatientName.'\'');
            $row = sqlsrv_fetch_array($this->stmt);
            echo "</br> YOUR NEW USER ID=";
            $result = "".$row[0]."";
            $this->sendResponse(200, json_encode($result));////sends back $result as a json ecndoed string
            return true;
        }
        
        //inserting alert data currently only works as a doctor login
        else if (isset($_POST["DoctorFirstName_LastName"])&&isset($_POST["DoctorPsw"])&&isset($_POST["AlertMessage"])&&isset($_POST["PatientId"])) {///create new patient ID
            if($_POST["DoctorFirstName_LastName"] == "")
            {
                echo "nothing inputted";
                $this->sendResponse(400, 'Invalid request');
                return false;
            }
            
            // Put parameters into local variables
            $DoctorName = $_POST["DoctorFirstName_LastName"];
            $DoctorPassword = $_POST["DoctorPsw"];
            $patientID = $_POST["PatientId"];
            $alertdatahold = $_POST["AlertMessage"];
            
            echo $DoctorName."</br>";
            echo $DoctorPassword;
            //check to see if name is in datbase already
            $this->RunQueery('SELECT DoctorID FROM DBO.DoctorData AS t WHERE t.FirstName_LastName = \''.$DoctorName.'\' AND t.Password = \''.$DoctorPassword.'\'');
            $row = sqlsrv_fetch_array($this->stmt);
            if($row[0] == NULL)
            {
                
                $this->sendResponse(400, 'Invalid request: Login issue');
                return false;
            }
            $doctorIDHold = $row[0];
            echo $doctorIDHold;
            
            $tsql = "SELECT SYSDATETIME()";
            $this->RunQueery($tsql);
            $row = sqlsrv_fetch_array($this->stmt);
            $date = $row[0];
            $dateTime = date_format($date, 'Y-m-d H:i:s');
            
            $this->freeStmt();
            //INSERT INTO [dbo].[DoctorAlertData] ( [alertData], [DateTime], [PatientId], [DoctorId]) VALUES ('testing message', SYSDATETIME(), 1, 1)
            //INSERT INTO [dbo].[DoctorAlertData] ( [alertData], [DateTime], [PatientId], [DoctorId]) VALUES ('testing message1', '2014-04-04 22:18:47', 1, 1)
            $querryString='INSERT INTO [dbo].[DoctorAlertData] ([alertData], [DateTime], [PatientId], [DoctorId]) VALUES (N\''.$alertdatahold.'\', \''.$dateTime.'\' ,\''.$patientID.'\',\''.$doctorIDHold.'\')';
            //echo $querryString;
            
            $this->RunQueery($querryString);
            $result = "success with inserting alert"; 
            $this->sendResponse(200, json_encode($result));////sends back $result as a json ecndoed string
            return true;
        }
        else if(isset($_POST["PullDataRequest"])&&isset($_POST["PatientIdPULL"]))
        {
            
            $IdHold = $_POST["PatientIdPULL"];
            echo "pulling DATA";
            if($_POST["PullDataRequest"] == "Pull_Health")
            {
               // echo "pulling health ";
                $tsql = 'SELECT Datatype, DataValue, DataTimeStamp FROM [dbo].[HealthData] AS t WHERE t.PatientId = \''.$IdHold.'\' ORDER BY DataTimeStamp ASC';
                //echo $tsql;
                $this->RunQueery($tsql);
                //echo "querry good";
                $result = "";
                $row = sqlsrv_fetch_array($this->stmt);
                 for ($i = 0; $i <= 200; $i++) 
                 {
                     $count = 0;
                    $row = sqlsrv_fetch_array($this->stmt);
                    if($row[$count] == NULL)
                            break;
                    $result= $result."</br>"."[".$row["Datatype"]."][".$row["DataValue"]."][".date_format($row["DataTimeStamp"], 'Y-m-d H:i:s')."]";
                    
                    
                    //while ( $count <= 20 ){ 
                    //    
                
                    //    $result= $result."["; 
                    //    try
                    //    {
                            
                    //        $result= $result.$row[$count];
                    //    }
                    //    catch(Exception $exception)
                    //    {
                    //        echo "caught error";
                    //        $result = $result.date_format($date, 'Y-m-d H:i:s');
                    //    }
                    //    $count++;
                    //    $result= $result."]";
                        
                    //}
                    //echo $result;
                }  
                 //echo "did reach send";
                 $this->sendResponse(200, json_encode($result));////sends back $result as a json ecndoed string
                 return true;
                
            }
        }
        
        $this->sendResponse(400, 'Invalid request');
        return false;
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
//$pwd = $_POST["SQLPSW"];



$connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=>"testdatabase1");
$api->Connect($connectionInfo,$serverName);
//echo "</br>health data";
//$tsql = "SELECT * FROM dbo.HealthData";
//$api->RunQueery($tsql);
//$api->PrintQueery();

//$api->freeStmt();

echo "</br>user data";
$tsql = "SELECT * FROM dbo.UserData";
$api->RunQueery($tsql);

$api->PrintQueery();

$api->freeStmt();

/*$tsql = "SELECT SYSDATETIME()";
$api->RunQueery($tsql);
$row = sqlsrv_fetch_array($api->stmt);
$date = $row[0];
echo date_format($date, 'Y-m-d H:i:s');


echo "</br>";
$api->freeStmt();*/
//$_POST["PullDataRequest"] = "Pull_Health";
//$_POST["PatientIdPULL"] = 5;
$api->pushData();

$api->freeStmt();



$api->CloseSQL();



?>