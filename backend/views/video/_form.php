<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var yii\bootstrap4\ActiveForm $form */

\backend\assets\TagsInputAssets::register($this);
?>

<div class="video-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">

        <div class="col-sm-8">

            <?php echo $form->errorSummary($model)?>

             <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?php echo $model->getAttributeLabel('thumbnail'); ?>
                <div class="custom-file">
                     <input type="file" name="thumbnail" class="custom-file-input" id="thumbnail">
                     <label class="custom-file-label" for="thumbnail">Choose Thumbnail</label>
                </div>
                <?php if($model->has_thumbnail){ ?>
                 <div class="my-3 thumb">
                    <img src="<?php echo $model->getThumbLink(); ?>" class="img-fluid img-thumbnail"></img>
                </div>
                <?php } ?>

            </div>

            <?= $form->field($model, 'tags',[
                    'inputOptions' => ['data-role' => 'tagsinput']
            ])->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-sm-4">
            <div class="mb-3">
                <p class="text-muted mb-0">Video Name</p>

                <?php echo $model->video_name; ?>
            </div>

            <div class="embed-responsive embed-responsive-16by9 my-3">
                <video src="<?php echo $model->getVideoLink(); ?>" class="embed-responsive-item" controls
                    poster="<?php echo $model->getThumbLink(); ?>"
                ></video>
            </div>

            <div class="mb-3">
                <p class="text-muted mb-0">Video Link</p>
                <a href="<?php echo $model->getVideoLink(); ?>">Open Video</a>

            </div>

            <?= $form->field($model, 'status')->dropDownList($model->getStatusLabels()); ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
