<?php

use \yii\helpers\Html;
use \yii\helpers\Url;
use \yii\widgets\ActiveForm;
use \yii\widgets\MaskedInput;
use \yii\widgets\Pjax;
use \common\models\ProfileForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileForm */
/* @var $form ActiveForm */
$this->title = 'Анкета абитуриента';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .AbiturApplication h4 {
        margin-top: 3rem;
        background-color: #BCAAA4;
        color: white;
        padding: 5px 5px 2px 8px;
    }
</style>
    <div class="profile">
    <h2>Заявление абитуриента</h2>

    <?php $form = ActiveForm::begin(['enableClientValidation'=>true]); ?>
    <div>


    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading"><h3><i class="mdi-material-red">Персональная информация</i></h3></div>
        <!-- Body -->
        <div class = "panel-body">

            <div class="col-lg-12">
                <h4 class="header">Персона</h4>
                <div class="row">
                    <div class="col-lg-4"><?= $form->field($model, 'surname') ?></div>
                    <div class="col-lg-4"><?= $form->field($model, 'name') ?></div>
                    <div class="col-lg-4"><?= $form->field($model, 'patronymic') ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-4"><?= $form->field($model, 'date_of_birth')->widget(MaskedInput::className(), ['mask' => '9999-99-99']) ?></div>
                    <div class="col-lg-4"><?= $form->field($model, 'birthplace') ?></div>
                    <div class="col-lg-4"><?= $form->field($model, 'nationality') ?></div>
                </div>
            </div>

            <div class="col-lg-12">
                <h4 class="header">Документ, удостоверяющий личность</h4>
                <div class="row">
                    <div class="col-lg-3"><?= $form->field($model, 'identity_type')->dropDownList(ProfileForm::identity_type_array()) ?></div>
                    <div class="col-lg-1"><?= $form->field($model, 'identity_sequence') ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'identity_number') ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'identity_date_issue')->widget(MaskedInput::className(), ['mask' => '9999-99-99']) ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-5"><?= $form->field($model, 'identity_who_issue') ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'identity_who_issue_number') ?></div>
                </div>
            </div>

            <div class="col-lg-12">
                <h4 class="header">Регистрация</h4>
                <div class="row">
                    <div class="col-lg-1"><?= $form->field($model, 'address_registration_postcode')->widget(MaskedInput::className(), ['mask' => '999999']) ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'address_registration_country') ?></div>
                    <div class="col-lg-3"><?= $form->field($model, 'address_registration_subject') ?></div>
                    <div class="col-lg-3"><?= $form->field($model, 'address_registration_region') ?></div>
                    <div class="col-lg-3"><?= $form->field($model, 'address_registration_point') ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-12"><?= $form->field($model, 'address_registration') ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-12"><?= $form->field($model, 'address_real_idem')->checkbox() ?></div>
                </div>
                <div id="div_address_real" <?php if ($model->address_real_idem) { ?> style="display: none;"<?php } ?> >
                    <div class="row">
                        <div class="col-lg-1"><?= $form->field($model, 'address_real_postcode')->widget(MaskedInput::className(), ['mask' => '999999']) ?></div>
                        <div class="col-lg-2"><?= $form->field($model, 'address_real_country') ?></div>
                        <div class="col-lg-3"><?= $form->field($model, 'address_real_subject') ?></div>
                        <div class="col-lg-3"><?= $form->field($model, 'address_real_region') ?></div>
                        <div class="col-lg-3"><?= $form->field($model, 'address_real_point') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"><?= $form->field($model, 'address_real') ?></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <h4 class="header">Контакты</h4>
                <div class="row">
                    <div class="col-lg-3"><?= $form->field($model, 'contact_phone')->widget(MaskedInput::className(), ['mask' => '9 (999) 999-99-99']) ?></div>
                    <div class="col-lg-3"><?= $form->field($model, 'contact_email') ?></div>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading"><h3><i class="mdi-material-red">Родители / законные представители</i></h3></div>
        <!-- Body -->
        <div class = "panel-body">

            <div class="col-lg-12">
                <h4 class="header">Первый</h4>

                <div class="row">
                    <div class="col-lg-3"><?= $form->field($model, 'parent1_type')->dropDownList(ProfileForm::parent_type_array()) ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-3"><?= $form->field($model, 'parent1_surname') ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'parent1_name') ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'parent1_patronymic') ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'parent1_contact_phone')->widget(MaskedInput::className(), ['mask' => '9 (999) 999-99-99']) ?></div>
                    <div class="col-lg-3"><?= $form->field($model, 'parent1_contact_email') ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-6"><?= $form->field($model, 'parent1_job_where') ?></div>
                    <div class="col-lg-5"><?= $form->field($model, 'parent1_job_who') ?></div>
                    <div class="col-lg-1"><?= $form->field($model, 'parent1_job_seniority') ?></div>
                </div>

                <input type="hidden" id="parent1_it_payer" name="ProfileForm[parent1_it_payer]" value="<?php echo $model->parent1_it_payer; ?>">
                <div class="togglebutton">
                    <label>
                        <input type="checkbox" id="parent1-more" <?php if ($model->parent1_it_payer) { ?>checked<?php } ?>> Данные о плательщике
                    </label>
                </div>
                <small>*Данные о плательщиках нужны для заполнения договоров на обучение или дополнительные услуги.<br/>
                    В случае, если абитуриент является совершеннолетним и договор составляется на его имя, данные могут не заполняться.<br/>
                    Можно указать только одного родителя/представителя.
                </small>

                <div id="div-parent1-more" <?php if (!$model->parent1_it_payer) { ?>style="display: none; background-color: #BBDEFB;"<?php } ?> >

                    <div class="col-lg-12" style="background-color: #BBDEFB;">
                        <div class="row">
                            <div class="col-lg-4"><?= $form->field($model, 'parent1_date_of_birth')->widget(MaskedInput::className(), ['mask' => '9999-99-99']) ?></div>
                            <div class="col-lg-4"><?= $form->field($model, 'parent1_birthplace') ?></div>
                            <div class="col-lg-4"><?= $form->field($model, 'parent1_nationality') ?></div>
                        </div>
                    </div>

                    <div class="col-lg-12" style="background-color: #BBDEFB;">
                        <h4>Документ, удостоверяющий личность</h4>
                        <div class="row">
                            <div class="col-lg-3"><?= $form->field($model, 'parent1_identity_type')->dropDownList(ProfileForm::identity_type_array()) ?></div>
                            <div class="col-lg-1"><?= $form->field($model, 'parent1_identity_sequence') ?></div>
                            <div class="col-lg-2"><?= $form->field($model, 'parent1_identity_number') ?></div>
                            <div class="col-lg-2"><?= $form->field($model, 'parent1_identity_date_issue')->widget(MaskedInput::className(), ['mask' => '9999-99-99']) ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><?= $form->field($model, 'parent1_identity_who_issue') ?></div>
                            <div class="col-lg-2"><?= $form->field($model, 'parent1_identity_who_issue_number') ?></div>
                        </div>
                    </div>

                    <div class="col-lg-12" style="background-color: #BBDEFB;">
                        <h4>Регистрация</h4>
                        <div class="row">
                            <div class="col-lg-1"><?= $form->field($model, 'parent1_address_registration_postcode')->widget(MaskedInput::className(), ['mask' => '999999']) ?></div>
                            <div class="col-lg-2"><?= $form->field($model, 'parent1_address_registration_country') ?></div>
                            <div class="col-lg-3"><?= $form->field($model, 'parent1_address_registration_subject') ?></div>
                            <div class="col-lg-3"><?= $form->field($model, 'parent1_address_registration_region') ?></div>
                            <div class="col-lg-3"><?= $form->field($model, 'parent1_address_registration_point') ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><?= $form->field($model, 'parent1_address_registration') ?></div>
                        </div>

                    </div>

                </div>

                <h4 class="header">Второй</h4>

                <div class="row">
                    <div class="col-lg-3"><?= $form->field($model, 'parent2_type')->dropDownList(ProfileForm::parent_type_array()) ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-3"><?= $form->field($model, 'parent2_surname') ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'parent2_name') ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'parent2_patronymic') ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'parent2_contact_phone')->widget(MaskedInput::className(), ['mask' => '9 (999) 999-99-99']) ?></div>
                    <div class="col-lg-3"><?= $form->field($model, 'parent2_contact_email') ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-7"><?= $form->field($model, 'parent2_job_where') ?></div>
                    <div class="col-lg-4"><?= $form->field($model, 'parent2_job_who') ?></div>
                    <div class="col-lg-1"><?= $form->field($model, 'parent2_job_seniority') ?></div>
                </div>

                <input type="hidden" id="parent2_it_payer" name="ProfileForm[parent2_it_payer]" value="<?php echo $model->parent2_it_payer; ?>">
                <div class="togglebutton">
                    <label>
                        <input type="checkbox" id="parent2-more" <?php if ($model->parent2_it_payer) { ?>checked<?php } ?>> Данные о плательщике
                    </label>
                </div>
                <small>*Данные о плательщиках нужны для заполнения договоров на обучение или дополнительные услуги.<br/>
                    В случае, если абитуриент является совершеннолетним и договор составляется на его имя, данные могут не заполняться.<br/>
                    Можно указать только одного родителя/представителя.
                </small>

                <div id="div-parent2-more" <?php if (!$model->parent2_it_payer) { ?>style="display: none; background-color: #BBDEFB;"<?php } ?> >

                    <div class="col-lg-12" style="background-color: #BBDEFB;">
                        <div class="row">
                            <div class="col-lg-4"><?= $form->field($model, 'parent2_date_of_birth')->widget(MaskedInput::className(), ['mask' => '9999-99-99']) ?></div>
                            <div class="col-lg-4"><?= $form->field($model, 'parent2_birthplace') ?></div>
                            <div class="col-lg-4"><?= $form->field($model, 'parent2_nationality') ?></div>
                        </div>
                    </div>

                    <div class="col-lg-12" style="background-color: #BBDEFB;">
                        <h4>Документ, удостоверяющий личность</h4>
                        <div class="row">
                            <div class="col-lg-3"><?= $form->field($model, 'parent2_identity_type')->dropDownList(ProfileForm::identity_type_array()) ?></div>
                            <div class="col-lg-1"><?= $form->field($model, 'parent2_identity_sequence') ?></div>
                            <div class="col-lg-2"><?= $form->field($model, 'parent2_identity_number') ?></div>
                            <div class="col-lg-2"><?= $form->field($model, 'parent2_identity_date_issue')->widget(MaskedInput::className(), ['mask' => '9999-99-99']) ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><?= $form->field($model, 'parent2_identity_who_issue') ?></div>
                            <div class="col-lg-2"><?= $form->field($model, 'parent2_identity_who_issue_number') ?></div>
                        </div>
                    </div>

                    <div class="col-lg-12" style="background-color: #BBDEFB;">
                        <h4>Регистрация</h4>
                        <div class="row">
                            <div class="col-lg-1"><?= $form->field($model, 'parent2_address_registration_postcode')->widget(MaskedInput::className(), ['mask' => '999999']) ?></div>
                            <div class="col-lg-2"><?= $form->field($model, 'parent2_address_registration_country') ?></div>
                            <div class="col-lg-3"><?= $form->field($model, 'parent2_address_registration_subject') ?></div>
                            <div class="col-lg-3"><?= $form->field($model, 'parent2_address_registration_region') ?></div>
                            <div class="col-lg-3"><?= $form->field($model, 'parent2_address_registration_point') ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><?= $form->field($model, 'parent2_address_registration') ?></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading"><h3><h3 class="mdi-material-red">Прочая персональная информация</h3></div>
        <!-- Body -->
        <div class = "panel-body">

            <div class="col-lg-12">

                <div class="row">
                    <div class="col-lg-12"><?= $form->field($model, 'hostel')->checkbox() ?></div>
                </div>

                <h4 class="header">Опыт работы</h4>
                <div class="row">
                    <div class="col-lg-7"><?= $form->field($model, 'job_where') ?></div>
                    <div class="col-lg-4"><?= $form->field($model, 'job_who') ?></div>
                    <div class="col-lg-1"><?= $form->field($model, 'job_seniority') ?></div>
                </div>

                <h4>Льготы</h4>
                <div class="row">
                    <div class="col-lg-2"><?= $form->field($model, 'facility')->checkbox() ?></div>
                    <div id="div_facility" <?php if (!$model->facility) { ?> style="display: none;"<?php } ?> >
                        <div class="col-lg-5"><?= $form->field($model, 'facility_name') ?></div>
                        <div class="col-lg-5"><?= $form->field($model, 'facility_document') ?></div>
                    </div>
                </div>

                <h4 class="header">Личные документы</h4>
                <div class="row">
                    <div class="col-lg-3"><?= $form->field($model, 'insurance_certificate') ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-3"><?= $form->field($model, 'military_certificate_number') ?></div>
                    <div class="col-lg-5"><?= $form->field($model, 'military_certificate_where') ?></div>
                    <div class="col-lg-3"><?= $form->field($model, 'military_card_number') ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-12"><?= $form->field($model, 'additional_information') ?></div>
                </div>

            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading"><h3><i class="mdi-material-red">Данные об образовании</i></h3></div>
        <!-- Body -->
        <div class = "panel-body">

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12"><?= $form->field($model, 'edu_second_prof')->checkbox() ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-3"><?= $form->field($model, 'edu_base')->dropDownList(ProfileForm::edu_base_array()) ?></div>
                    <div class="col-lg-3"><?= $form->field($model, 'edu_level')->dropDownList(ProfileForm::edu_level_array()) ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-6"><?= $form->field($model, 'edu_institution') ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'edu_year_end')->widget(MaskedInput::className(), ['mask' => '9999']) ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-6"><?= $form->field($model, 'edu_document_type')->dropDownList(ProfileForm::edu_document_type_array()) ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'edu_document_sequence') ?></div>
                    <div class="col-lg-4"><?= $form->field($model, 'edu_document_number') ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-5"><?= $form->field($model, 'edu_medal')->checkbox() ?></div>
                    <div class="col-lg-5"><?= $form->field($model, 'edu_winner')->checkbox() ?></div>
                </div>
            </div>

            <div class="col-lg-12">
                <h4 class="header">Владение языками</h4>
                <div class="row">
                    <div class="col-lg-2"><?= $form->field($model, 'lang_eng')->checkbox() ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'lang_de')->checkbox() ?></div>
                    <div class="col-lg-2"><?= $form->field($model, 'lang_fr')->checkbox() ?></div>
                    <div class="col-lg-6"><?= $form->field($model, 'lang_other') ?></div>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading"><h3><i class="mdi-material-red">Выбор направлений обучения</i></h3></div>
        <!-- Body -->
        <div class="panel-body">

            <p>На список направлений влияет выбор в поле "База образования"</p>
            <p>Чем выше специальность, тем выше приоритет. Сортировка работает по принципу "Drag-and-drop".</p>


            <?php Pjax::begin([
                'id'=>'specitemscontainer',
                'enableReplaceState'=>true,
            ]); ?>

            <?= yii\jui\Sortable::widget() ?>
            <div id="sortable">

                <?php foreach ($specitems as $item) {

                    $choice = 'none';
                    if ($item['ch_ff'] == 1)
                        $choice = 'form_fulltime';
                    if ($item['ch_fe'] == 1)
                        $choice = 'form_extramural';

                    $options = [];
                    $options['none'] = 'не выбрана';
                    if ($item['form_fulltime'] == 1)
                        $options['form_fulltime'] = 'Очная';
                    if ($item['form_extramural'] == 1)
                        $options['form_extramural'] = 'Заочная';

                    echo '<div class="list-group-item"><h4><small>[' . $item['code'] . ']</small> ' . $item['name'] . '</h4>'
                        . Html::radioList(
                            'spec['.$item['id'].']',
                            $choice,
                            $options
                        ) . '</div>';
                } ?>

            </div>
            <?php Pjax::end(); ?>

        </div>


    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-info', 'value'=>'save', 'name'=>'submit']) ?>
    </div>

    </div>
    <?php ActiveForm::end(); ?>

    </div><!-- profile -->



<?php

$url = Url::to(['spec-items']);

$script = <<< JS

    $(document).ready(function () {

        $(function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
        });

        $('#profileform-edu_base').click(function (e) {

            $.pjax.reload("#specitemscontainer", {
                history: false,
                type: 'GET',
                data: 'base='+this.value,
                url: '$url'
            });

        });

        $('#profileform-address_real_idem').click(function (e) {
            $('#div_address_real').animate({height: "toggle"},200);
        });

        $('#profileform-facility').click(function (e) {
            $('#div_facility').animate({height: "toggle"},200);
        });

        $('#parent1-more').click(function (e) {
            $('#div-parent1-more').animate({height: "toggle"},200);
            if($('input[name="ProfileForm[parent1_it_payer]"]').prop( "value") == 1)
                $('input[name="ProfileForm[parent1_it_payer]"]').prop( "value", 0 );
            else
                $('input[name="ProfileForm[parent1_it_payer]"]').prop( "value", 1 );
        });

        $('#parent2-more').click(function (e) {
            $('#div-parent2-more').animate({height: "toggle"},200);
            if($('input[name="ProfileForm[parent2_it_payer]"]').prop( "value") == 1)
                $('input[name="ProfileForm[parent2_it_payer]"]').prop( "value", 0 );
            else
                $('input[name="ProfileForm[parent2_it_payer]"]').prop( "value", 1 );
        });

    });

JS;

$this->registerJs($script);

