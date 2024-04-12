<?php
    
        $host = 'localhost';
        $dbname = 'applications';
        $username = 'postgres';
        $password = 'Zidane1010.,';
 
        $dsn = "pgsql:host=$host;port=5433;dbname=$dbname;";
   
        
        try{
        $conn = new PDO($dsn,$username,$password);
     
        if($conn){
         // savoir si la base est connecté echo " vous êtes Connectés ";//
        }
        }catch (PDOException $e){
        echo $e->getMessage();
        }

