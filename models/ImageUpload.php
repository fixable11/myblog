<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

/**
 * Description of ImageUpload
 *
 * @author Никита
 */
class ImageUpload extends Model
{

    public $image;

    public function rules()
    {
        return [
            
        ];
    }

    /**
     * Deletes the current image and upload a new one 
     * 
     * @param UploadedFile $file File to save
     * @param type $currentImage Current image
     * @return string Filename
     */
    public function uploadFile(UploadedFile $file, $currentImage)
    {
        $this->image = $file;

        if ($this->validate()) {   
            $this->deleteCurrentImage($currentImage);
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
        return Yii::getAlias('@web') . 'uploads/';
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
            unlink($this->getFolder() . $currentImage);
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

        $this->image->saveAs($this->getFolder() . $filename);
        
        return $filename;
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
            return file_exists($this->getFolder() . $currentImage);
        }
    }
    
    

}
