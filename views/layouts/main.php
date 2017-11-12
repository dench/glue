<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\SiteAsset;
use dench\products\models\Category;
use luya\bootstrap4\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

SiteAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>
</head>
<body class="bg-light">
<?php $this->beginBody() ?>
<header class="bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                .
            </div>
            <div class="col-lg-4">
                .
            </div>
            <div class="col-lg-4">
                .
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg bg-gradient-dark navbar-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/category/index']) ?>">Каталог</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Подобрать продукт</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Как заказать</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Вопросы и ответы</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Информация для клиентов
                        </a>
                        <div class="dropdown-menu" aria-labelledby="infoDropdown">
                            <a class="dropdown-item" href="#">Информация 1</a>
                            <a class="dropdown-item" href="#">Информация 2</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Информация 3</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Контакты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Отзывы</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container my-3">
    <div class="row">
        <div class="col-lg-3">
            <nav class="list-group">
                <?php foreach (Category::findAll(['enabled' => 1]) as $category) : ?>
                <a href="<?= Url::to(['category/view', 'slug' => $category->slug]) ?>" class="list-group-item list-group-item-action"><?= $category->name ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
        <div class="col-lg-9">
            <?php
            if (isset($this->params['breadcrumbs'])) {
                echo Html::tag(
                    'div',
                    Breadcrumbs::widget([
                        'links' => $this->params['breadcrumbs'],
                        'homeLink' => [
                            'label' => Yii::$app->name,
                            'url' => Yii::$app->homeUrl,
                        ],
                    ]), [
                    'class' => 'bg-grey'
                ]);
            }
            ?>

            <?= $content ?>
        </div>
    </div>
</div>

<footer>

</footer>
<?= $this->render('_counters') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
