<?php

namespace common\models;

use Imagine\Image\Box;
use Symfony\Component\DomCrawler\Image;
use Yii;
use yii\base\Exception;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%video}}".
 *
 * @property string $video_id
 * @property string $title
 * @property string|null $description
 * @property string|null $tags
 * @property int|null $status
 * @property int|null $has_thumbnail
 * @property string|null $video_name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 */
class Video extends \yii\db\ActiveRecord
{

    const STATUS_UNLISTED = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * @var UploadedFile
     */

    public $videoF;

     /**
     * @var UploadedFile
     */

    public $thumbnail;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,//atribui valores ao created at e updated at,
            [
                'class' => BlameableBehavior::class,//atribui valor created by e updated by
                'updatedByAttribute' => false
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'title'], 'required'],
            [['description'], 'string'],
            [['status', 'has_thumbnail', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['video_id'], 'string', 'max' => 16],
            [['title', 'tags', 'video_name'], 'string', 'max' => 512],
            [['video_id'], 'unique'],
            ['has_thumbnail', 'default', 'value' => 0],
            ['status', 'default', 'value' => self::STATUS_UNLISTED],
            ['videoF', 'file', 'extensions' => ['mp4']],
            ['thumbnail', 'image', 'minWidth' => 1280]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'title' => 'Title',
            'description' => 'Description',
            'tags' => 'Tags',
            'status' => 'Status',
            'has_thumbnail' => 'Thumbnail',
            'video_name' => 'Video Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',

        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\VideoQuery(get_called_class());
    }

    /**
     * @throws Exception
     */
    public function save($runValidation = true, $attributeNames = null)
     {
         $isInsert = $this->isNewRecord;

         if ($isInsert){
             $this->video_id = Yii::$app->security->generateRandomString(8);
             $this->title = $this->videoF->name;
             $this->video_name = $this->videoF->name;
         }

         if($this->thumbnail){
             $this->has_thumbnail = 1;
         }


         $saved = parent::save($runValidation, $attributeNames);//return true if saved && false if there's errors

         if (!$saved){
             return false;
         }

         if ($isInsert){
             $videoPath = Yii::getAlias('@frontend/web/storage/videos/'.$this->video_id.'.mp4');

             if (!is_dir(dirname($videoPath))){
                 FileHelper::createDirectory($videoPath);
             }

             $this->videoF->saveAs($videoPath);
         }

         if ($this->thumbnail){
             $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbs/'.$this->video_id.'.jpg');

             if (!is_dir(dirname($thumbnailPath))){
                 FileHelper::createDirectory($thumbnailPath);
             }

             $this->thumbnail->saveAs($thumbnailPath);
             \yii\imagine\Image::getImagine()
                 ->open($thumbnailPath)
                 ->thumbnail(new Box(1280, 1280))
                 ->save();
         }

         return true;
     }

     public function getVideoLink(){

         return Yii::$app->params['frontendUrl']. 'storage/videos/'.$this->video_id.'.mp4';
     }

      public function getThumbLink(){

         return $this->has_thumbnail ? Yii::$app->params['frontendUrl']. 'storage/thumbs/'.$this->video_id.'.jpg':"";
     }

     public function getStatusLabels(){
         return[
             self::STATUS_UNLISTED => 'Unlisted',
             self::STATUS_PUBLISHED => 'Published'
         ];
     }
}
