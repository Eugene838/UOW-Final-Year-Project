<?php

class DB_Connect
{

    public function connect()
    {
        try {
            //Local Host DB connection settings
            // $localhost = "127.0.0.1";
            // $db = "dentianDatabase";
            // $username = "root";
            // $password = "";
            // $conn = new PDO('mysql:host=' . $localhost . '; charset=utf8mb4;dbname=' . $db, $username, $password);

            //Google cloud DB connection settings
            $ghost = "34.87.94.119";
            $gdb = "dentianDatabase";
            $gusername = "root";
            $gpassword = "r00tD3ntian@22";
            $conn = new PDO('mysql:host=' . $ghost . '; charset=utf8mb4;dbname=' . $gdb, $gusername, $gpassword);

            return $conn;
        } catch (PDOException $e) {
            print "Error: " . $e->getMessage() . "<br>";
            die();
        }
    }

    public function connectWix()
    {
        try {
            //Local Host DB connection settings
            // $localhost = "127.0.0.1";
            // $db = "wixDatabase";
            // $username = "root";
            // $password = "";
            // $conn = new PDO('mysql:host=' . $localhost . '; charset=utf8mb4;dbname=' . $db, $username, $password);

            //Local Host wixDatabase settings
            $ghost = "34.87.94.119";
            $gdb = "wixDatabase";
            $gusername = "root";
            $gpassword = "r00tD3ntian@22";
            $conn = new PDO('mysql:host=' . $ghost . '; charset=utf8mb4;dbname=' . $gdb, $gusername, $gpassword);

            return $conn;
        } catch (PDOException $e) {
            print "Error: " . $e->getMessage() . "<br>";
            die();
        }
    }
}
?>