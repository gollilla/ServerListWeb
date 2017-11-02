<?php

if(!isset($_POST["mail"]) || !isset($_POST["pass"])){
    header("Refresh: 5; url=reg_mirm.html");
    exit("値が不正です、５秒後にStep.1に戻ります");
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Step.2</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/load.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
    <a href="index.html" class="navbar-brand">ServerList</a>
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
        <div class="col-md-8 col-md-offset-2">
          <div class="progress progress-striped active">
            <div class="progress-bar" style="width: 67%">2/3</div> 
          </div>
            <p><a href='http://jp.mirm.info/panel' target='_blank'>MiRm</a> のコンソールからアクセスキーを取得し、認証を行ってください。</p> 
            <form method="post">
              <div class="form-group">
                <label>AccessKey</label>
                <input type="text" id="key" class="form-control">
                <input type="hidden" name="mail" value="<?=$mail?>">
                <input type="hidden" name="pass" value="<?=$pass?>">
              </div>
              <button id='send' type="submit">認証</button>
           </form>
         <div id='result'></div>
       </div>
     </div>
    </div>
  <script>
$(document).ready(function() {

  //送信ボタンをクリック
  $('#send').click(function(){

    //POSTメソッドで送るデータを定義する
    //var data = {パラメータ : 値};
    var data = {'key' : $('#key').val(),
                'mail' : $(':hidden[name="mail"]').val(),
                'pass' : $(':hidden[name="pass"]').val()
               };
    //Ajax通信メソッド
    //type : HTTP通信の種類(POSTとかGETとか)
    //url  : リクエスト送信先のURL
    //data : サーバに送信する値
    $.ajax({
      type: "POST",
      url: "auth.php",
      data: data,
      //Ajax通信が成功した場合に呼び出されるメソッド
      success: function(data, dataType){
            switch(data){
                  case 'inva':
                      $('#result').html("<p><font color='red'>認証に失敗しました</font></p>");
                  break;
 
                  case 'false':
                      $("#result").html("<p><font color='red'>エラー</font></p>");
                  break;

                  case 'mail_already_exists':
                      $("#result").html("<p><font color='red'>そのメールアドレスは登録済みです</font></p>");
                  break;

                  case 'success':
                         alert("認証されました\nログインしてください");
                         location.href = './login.html';
                  break;
                  default:
                      $("#result").html("<p><font color='red'>エラー</font></p>");
              }
      },
      //Ajax通信が失敗した場合に呼び出されるメソッド
      error: function(XMLHttpRequest, textStatus, errorThrown){
        alert('Error : ' + errorThrown);
      }
    });
    return false;
  });
});

</script>
  </body>
</html>
