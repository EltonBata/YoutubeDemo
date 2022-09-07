<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Video */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex flex-column justify-content-center align-items-center">

        <div class="upload-icon my-3">
            <i class="fas fa-upload"></i>
        </div>


        <p class="m-0 text-muted">Drag and drop your file</p><br>
        <p class="text-muted">Your Video will be private untill you publish it</p>

        <?php $form = \yii\widgets\ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data']
        ]) ?>

        <button class="btn btn-file ">

            Select File

            <input type="file" id="videoFile" name="videoFile">

        </button>

        <?php echo $form->errorSummary($model);  ?>

        <?php $form = \yii\widgets\ActiveForm::end() ?>
    </div>

</div>
