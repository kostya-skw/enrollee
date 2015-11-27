<?php
/**
 * Created by PhpStorm.
 * User: kostys
 * Date: 06.10.15
 * Time: 14:59
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */

$this->title = 'Анкета абитуриента';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-lg-9">

    <h1>Анкета абитуриента</h1>
    <h2>Персональная информация</h2>
    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'person.namefull',
            'person.date_of_birth:date', // creation date formatted as datetime
            'person.birthplace',
            'person.nationality',
            'person.identityfull',
            'person.addressfull',
            'person.contact_phone',
            'person.contact_email',
            'person.job_where',
            'person.job_who',
            'person.job_seniority',
        ],
        'template' => function($attribute, $index, $widget){
            //your code for rendering here. e.g.
            if($attribute['value']) {
                return "<tr><th style='width: 30%'>{$attribute['label']}</th><td>{$attribute['value']}</td></tr>";
            }
        },
    ]); ?>

    <h2>Родители / законные представители</h2>

    <?php if (!empty($model->person->parent1_type)) { ?>

        <h3><?php echo $model->person->parent1_type; ?></h3>
        <?php
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'person.parent1.namefull',
                'person.parent1.date_of_birth:date',
                'person.parent1.birthplace',
                'person.parent1.nationality',
                'person.parent1.identityfull',
                'person.parent1.addressfull',
                'person.parent1.contact_phone',
                'person.parent1.contact_email',
                'person.parent1.job_where',
                'person.parent1.job_who',
                'person.parent1.job_seniority',
            ],
            'template' => function($attribute, $index, $widget){
                //your code for rendering here. e.g.
                if($attribute['value'])
                {
                    return "<tr><th style='width: 40%'>{$attribute['label']}</th><td>{$attribute['value']}</td></tr>";
                }
            },
        ]);
        ?>
    <?php } ?>

    <?php if (!empty($model->person->parent2_type)) { ?>

        <h3><?php echo $model->person->parent2_type; ?></h3>

        <?php
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'person.parent2.namefull',
                'person.parent2.date_of_birth:date',
                'person.parent2.birthplace',
                'person.parent2.nationality',
                'person.parent2.identityfull',
                'person.parent2.addressfull',
                'person.parent2.contact_phone',
                'person.parent2.contact_email',
                'person.parent2.job_where',
                'person.parent2.job_who',
                'person.parent2.job_seniority',
            ],
            'template' => function($attribute, $index, $widget){
                //your code for rendering here. e.g.
                if($attribute['value'])
                {
                    return "<tr><th style='width: 40%'>{$attribute['label']}</th><td>{$attribute['value']}</td></tr>";
                }
            },
        ]);
        ?>

    <?php } ?>


    <h2>Прочая персональная информация</h2>
    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'insurance_certificate',
            'military_certificate_number',
            'military_certificate_where',
            'military_card_number',
            'additional_information',
        ],
        'template' => function($attribute, $index, $widget){
            //your code for rendering here. e.g.
            return "<tr><th style='width: 40%'>{$attribute['label']}</th><td>{$attribute['value']}</td></tr>";
        },
    ]); ?>


    <h2>Образование</h2>

    <div class="checkbox">
        <label>
            <input type="checkbox" disabled <?php if ($model->edu_second_prof) { ?>checked<?php } ?>> Среднее профессиональное образование получаю впервые
        </label>
    </div>

    <dl class="dl-horizontal col-lg-12">
        <dt><?php echo $model->getAttributeLabel('edu_base') ?></dt>
        <dd><?php echo $model->edu_base ?></dd>
    </dl>

    <dl class="dl-horizontal col-lg-12">
        <dt><?php echo $model->getAttributeLabel('edu_level') ?></dt>
        <dd><?php echo $model->edu_level ?></dd>
    </dl>

    Документ об образовании:

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'edu_document_type',
            'edu_institution',
            'edu_document_sequence',
            'edu_document_number',
            'edu_year_end',
        ],
        'template' => function($attribute, $index, $widget){
            //your code for rendering here. e.g.
            return "<tr><th style='width: 40%'>{$attribute['label']}</th><td>{$attribute['value']}</td></tr>";
        },
    ]); ?>

        <div class="col-lg-12">
            <div class="col-lg-2"><h4>Иностранные языки</h4></div>
            <div class="col-lg-10 checkbox">
                <label class="col-lg-2">
                    <input type="checkbox" disabled <?php if ($model->lang_eng) { ?>checked<?php } ?>> <?php echo $model->getAttributeLabel('lang_eng') ?>
                </label>
                <label class="col-lg-2">
                    <input type="checkbox" disabled <?php if ($model->lang_de) { ?>checked<?php } ?>> <?php echo $model->getAttributeLabel('lang_de') ?>
                </label>
                <label class="col-lg-2">
                    <input type="checkbox" disabled <?php if ($model->lang_fr) { ?>checked<?php } ?>> <?php echo $model->getAttributeLabel('lang_fr') ?>
                </label>
                <div class="col-lg-2">Другой: <?php echo $model->lang_other; ?></div>
            </div>
        </div>

    <div class="col-lg-12">

        <div class="checkbox">
            <label>
                <input type="checkbox" disabled <?php if ($model->edu_medal) { ?>checked<?php } ?>> <?php echo $model->getAttributeLabel('edu_medal') ?>
            </label>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" disabled <?php if ($model->edu_winner) { ?>checked<?php } ?>> <?php echo $model->getAttributeLabel('edu_winner') ?>
            </label>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" disabled <?php if ($model->hostel) { ?>checked<?php } ?>> <?php echo $model->getAttributeLabel('hostel') ?>
            </label>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" disabled <?php if ($model->facility) { ?>checked<?php } ?>> <?php echo $model->getAttributeLabel('facility') ?>
            </label>
        </div>

    </div>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'facility_name',
            'facility_document',
        ],
        'template' => function($attribute, $index, $widget){
            //your code for rendering here. e.g.
            if($attribute['value']) {
                return "<tr><th style='width: 40%'>{$attribute['label']}</th><td>{$attribute['value']}</td></tr>";
            }
        },
    ]); ?>


    <h2>Выбранные направления обучения</h2>

    <?php echo \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getSpecs(),
            'sort' => false,
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'spec.code',
            'spec.name',
            [
                'label'=>'Форма',
                'value' => function ($data) {
                    if ($data->form_fulltime == 1)
                        return 'Очная';
                    if ($data->form_extramural == 1)
                        return 'Заочная';
                },
            ],
            'priority'
        ],
    ]) ?>



</div>

<style>
    div.title {
        margin-top: 2rem;
        color: #607D8B;
        font-family: 'Glyphicons Halflings';
        font-style: normal;
        font-weight: normal;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        position: relative;
        top: 1px;
        display: inline-block;
    }
    div.field {
        background-color: #ECEFF1;
        padding: 1rem;
        font-size: larger;
    }
</style>

<div class="col-lg-3 border">

    <div class="title">Статус заявления:</div>
    <div class="field"><?php echo $model->statusAsText ?></div>

    <div class="title"> Дата создания:</div>
    <div class="field"><?php echo date('Y-m-d H:m:i', $model->created_at) ?></div>

    <div class="title"> Дата изменения:</div>
    <div class="field"><?php echo date('Y-m-d H:m:i', $model->updated_at) ?></div>

    <div class="form-group">
        <?= Html::Button('<i class="mdi-content-create" style="font-size: 12pt;"></i> '.Yii::t('app', 'Изменить'), ['class' => 'btn btn-flat btn-primary btn-block', 'id' => 'returnToEdit']) ?>
        <?= Html::Button('<i class="mdi-file-file-download" style="font-size: 12pt;"></i> '.Yii::t('app', 'в PDF'), ['class' => 'btn btn-flat btn-info btn-block', 'id' => 'toPDF']) ?>
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
