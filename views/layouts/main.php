<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\SiteAsset;
use dench\products\models\Category;
use luya\bootstrap4\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

SiteAsset::register($this);

$js = <<<JS
$('.block-link').click(function(){
    document.location.href = $(this).find('a').attr('href');
});
JS;

$this->registerJs($js);
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
<header class="bg-gradient-secondary">
    <div class="container">
        <div class="row pb-1 pb-md-3 pt-3">
            <div class="col-6 col-md-4">
                <a href="/"><img src="/img/loxeal.png" class="logo"></a>
            </div>
            <div class="search col-10 col-md-4 py-2">
                <div class="input-group pt-1">
                    <input type="text" class="form-control" placeholder="Search for..." aria-label="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button">Найти</button>
                    </span>
                </div>
            </div>
            <div class="col-6 col-md-4 text-right">
                <div class="phones">
                    <a href="tel:<?= Yii::$app->params['phone1'] ?>"><i class="fa fa-phone"></i> <?= Yii::$app->params['phone1f'] ?></a>
                    <a href="tel:<?= Yii::$app->params['phone1'] ?>"><i class="fa fa-phone"></i> <?= Yii::$app->params['phone2f'] ?></a>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-md bg-gradient-dark navbar-dark">
        <div class="container px-0">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-top" aria-controls="navbar-top" aria-expanded="false" aria-label="Toggle navigation">
                <i></i>
                <i></i>
                <i></i>
            </button>
            <div class="collapse navbar-collapse" id="navbar-top">
                <div class="container px-0">
                    <div class="navbar-nav nav-fill">
                        <a class="nav-item nav-link" href="/">Главная</a>
                        <a class="nav-item nav-link active bg-gradient-primary" href="<?= Url::to(['/category/index']) ?>">Каталог</a>
                        <a class="nav-item nav-link" href="#">Подобрать продукт</a>
                        <a class="nav-item nav-link" href="#">Как заказать</a>
                        <a class="nav-item nav-link" href="#">Вопросы и ответы</a>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Информация для клиентов
                            </a>
                            <div class="dropdown-menu" aria-labelledby="infoDropdown">
                                <a class="dropdown-item" href="#">Информация 1</a>
                                <a class="dropdown-item" href="#">Информация 2</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Информация 3</a>
                            </div>
                        </div>
                        <a class="nav-item nav-link" href="#">Контакты</a>
                        <a class="nav-item nav-link" href="#">Отзывы</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="container my-2 my-md-3">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <nav class="navbar navbar-expand-md mb-3">
                <button class="btn btn-dark btn-block d-md-none" type="button" data-toggle="collapse" data-target="#navbar-left" aria-controls="navbar-left" aria-expanded="false" aria-label="Toggle navigation">
                    Каталог товаров
                </button>
                <div class="collapse navbar-collapse" id="navbar-left">
                    <?php
                    $items = [];
                    foreach (Category::findAll(['enabled' => 1]) as $category) {
                        $slug = '';
                        $items[$category->id] = [
                            'label' => $category->name,
                            'url' => ['category/view', 'slug' => $category->slug],
                            'options' => [
                                'tag' => false,
                            ],
                        ];
                        if (Yii::$app->controller->id == 'product') {
                            $slug = @$this->params['breadcrumbs'][1]['url']['slug'];
                        } elseif (Yii::$app->controller->id == 'category') {
                            $slug = Yii::$app->request->get('slug');
                        } else {
                            $slug = '';
                        }
                        if ($slug == $category->slug) {
                            $items[$category->id]['template'] = '<a class="nav-link active bg-gradient-primary text-white" href="{url}">{label}</a>';
                        }
                    }
                    echo Menu::widget([
                        'items' => $items,
                        'linkTemplate' => '<a class="nav-link" href="{url}">{label}</a>',
                        'options' => [
                            'tag' => 'div',
                            'class' => 'nav nav-left flex-column',
                        ],
                    ]);
                    ?>
                </div>
            </nav>
        </div>
        <div class="col-md-8 col-lg-9">
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

<footer class="bg-gradient-dark">
    <div class="container">
        <div class="row py-4">
            <div class="col-6 col-sm">
                <a href="/"><img src="/img/loxeal.png" class="logo"></a>
            </div>
            <div class="col-6 col-sm order-sm-2 text-right">
                <div class="phones">
                    <a href="tel:<?= Yii::$app->params['phone1'] ?>"><i class="fa fa-phone"></i> <?= Yii::$app->params['phone1f'] ?></a>
                    <a href="tel:<?= Yii::$app->params['phone1'] ?>"><i class="fa fa-phone"></i> <?= Yii::$app->params['phone2f'] ?></a>
                </div>
            </div>
            <div class="col-sm order-sm-1 mt-3 mt-sm-0 clearfix">
                <div class="row">
                    <div class="col-md-6">
                        <nav class="nav flex-column">
                            <a href="#">Главная</a>
                            <a href="#">Каталог</a>
                            <a href="#">Подобрать продукт</a>
                            <a href="#">Как заказать</a>
                        </nav>
                    </div>
                    <div class="col-md-6">
                        <nav class="nav flex-column">
                            <a href="#">Вопросы и ответы</a>
                            <a href="#">Информация для клиентов</a>
                            <a href="#">Контакты</a>
                            <a href="#">Отзывы</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center py-2 bg-gradient-secondary text-white">
        2017 © <a href="/"><?= Yii::$app->name ?></a>
    </div>
</footer>
<?= $this->render('_counters') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
