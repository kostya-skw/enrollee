<?php
/**
 * Created by PhpStorm.
 * User: kostys
 * Date: 12.10.15
 * Time: 12:28
 */

use yii\widgets\DetailView;
use \common\models\Person;

/* @var $this yii\web\View */

?>

<p style="text-align: right;">Регистрационный номер #<?php echo $model->id ?>________________</p>
<p>Директору  ГБПОУ Республики Марий Эл «Марийский радиомеханический техникум» от гражданина(ки):</p>
<?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            [                      // the owner name of the model
                'label' => 'ФИО',
                'value' => $model->person->namefull,
                'contentOptions' =>['style'=>'max-width: 20%;'],
            ],
            'person.date_of_birth', // creation date formatted as datetime
            'person.birthplace',
            'person.nationality',
            [                      // the owner name of the model
                'label' => 'Документ, удостоверяющий личность',
                'value' => $model->person->identityfull
            ],
            [                      // the owner name of the model
                'label' => 'Адрес регистрации',
                'value' => $model->person->addressfull,
            ],
            'person.contact_phone',
            'person.contact_email',
        ],
        'template' => function($attribute, $index, $widget){
            //your code for rendering here. e.g.
            return "<tr><th style='width: 40%; padding: 5;'>{$attribute['label']}</th><td style='padding: 5;'>{$attribute['value']}</td></tr>";
        },
    ]); ?>
<h2 style="text-align: center">Заявление</h2>
<p>Прошу принять меня на специальность:</p>
<p><strong style=" text-decoration:underline;">08.02.08 Монтаж и эксплуатация оборудования и систем газоснабжения</strong>,
<p>форма обучения <strong>очная</strong>;</p>
<p>О себе сообщаю следующее:</p>
<Ol style="line-height: 200%">
    <li>Окончил(а) в <strong><?php echo $model->edu_year_end ?></strong> году образовательное учреждение <strong><?php echo $model->edu_institution ?></strong>;</li>
    <li><strong><?php echo $model->edu_document_type ?></strong>, серия <strong><?php echo $model->edu_document_sequence ?></strong>, номер <strong><?php echo $model->edu_document_number ?></strong>;</li>
    <li><?php if ($model->edu_medal == 1) echo '<strong>Есть медаль</strong> (аттестат, диплом "с отличием")'; else echo 'Нет медали (аттестата, диплома "с отличием")' ?>,
        <?php if ($model->edu_medal == 1) echo '<strong>Победитель</strong> всероссийских олимпиад (член сборной)'; else echo 'на олимпиадах не побеждал' ?>
    ;</li>
    <li>Пенсионное (страховое) свидетельство (номер) <strong><?php echo $model->insurance_certificate ?></strong>;</li>
    <li>Приписное удостоверение, номер <strong><?php echo $model->military_certificate_number ?></strong>, стоит на учете <strong><?php echo $model->military_certificate_where ?></strong>;</li>
    <li>Военный билет (номер): <strong><?php echo $model->military_card_number ?></strong>;</li>
    <li>Трудовой стаж (если есть): <strong><?php echo $model->person->job_seniority ?></strong>;</li>
    <li>Иностранные языки:
        <strong><?php if ($model->lang_eng == 1) echo 'английский' ?></strong>
        <strong><?php if ($model->lang_de == 1) echo ', немецкий' ?></strong>
        <strong><?php if ($model->lang_fr == 1) echo ', французский' ?></strong>
        <strong><?php if (!empty($model->lang_other)) echo ', '.$model->lang_other ?></strong>
    ;</li>
    <li>
        При  поступлении имею следующие льготы: <strong><?php echo $model->facility_name ?></strong><br/>
        Документ, предоставляющий право на льготы: <strong><?php echo $model->facility_document ?></strong>
    ;</li>
    <li>В общежитии <?php if ($model->hostel == 1) echo '<strong>нуждаюсь</strong>'; else echo 'не нуждаюсь' ?>;</li>
    <li>О себе дополнительно сообщаю: <?php echo $model->additional_information ?>;</li>
    <li>Среднее профессиональное образование получаю <?php if ($model->edu_second_prof == 1) echo '<strong>впервые</strong>'; else echo 'не впервые' ?>;</li>
    <li>Данные о родителях / законных представителях: <?php if(empty($model->person->parent1)&empty($model->person->parent2)) { ?>;<?php } ?><br/>
        <?php if($model->person->parent1) { ?>
            Первый: <?php echo $model->person->parent1_type ?>, <?php echo $model->person->parent1->namefull ?><br/>
            Где и кем работает, телефон: <?php echo $model->person->parent1->job_where.', '.$model->person->parent1->job_who.', '.$model->person->parent1->contact_phone ?><br/>
        <?php } ?>
        <?php if($model->person->parent2) { ?>
            Второй: <?php echo $model->person->parent2_type ?>, <?php echo $model->person->parent2->namefull ?><br/>
            Где и кем работает, телефон: <?php echo $model->person->parent2->job_where.', '.$model->person->parent2->job_who.', '.$model->person->parent2->contact_phone ?><br/>
        <?php } ?>
    </li>
</Ol>
<pagebreak />
<p style="width: 70%">
    С лицензией на право осуществления образовательной деятельности, свидетельством о государственной аккредитации,
    правилами приема и условиями обучения в данном образовательном учреждении, правилами внутреннего распорядка,
    правилами подачи апелляций ознакомлен(а):

    <p style="text-align: right">___________________________<br/>(Подпись поступающего)</p>
</p>

<p style="width: 70%" nowrap>
    С датой предоставления подлинника документа об образовании ознакомлен(а):
<p style="text-align: right">___________________________<br/>(Подпись поступающего)</p>
</p>


<p style="width: 70%">
Подпись ответственного лица приемной комиссии
<p style="text-align: right">___________________________</p>
</p>
<br/>
<p>
    <?php echo date("d.m.Y") ?>
</p>

