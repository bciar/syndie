<?php

namespace app\models;

use Yii;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $head_back_colour
 * @property string $head_fore_colour
 * @property string $head_logo_path
 * @property string $head_back_img_path
 * @property string $main_back_colour
 * @property string $main_fore_colour
 * @property string $main_back_img_path
 * @property string $share_logo_path
 * @property integer $user_id
 * @property string $title
 * @property string $slogan
 * @property array $images
 *
 * @property User $user
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * Get images available for upload attributes
     * @return array
     */
    public function getImages()
    {
        return ['head_logo_path', 'head_back_img_path', 'main_back_img_path', 'share_logo_path'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        $mb = 1024000;
        return [
            [['head_back_colour', 'head_fore_colour', 'main_back_colour', 'main_fore_colour'], 'string', 'max' => 10],
            [['title', 'slogan'], 'string', 'max' => 200],

            [$this->getImages(), 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => $mb * 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'head_back_colour' => Yii::t('app', 'Head Back Colour'),
            'head_fore_colour' => Yii::t('app', 'Head Fore Colour'),
            'head_logo_path' => Yii::t('app', 'Head Logo Path'),
            'head_back_img_path' => Yii::t('app', 'Head Back Img Path'),
            'main_back_colour' => Yii::t('app', 'Main Back Colour'),
            'main_fore_colour' => Yii::t('app', 'Main Fore Colour'),
            'main_back_img_path' => Yii::t('app', 'Main Back Img Path'),
            'share_logo_path' => Yii::t('app', 'Share Logo Path'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'slogan' => Yii::t('app', 'Slogan'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            foreach ($this->getImages() as $attribute) {
                if (is_object($this->$attribute)) {
                    /**
                     * @var $image UploadedFile
                     */
                    $image = $this->$attribute;

                    $name = str_replace('_img_path', '', $attribute);
                    $save_path = Yii::getAlias("@webroot/images/brand/{$name}_{$this->id}.jpg");

                    $path = Yii::getAlias("@web/images/brand/{$name}_{$this->id}.jpg");

                    if ($image->type == 'image/jpeg') {
                        $img = imagecreatefromjpeg($image->tempName);
                    } elseif ($image->type == 'image/gif') {
                        $img = imagecreatefromgif($image->tempName);
                    } elseif ($image->type == 'image/png') {
                        $img = imagecreatefrompng($image->tempName);
                    } else {
                        throw new ServerErrorHttpException('Unknown image file format');
                    }

                    //compress and save file to jpg
                    imagejpeg($img, $save_path, 75);

                    $this->$attribute = $path;
                }
            }


            return true;
        } else {
            return false;
        }
    }
}
