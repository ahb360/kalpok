<?php
namespace kalpok\file\widgets\singleupload;

use Yii;

class SingleFileUpload extends FileUpload
{
    public function run()
    {
        $uploadedFiles = $this->model->getFiles($this->group);
        return $this->render(
            'singleFile',
            [
                'model' => $this->model,
                'uploadedFiles' => $uploadedFiles,
                'fileObject' => $this->createFileObject(),
                'inputDisplay' => (!empty($uploadedFiles)) ? 'none' : '',
                'uniqueId' => Yii::$app->getSecurity()->generateRandomString(3)
            ]
        );
    }
}
