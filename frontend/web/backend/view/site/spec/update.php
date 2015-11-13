<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Spec */

$this->title = Yii::t('spec', 'Update {modelClass}: ', [
    'modelClass' => 'Spec',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('spec', 'Specs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('spec', 'Update');
?>
<div class="spec-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
