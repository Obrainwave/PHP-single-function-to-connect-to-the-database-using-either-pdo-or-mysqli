<?php

// include function file here
require_once('register_fns.php');
//create short variable names

$email=$_POST['email'];
$name=$_POST['name'];
$password=$_POST['password'];

try
{
    if(pdoRegister($name, $email, $password)){

        echo "Operation successful";
        
    }else{
        echo "Oops! An error occurred";
    }
   
}
catch (Exception $e)
{
	
    echo $e->getMessage();
  
exit;
}

