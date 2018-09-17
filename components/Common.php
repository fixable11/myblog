<?php


namespace app\components;

use Yii;

/**
 * Component for trimming text
 */
class Common 
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
   * The method shortens the text to a certain one
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
  
  /**
   * 
   * @param type $number
   * @param type $titles 
   */
  public function ru_plural($number, $titles)
  {
      $cases = array (2, 0, 1, 1, 1, 2);
      $elem = $number % 100 > 4 && $number % 100 < 20 ? 2 : $cases[min($number % 10, 5)];
      return $titles[$elem];
  }
  
}
