<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Spec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spec-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'form_fulltime')->checkbox() ?>
    <?= $form->field($model, 'form_extramural')->checkbox() ?>

    <?= $form->field($model, 'base_9')->checkbox() ?>
    <?= $form->field($model, 'base_11')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('spec', 'Create') : Yii::t('spec', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>