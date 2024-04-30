<?php 

$sName = getenv('DB_HOST');
$uName = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');
$db_name = getenv('DB_NAME');
$port = getenv('DB_PORT');

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", 
                    $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}
