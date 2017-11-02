<?php

require 'data.php';
$data = new data();
session_start();

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Refresh" content="20" />
    <meta name="description" content="このサイトはPMMPのサーバーリストです。どなたでも無料で利用できます。" />
    <meta name="keywords" content="pmmp,ServerList,PocketMine-MP,MCPE,MinecraftPE,マルチプレイ,Japan,日本" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Minecraft PE ServerList | Japan</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="alternate" hreflang="ja" href="https://list.pocketmp.xyz/ja" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
    <a href="#" class="navbar-brand">ServerList</a>
    <div class='container'>
     <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#gnavi">
      <span class="sr-only">メニュー</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
     </div>
  
  <div id="gnavi" class="collapse navbar-collapse">
     <ul class="nav navbar-nav navbar-left">
      <li><a href="http://pocketmp.xyz">API</a></li>
      <li><a href="http://pocketmp.xyz">開発者用</a></li>
    </ul>
 
    <ul class="nav navbar-nav navbar-right">
      <li><a href="http://list.pocketmp.xyz">トップページ</a></li>
      <li><a href="register1.html">登録</a></li>
      <li><a href="login.html">ログイン</a></li>
      <li><a href='reg_mirm.html'>MiRm</a></li>
    </ul>
  </div>
  </div>
</nav>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
   

    <div class="container" style="margin : 90px 0;">
     <div class="row">
        <div class="col-md-6 col-md-offset-3">
         </html>
          <?php
         if(!isset($_SESSION['load'])){
             echo "<a href='http://mirm.info' target='_blank'><div class='alert alert-info alert-dismissible' role='alert'>";
             echo "<button type='button' class='close' data-dismiss='alert' aria-label='閉じる'><span ara-hiddn='true'><font color='red' size='5em'>閉</font></span></button>";
             echo "<strong>お知らせ:</strong>";
             echo "           <p>MiRmを使ってみませんか？</p>";
             echo "           MiRmは無料でサーバーを構築することができます。";
             echo "</div></a>";
          }
              if(count($data->getInfo()) == 0){
                  echo "開いているサーバーがありません";
              }else{
                  foreach($data->getInfo() as $info){
                      echo "<div class='panel panel-info'>";
 	               echo "<div class='panel-heading'>";
                      echo "<font size='5em'>".$info['name']."</font><div class='pull-right'>".$info['players']."/".$info['max']."</div>";
	               echo "</div>";
	               echo "<div class='panel-body'>";
                      echo "Owner : ".$info['owner']."<br>";
		        echo $info['contents'];
	               echo "</div>";
                      echo "</div>";
                    }
                }
            $_SESSION['load'] = $_SERVER['REMOTE_ADDR'];
           ?>
<html>

        </div>
     </div>
    </div>
    
  </body>
</html>
