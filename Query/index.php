<?php

require 'MinecraftQuery.php';

if(isset($_GET['ip']) && isset($_GET['port'])){
    $ip = $_GET['ip'];
    $port = $_GET['port'];
    $query = new MinecraftQuery();
    $query->Connect($ip, $port);
     
    $info = $query->getInfo();
    echo json_encode($info, JSON_PRETTY_PRINT);
}else{
    echo 'false';
}
?>
