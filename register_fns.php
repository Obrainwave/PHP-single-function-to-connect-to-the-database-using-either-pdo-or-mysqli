<?php

require_once "config.php";

 define("TYPE", "mysqli");         // Database connection type(you may use mysqli)
 define("HOST", "localhost") ;  // Hostname
 define("DATABASE", "test");// Your database name
 define("USERNAME", "root");   // Database username
 define("PASSWORD", "");   // Database password

//Function to register new user to database if database connection type is mysqli
function mysqliRegister($name, $email, $password)
// register new person with db
// return true or error message
{
    // connect to db
    $conn = dbConnect(HOST, USERNAME, PASSWORD, DATABASE, TYPE);
    try{
        
        // Check for unique email
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            throw new Exception("<div class='content'>That email you provided is taken. Go <a href='../templates/index.php'>back</a> and choose another one.</div>") ;
        }
       
        $costs = [
            'cost' => 12,
        ];
        $pass = PASSWORD_HASH($password, PASSWORD_BCRYPT, $costs);
        $sql = $conn->prepare("INSERT INTO users(name, email, password) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $name, $email, $pass);
        $result = $sql->execute();
        if($result){
            return true;
        }else{
            echo "Not successful";
        }
        
       
    }catch(Exception $e){
        echo $e->getMessage();
    }
}


//Function to register new user to database if database connection type is mysqli
function pdoRegister($name, $email, $password)
// register new person with db
// return true or error message
{
    // connect to db
    $conn = dbConnect(HOST, USERNAME, PASSWORD, DATABASE, TYPE);
    try{
        // check if username is unique
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt -> fetch();
        
        if ($result > 0){
            throw new Exception("<div class='content'>That email is taken. Go back and choose another one.</div>") ;
        }
        $costs = [
            'cost' => 12,
        ];
        $pass = PASSWORD_HASH($password, PASSWORD_BCRYPT, $costs);
        $sql = $conn->prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :pass)");
        $sql->bindParam(':name', $name);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':pass', $pass);
        $result = $sql->execute();

        if($result){
            return true;
        }else{
            echo "Not successful";
        }
    
       
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    return true;
}