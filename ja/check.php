<?php

$host = $_SERVER['HTTP_REFERER'];
$str = parse_url($host);
if(stristr($str['host'], "list.pocketmp.xyz") == false) exit('false');
if(isset($_POST['ip']) && isset($_POST['mail']) && isset($_POST['port']) && isset($_POST['pass']) && isset($_POST['uniq'])){

    $ip = $_POST['ip'];
    $port = $_POST['port'];
    $pass = $_POST['pass'];
    $uniq = $_POST['uniq'];
    $mail = $_POST['mail'];
    $url = 'https://list.pocketmp.xyz/Query/?ip='.$ip.'&port='.$port;
    $result = file_get_contents($url);
    if($result == 'false'){
        exit('false');
    }else{
        $json = json_decode($result, true);
        $server_name = $json['HostName'];
        if($server_name == $uniq){
            setUserData($mail, $pass);
        }else{
            exit('inva');
         }
    }
}else{
    exit('false');
}

/**
 *
 * @param string $mail mail address
 * @param string $pass password
 *
 * @return string succece or false and error
 */

function setUserData($mail, $pass)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=dbname;charset=utf8', 'user', 'password', array(PDO::ATTR_EMULATE_PREPARES => false));

        $stmt = $pdo -> prepare("SELECT * FROM users WHERE mail = :mail");
        $stmt -> bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt -> execute();
        $count = $stmt -> rowCount();
        if(0 < $count){
            exit('mail_already_exists');
         }
        $stmt = $pdo -> prepare("INSERT INTO users (mail, pass) VALUES (:mail, :pass)");
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        exit('false');
    }
    exit('success');
}
?>
