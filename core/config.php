<?php 
    session_start();
    require_once 'func.php';
    define('DB_HOST', 'localhost');
    define('DB_TABLE', 'assignment');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');

    try {
        $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_TABLE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    }
    catch (PDOException $e){
        die('<br/><center><font size="15">Could not connect with database</font></center>');
    }

 ?>