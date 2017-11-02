<?php

session_start();


if(!isset($_SESSION['mail'])){
    header('Location: https://list.pocketmp.xyz');
}
$mail = $_SESSION['mail'];




?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>マイページ</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
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
      <li><a href="#">ログイン</a></li>
      
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

            <form method="post">
              <div class="form-group">
                <label>サーバー名</label>
                <input type="text" id="server_name" class="form-control">
              </div>
              <div class="form-group">
                <label>ip</label>
                <input type="text" id="ip" class="form-control">
              </div>
              <div class="form-group">
                <label>port</label>
                <input type="text" id="port" class="form-control">
              </div>
              <div class="form-group">
                <label>owner name</label>
                <input type="text" id="owner_name" class="form-control">
              </div>
              <p> シークレットモード  <input type="checkbox" value="on" id="silent">  ※チェックをいれるとリストに表示されなくなります</p>
              <div class="form-group">
                <label>説明 (htmlタグを使用できます)</label>
                <textarea id="contents" class="form-control" style="height: 200px"></textarea>
              </div>
              <input type='hidden' id='mail' value="<?=$mail?>">
              
              <button id='hozon' type="submit">保存</button>
           </form>
         <div id='error'></div>
       </div>
     </div>
    </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.js"></script>


<script>
$(document).ready(function() {

  //送信ボタンをクリック
  $('#hozon').click(function(){
   if(($('#server_name').val() == "") || ($('#ip').val() == "") || ($('#port').val() == "") || ($('#owner_name').val() == "") || ($('#contents').val() == "")){
       $('#error').html("<p><font color='red'>未記入の部分があります</font></p>");
       return false;
   }else{
    
    if ($('#silent').prop('checked')) {
        var silent = 'on';
    }else{
        var silent = 'off';
    }
    //POSTメソッドで送るデータを定義する
    //var data = {パラメータ : 値};
    
    var contents = nl2br($('#contents').val());
    contents = escape_html(contents);
    var data = {'ip' : $('#ip').val(),
                'port' : $('#port').val(),
                'silent' : silent,
                'name' : $('#server_name').val(),
                'owner' : $('#owner_name').val(),
                'contents' : contents,
                'mail' : $('#mail').val()
               };
    //Ajax通信メソッド
    //type : HTTP通信の種類(POSTとかGETとか)
    //url  : リクエスト送信先のURL
    //data : サーバに送信する値
    $.ajax({
      type: "POST",
      url: "update.php",
      data: data,
      //Ajax通信が成功した場合に呼び出されるメソッド
      success: function(data, dataType){
        //デバッグ用 アラートとコンソール
        //出力する部分
        alert('保存しました');
      },
      //Ajax通信が失敗した場合に呼び出されるメソッド
      error: function(XMLHttpRequest, textStatus, errorThrown){
      }
    });
    return false;
   }
  });
});



function escape_html (string) {
  if(typeof string !== 'string') {
    return string;
  }
  return string.replace(/[&'`"<>]/g, function(match) {
    return {
      '&': '&amp;',
      "'": '&#x27;',
      '`': '&#x60;',
      '"': '&quot;',
      '<': '&lt;',
      '>': '&gt;',
    }[match]
  });
}

function nl2br(str){
    str = str.replace(/\r\n/g, "<br />");
    str = str.replace(/(\n|\r)/g, "<br />");
    return str;
}

function br2nl(str){
    return str.replace(/(<br>|<br \/>)/gi, '\n');
}
</script>
  </body>
<?php


$db['user'] = '';
$db['pass'] = '';
$db['table'] = '';
$db['db'] = '';
$db['url'] = '';

try {
        $pdo = new PDO('mysql:host='.$db['url'].';dbname='.$db['db'].';charset=utf8', $db['user'], $db['pass'], array(PDO::ATTR_EMULATE_PREPARES => false));

        $stmt = $pdo -> prepare("SELECT * FROM server_list WHERE mail = :mail");
        $stmt -> bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt -> execute();
        $count = $stmt -> rowCount();

        $ip = "";
        $name = "";
        $port = "";
        $owner = "";
        $silent = "";
        $contents = "";
        if(0 < $count){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $ip = $result['ip'];
            $port = $result['port'];
            $name = $result['name'];
            $owner = $result['owner'];
            $silent = $result['silent'];
            $contents = $result['contents'];
         }
            /*echo "<script>"; 
            echo "$(#server_name).val(".$result['name'].");";
            echo "$(#ip).val(".$result['ip'].");";
            echo "$(#port).val(".$result['port'].");";
            echo "$(#owner_name).val(".$result['owner'].");";
            if($result['silent'] == 'on'){
                echo "(#silent).prop('checked', true);";
            }elseif($result['silent'] == 'off'){
                echo "(#silent).prop('checked', false);";
             }
            if(!empty($result['contents'])){
                $contents = htmlspecialchars($result['contents']);
                echo "$(#contents).val(".$contents.");";
            }
            echo "</script>";*/
            
    } catch (PDOException $e) {
        exit('false');
    }
?>
<script>
$("#server_name").val("<?=$name?>");
$("#ip").val("<?=$ip?>");
$("#port").val("<?=$port?>");
var db_silent = "<?=$silent?>";
if(db_silent == "on"){
    $("#silent").prop('checked', true);
}else{
    $("#silent").prop('checked', false);
}
$("#owner_name").val("<?=$owner?>");
var db_contents = br2nl("<?=strip_tags(htmlspecialchars_decode($contents, ENT_QUOTES), '<br><a><h1><h2><h3><h4><p><font>')?>");
$('#contents').val(db_contents);
</script>

</html>
