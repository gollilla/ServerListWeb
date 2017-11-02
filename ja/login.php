<?php

require 'mail_check.php';

session_start(); 

$db['user'] = '';
$db['pass'] = '';
$db['table'] = '';
$db['db'] = '';
$db['url'] = '';

if(isset($_POST['mail']) && isset($_POST['pass'])){

    $mail = $_POST['mail'];
    $pass = $_POST['pass'];
    $result = checkUserData($mail);
    switch($result){

       case 'ok':
       break;
    
       case 'no_exists':
           header('Refresh:5; url=login.html');
           exit("登録されていません");
       break;

       default:

    }
    

    try {
        $pdo = new PDO('mysql:host='.$db['url'].';dbname='.$db['db'].';charset=utf8', $db['table'], $db['pass'], array(PDO::ATTR_EMULATE_PREPARES => false));

        $stmt = $pdo -> prepare("SELECT * FROM users WHERE pass = :pass");
        $stmt -> bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt -> execute();
        $c = 0;
        $r_pass = '';
        /*foreach($result as $row){
            $row['pass']; 
         }*/
        $re = $stmt->fetch(PDO::FETCH_ASSOC);
        if($pass === $re['pass']){
            $_SESSION['mail'] = $mail;
            header('Location: mypage');
            exit;
        }else{
            exit('パスワードがちがいます');
         }
            
    } catch (PDOException $e) {
        exit('false');
    }
}else{
    header('Refresh:3; url=https://list.pocketmp.xyz');
    exit("<font color='red'>不正なアクセス</font>");
}
