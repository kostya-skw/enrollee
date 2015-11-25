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

$this->title = 'Соглашение на обработку персональных данных';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agreement">

    <p>Для последующей работы, нобходимо дать согласие на обработку следующих персональных данных:</p>

    <ul>
        <li>фамилия, имя, отчество;</li>
        <li>год рождения, месяц рождения, дата рождения;</li>
        <li>место рождения;</li>
        <li>образование;</li>
        <li>адрес регистрации;</li>
        <li>контактная информация (телефон, email);</li>
        <li>паспортные данные (серия/номер/дата/кем выдан);</li>
        <li>адрес места жительства;</li>
        <li>гражданство;</li>
        <li>состав семьи;</li>
        <li>фотографические изображения;</li>
        <li>сведение о месте работы;</li>
        <li>сведения о трудовом стаже;</li>
        <li>характертстики;</li>
        <li>знание иностранного языка;</li>
        <li>индивидуальный номер налогоплательщика;</li>
        <li>номер страхового свидетельства;</li>
        <li>сведения о льготах;</li>
    </ul>

    <p><strong>Перечень действий с персональными данными:</strong><br/>Сбор, запись, систематизация, накопление, хранение, уточнение (обновление, изменение), извлечение, использование, передача, доступ, распространение, обезличивание, блокирование, удаление, уничтожение персональных данных.;</p>
    <p><strong>Обработка персональных данных:</strong><br/>смешанная; с передачей по сети Интернет</p>

    <p>Ознакомиться с политикой конфидициальности можно по <a href="<?php echo Url::to(['site/confidential']) ?>">этой ссылке</a>.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'agreement']); ?>

            <i class="mdi-action-face-unlock"></i>

            <?= $form->field($model, 'consent_processing_personal_data')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Продолжить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
