<?php

class data{

    public $servers = [];
    public function __construct(){
        $this->connectDB();
    }

    public function connectDB(){


        $db['user'] = '';
        $db['pass'] = '';
        $db['db'] = '';
        $db['url'] = '';

        try {
            $pdo = new PDO('mysql:host='.$db['url'].';dbname='.$db['db'].';charset=utf8', $db['user'], $db['pass'], array(PDO::ATTR_EMULATE_PREPARES => false));
            $stmt = $pdo -> prepare("SELECT * FROM server_list");
            $stmt->execute();
            $result = $stmt->fetchAll();
            foreach($result as $re){
                //var_dump($re);
                $url = "https://list.pocketmp.xyz/Query/?ip=".$re['ip']."&port=".$re['port'];
                $res = file_get_contents($url);
                if($res != 'false' && $re['silent'] == 'off'){
                    $json = json_decode($res, true);
                    $max = $json["MaxPlayers"];
                    $now = $json["Players"];
                    $contents = strip_tags(htmlspecialchars_decode($re['contents'], ENT_QUOTES), '<br><a><h1><h2><h3><h4><p><font>');
                    $this->servers[] = [
                                  'players' => $now,
                                  'max' => $max, 
                                  'name' => $re['name'],
                                  'contents' => $contents,
                                  'owner' => $re['owner']
                                 ];
                }else{
                    return false;
                  }
            }
         } catch (PDOException $e) {

         }
    }


    public function getInfo()
    {
        return $this->servers;
    }

}

?>
