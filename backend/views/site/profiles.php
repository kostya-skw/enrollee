<?php
/**
 * Created by PhpStorm.
 * User: kostys
 * Date: 06.10.15
 * Time: 14:59
 */

use yii\grid\GridView;
use \yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Заявления';
?>

<h1>Список заявлений</h1>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'statusAsText',
        'person.namefull',
        'edu_base',
        'edu_level',
        'edu_institution',
        'edu_year_end',
        [
            'attribute' => 'updated_at',
            'format' => ['date', 'php:Y-m-d H:m:i']
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            // you may configure additional properties here
            'buttons'=> [
                'view' => function ($url, $model, $key) {
//                    return $model->status === 'editable' ? Html::a('Update', $url) : '';
                    $url = Yii::$app->getUrlManager()->createUrl(['site/profile-view','id'=>$model['id']]);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                },
                'update' => function ($url, $model, $key) {
                    $url = Yii::$app->getUrlManager()->createUrl(['site/profile-edit','id'=>$model['id']]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                },
            ],
        ],
    ]
]); ?>