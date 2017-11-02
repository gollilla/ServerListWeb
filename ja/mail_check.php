<?php
/**
 *
 * @param string $mail mail address
 *
 * @return string succece or false and error
 */


function checkUserData($mail)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=dbname;charset=utf8', 'user_name', 'password', array(PDO::ATTR_EMULATE_PREPARES => false));

        $stmt = $pdo -> prepare("SELECT * FROM users WHERE mail = :mail");
        $stmt -> bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt -> execute();
        $count = $stmt -> rowCount();
        if(0 == $count){
            return 'no_exists';
        }else{
            return 'ok';
        }
    } catch (PDOException $e) {
        exit('false');
    }
}
