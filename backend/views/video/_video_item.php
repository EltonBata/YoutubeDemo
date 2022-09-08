<?php
/* @var $model common\models\Video */
use \yii\helpers\StringHelper;
?>

<div class="media">
    <div class="embed-responsive embed-responsive-16by9 mr-3" style="width: 120px">
    <video src="<?php echo $model->getVideoLink(); ?>" class="embed-responsive-item" controls
        poster="<?php echo $model->getThumbLink(); ?>"
    ></video>
</div>
    <img src="" class="mr-3" alt="">
    <div class="media-body">
        <h6 class="mt-0"><?php echo $model->title; ?></h6>
        <?php echo StringHelper::truncateWords($model->description, 4)?>
    </div>
</div>