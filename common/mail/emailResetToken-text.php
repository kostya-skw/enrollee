<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
$siteLink = Yii::$app->urlManager->createAbsoluteUrl(['site/index']);
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/new-email-confirm', 'token'=>$user->new_email_token]);
?>
Приветствуем <?= $user->username ?>,

Ваш почтовый адрес зарегистрирован в базе данных абитуриентов Марийского радиомеханического техникума.

Для подтверждения email адреса пройдите пожалуйста по следующей ссылке:
<?= $resetLink ?>

Теперь на сайте <?= $siteLink ?> вы можете, введя логин (email адрес) и пароль, дополнить и изменить свою анкету абитуриента. Это существенно сократит Ваше время и нервы, потраченные в приемной комиссии техникума.
Вы можете заполнить анкету на этом сайте в любое удобное для Вас время, в спокойной обстановке, из дома или Интернет-кафе. Это означает, что у Вас будет достаточно времени, чтобы собрать и уточнить все анкетные данные, необходимые для поступления в техникум.
Внесение изменений в анкету будет возможно вплоть до подачи заполненого заявления в приемную комиссию нашего техникума, где его проверят на достоверность указанных в нем данных.


Если Вы не регистрировались на этом сайте, то данное сообщение попало к Вам по ошибке, просто удалите его.
Не отвечайте на это письмо! Оно было сгенерировано автоматически программой регистрации.