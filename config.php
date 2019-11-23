<?php

function dbConnect($dbhost, $dbuser, $dbpass, $dbname, $contype=null){
    if($contype == "pdo"){
        try{

        $con = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
            if($con){
                //echo "PDO Connected";
                return $con;
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
            
        }
    }elseif($contype == "mysqli"){
        try{
            
            $con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            $status = "DB Connected";
            if($con){
                //echo "MYSQLi Connected";
                return $con;
                
            }
            mysqli_close($con);
            
        }catch(Exception $e){
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }else{
        try{

        $con = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        if($con){
            //echo "PDO Connected";
            return $con;
        }
        }catch(PDOException $e) {
            error_log($e-getMessage());
            exit('A fatal error in connection. Please try again later');
            
        }
    }



}