<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use app\models\Article;
use Yii;

/**
 * Uploads images to the Article model 
 */
class ImageUpload extends Model
{

  public $image;
  public $oldImage;
  public $model;

  public function rules()
  {
    return [

    ];
  }
  
  /**
   * Loads article model
   * 
   * @param app/models/Article $model model which file will be saved to
   */
  public function __construct(Article $model)
  {
    parent::__construct();
    $this->model = $model;
    $this->oldImage = $model->image;
  }

  /**
   * Deletes the current image and upload a new one 
   * 
   * @param UploadedFile $file File to save
   */
  public function uploadFile(UploadedFile $file)
  {
    $this->image = $file;

    if ($this->model->validate()) {   
      $this->deleteCurrentImage($this->oldImage);
      return $this->saveImage();
    }
  }

  /**
   * Gets the path to the downloaded files folder
   * 
   * @return string
   */
  public function getFolder()
  {
    return Yii::getAlias('@web') . Yii::$app->params['article_images_folder'];
  }

  /**
   * Generates random filename
   * 
   * @return string
   */
  public function generateFilename()
  {
    return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
  }

  /**
   * Deletes the current image
   * 
   * @param string $currentImage Current image
   */
  public function deleteCurrentImage($currentImage)
  {
    if ($this->fileExists($currentImage)) {
      unlink($this->getFolder(). $this->getArticleFolder() . $currentImage);
    }
  }

  /**
   * Saves the image
   * 
   * @return string $filename
   */
  public function saveImage()
  {
    $filename = $this->generateFilename();
    
    if(!$this->whetherArticleDirExists()){
      mkdir($this->getFolder() . $this->getArticleFolder());
    }

    $this->image->saveAs($this->getFolder() . $this->getArticleFolder() . $filename);
    
    $this->model->image = $filename;
    return $this->model->save(false);
  }
  
  /**
   * Checks whether article dir exists
   * 
   * @return boolean
   */
  public function whetherArticleDirExists()
  {
    if(file_exists($this->getFolder() . $this->getArticleFolder())){
      return true;
    }
    return false;
  }

  /**
   * Checks whether file exists
   * 
   * @param string $currentImage
   * @return bool
   */
  public function fileExists($currentImage)
  {
    if(!empty($currentImage) && $currentImage != null)
    {
      $path = $this->getFolder() . $this->getArticleFolder() .  $currentImage;
      return file_exists($path);
    }
  }
  
  /**
   * Gets the specific article folder
   * 
   * @return string
   */
  public function getArticleFolder()
  {
    return $this->model->id . '/';
  }

}
