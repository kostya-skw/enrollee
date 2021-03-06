<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
$this->title = 'Приветствуем Вас!';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Приветствуем Вас!</h1>

        <p class="lead">Вы попали в он-лайн систему для заполнения анкеты абитуриента.</p>
        <?php if (Yii::$app->user->isGuest) { ?>
        <p>
            <a class="btn btn-lg btn-success" href="<?php echo Url::to(['site/signup'], true) ?>">Начать регистрацию</a>
            ИЛИ
            <a class="btn btn-lg btn-info" href="<?php echo Url::to(['site/login'], true) ?>">Войти</a>
        </p>
        <?php } ?>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-10 col-lg-push-1">
                <h2>Для чего</h2>

                <p class="lead">
                    Абитуриент или его представитель может заполнить он-лайн анкету абитуриента.
                    Это существенно сократит Ваше время и нервы, потраченные в приемной комиссии техникума.
                    Вы можете заполнить анкету на этом сайте в любое удобное для Вас время, в спокойной обстановке, из дома или Интернет-кафе. Это означает, что у Вас будет достаточно времени, чтобы собрать и уточнить все анкетные данные, необходимые для поступления в техникум.
                    Внесение изменений в анкету будет возможно вплоть до подачи заполненого заявления в приемную комиссию нашего техникума, где его проверят на достоверность указанных в нем данных.
                </p>

            </div>
        </div>

    </div>
</div>
