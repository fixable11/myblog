<?php

namespace app\models\api;

use Yii;

/**
 * Description of FbApi
 *
 * @author Никита
 */
class FbApi
{
  private $token;
  
  public function __construct($token)
  {
    $this->token = $token;
  }

  public function getUid()
  {
    $params = array(
        'fields' => 'id',
        'access_token' => $this->token,
       );
    $graph_link = "https://graph.facebook.com/me?" . http_build_query($params); 
    $data = json_decode(file_get_contents($graph_link), true);
    if(!$data){
      throw new NotFoundHttpException('Ошибка доступа по API!');
    } else {
      return $data['id'];
    }
  }
  
  public function getFull()
  {
    $params = array(
        'fields' => 'email,first_name,last_name,picture.type(large),id',
        'access_token' => $this->token,
       );
    $graph_link = "https://graph.facebook.com/me?" . http_build_query($params); 
    $data = json_decode(file_get_contents($graph_link), true);
    $graph_link = "https://graph.facebook.com/me?fields=picture.width(50).height(50)";
    $graph_link .= '&access_token=' . $this->token;
    $photo_rec = json_decode(file_get_contents($graph_link), true);
    $data['photo_rec'] = $photo_rec['picture'];
    if(!$data){
      throw new NotFoundHttpException('Ошибка доступа по API!');
    } else {
      return $data;
    }
  }
  
    
}
