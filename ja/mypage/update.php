<?php

if(!isset($_POST["mail"]) || !isset($_POST["ip"]) || !isset($_POST['contents']) || !isset($_POST['port']) || !isset($_POST['silent']) || !isset($_POST['owner']) || !isset($_POST['name'])){
    exit('no_data');
}else{

    $db['user'] = '';
    $db['pass'] = '';
    $db['db'] = '';
    $db['url'] = '';

    $mail = $_POST['mail'];
    $ip = $_POST['ip'];
    $port = $_POST['port'];
    $contents = $_POST['contents'];
    $silent = $_POST['silent'];
    $owner = $_POST['owner'];
    $name = $_POST['name'];

try {
        $pdo = new PDO('mysql:host='.$db['url'].';dbname='.$db['db'].';charset=utf8', $db['user'], $db['pass'], array(PDO::ATTR_EMULATE_PREPARES => false));

        $stmt = $pdo -> prepare("SELECT * FROM server_list WHERE mail = :mail");
        $stmt -> bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt -> execute();
        $count = $stmt -> rowCount();
        if(0 < $count){
            $stmt = $pdo->prepare("UPDATE server_list SET name = :name, ip = :ip, port = :port, owner = :owner, contents = :contents, silent = :silent WHERE mail = :mail");
            $param = [":name" => $name, ":ip" => $ip, ":port" => $port, ":owner" => $owner, ":mail" => $mail, ":contents" => $contents, ":silent" => $silent];
            $stmt->execute($param);
        }else{
            $stmt = $pdo->prepare("INSERT INTO server_list (name, ip, port, owner, mail, contents, silent) VALUES (:name, :ip, :port, :owner, :mail, :contents, :silent)");
            $param = [":name" => $name, ":ip" => $ip, ":port" => $port, ":owner" => $owner, ":mail" => $mail, ":contents" => $contents, ":silent" => $silent];
            $stmt->execute($param);
        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }

    exit('true');
}


?>
