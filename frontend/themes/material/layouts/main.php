<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\MaterialAsset;
use common\widgets\Alert;

MaterialAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        #intro-image {
            top: 6rem;
            height: 5rem;
            background-size: cover;
            background-position: center center;
            position: relative;
        }
        #intro-header {
            position: absolute;
            top: 9rem;
            text-align: center;
            width: 100%;
            background-color: #ffffff;
            opacity: 0.85;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => \Yii::$app->name.'::'.$this->title,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '<span class="glyphicon glyphicon-home"></span> Home', 'url' => ['/site/index']],
        ['label' => '<span class="glyphicon glyphicon-phone-alt"></span> Политика конфидициальности', 'url' => ['/site/confidential']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-plus-sign"></span> Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-user"></span> Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => '<span class=""></span> Анкета', 'url' => ['/profile/my']];
        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-user"></span> '.Yii::$app->user->identity->username, 'items' => [
            ['label' => '<span class="glyphicon glyphicon-"></span> User settings', 'url' => ['/site/user-settings']],
            [
                'label' => '<span class="glyphicon glyphicon-off"></span> Logout',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ]
        ]];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels'=>false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div id="intro-image" style="background-image:url('/images/post.jpg');"></div>

    <div class="container" style="background-color: #f5f5f5; height: 100%">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div class=""><?= $content ?></div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Марийский радиомеханический техникум <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
<script>
    $(document).ready(function() {
        // This command is used to initialize some elements and make them work properly
        $.material.init();
    });
</script>

</body>
</html>
<?php $this->endPage() ?>
