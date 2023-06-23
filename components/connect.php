<?php




$db_name = 'mysql:host=bzgj7qg3gbmwzm2nviqt-mysql.services.clever-cloud.com:3306;dbname=bzgj7qg3gbmwzm2nviqt';
$user_name = 'u3wtkgjilyxcs5vo';
$user_password = 'QJzjNS7xnHyy5AVZmOUu';

$conn = new PDO($db_name, $user_name, $user_password);

if (!$conn){
    die("Error". mysqli_connect_error());
}

?>