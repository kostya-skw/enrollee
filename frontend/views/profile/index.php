<?php
/**
 * Created by PhpStorm.
 * User: kostys
 * Date: 06.10.15
 * Time: 11:05
 */

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Анекта';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><h3>Анкета абитуриента</h3></div>
    <!-- Body -->
    <div class="panel-body">
        <?php if(!empty($model->id)) { ?>
        <h4><?= $model->person->NameFull ?></h4>
        <p>
            <strong>статус: </strong> <?= $model->statusAsText ?>,
            <strong>дата заполнения: </strong> <?= date('Y-m-d H:m:i', $model->created_at) ?>,
            <strong>дата изменения: </strong> <?= date('Y-m-d H:m:i', $model->updated_at) ?>
        </p>
        <?php } else { ?>
            нет данных
        <?php } ?>
    </div>
    <div class="panel-footer">
        <?php if(!empty($model->id)) { ?>
            <?= Html::a('<i class="glyphicon glyphicon-eye-open" style="font-size: 12pt;"></i> смотреть',['/profile/view'], ['class' => 'btn btn-flat btn-primary', 'id' => 'view']) ?>
            <?= Html::Button('<i class="glyphicon glyphicon-edit" style="font-size: 12pt;"></i> изменить', ['class' => 'btn btn-flat btn-primary', 'id' => 'returnToEdit']) ?>
            <?= Html::Button('<i class="mdi-file-file-download" style="font-size: 12pt;"></i> '.Yii::t('app', 'в PDF'), ['class' => 'btn btn-flat btn-info', 'id' => 'toPDF']) ?>
        <?php } else { ?>
            <?= Html::a('<i class="glyphicon glyphicon-edit" style="font-size: 12pt;"></i> Заполнить',['/profile/edit'], ['class' => 'btn btn-flat btn-primary', 'id' => 'new']) ?>
        <?php } ?>
    </div>
</div>

<?php

$urlEdit = Url::to(['profile/return-to-edit'], true);
$urlPdf = Url::to(['profile/profile-to-pdf'], true);

$script = <<< JS

$(document).ready(function () {

    $('#returnToEdit').click(function (e) {

        $.ajax({
            type     :'POST',
            cache    : false,
            url      : '$urlEdit',
        });

    });

    $('#toPDF').click(function (e) {

         window.open('$urlPdf');

    });

})

JS;

$this->registerJs($script);
