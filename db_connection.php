<?php
define('DB_SERVER', '127.0.0.1:3360');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'bank2');
try{
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
}
catch(Exception $e){
    echo $e->errorMessage();
}

?>