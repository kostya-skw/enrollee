<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('spec', 'Specs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spec-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('spec', 'Create Spec'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'code',
            'name',

            [
                'attribute' => 'form_fulltime',
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                    if ($model->form_fulltime)
                        return Html::checkbox('form_fulltime[]', $model->form_fulltime, ['value' => $index, 'disabled' => true]);
                    else return '';
                },
            ],
            [
                'attribute' => 'form_extramural',
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                    if ($model->form_extramural)
                        return Html::checkbox('form_extramural[]', $model->form_extramural, ['value' => $index, 'disabled' => true]);
                    else return '';
                },
            ],
            [
                'attribute' => 'base_9',
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                    if ($model->base_9)
                        return Html::checkbox('form_extramural[]', $model->base_9, ['value' => $index, 'disabled' => true]);
                    else return '';
                },
            ],
            [
                'attribute' => 'base_11',
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                    if ($model->base_11)
                        return Html::checkbox('form_extramural[]', $model->base_11, ['value' => $index, 'disabled' => true]);
                    else return '';
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>