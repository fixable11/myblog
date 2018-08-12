<?php


namespace app\components;

use Yii;

/**
 * Component for trimming text
 */
class Delimiter 
{
  /**
   * @var int limit of characters 
   */
  private $limit;
  
  public function __construct()
  {
    $this->limit = Yii::$app->params['textLimit'];
  }
  
  /**
   * 
   * @param string $text text for trimming
   * @param int $limit limit of characters
   * @return string the trimmed text
   */
  public function getShort($text, $limit = null)
  {
    if($limit === null){
      $limit = $this->limit;
    }
    if (strlen($text) <= $limit) {
        return $text;
    }
    $text = $text." ";
    $text = substr($text, 0, $limit);
    $text = substr($text, 0, strrpos($text, ' '));
    $text = $text."...";
    return $text;
  }
}
