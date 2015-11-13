<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Spec */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('spec', 'Specs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spec-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('spec', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('spec', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('spec', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'code',
            'name',
            'form_fulltime',
            'form_extramural',
            'base_9',
            'base_11',
        ],
    ]) ?>

</div>