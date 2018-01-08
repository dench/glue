<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\FontAwesomeAsset;
use app\assets\SiteAsset;
use app\components\Nav;
use app\models\Question;
use app\models\Review;
use dench\page\models\Page;
use dench\products\models\Category;
use luya\bootstrap4\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

SiteAsset::register($this);
FontAwesomeAsset::register($this);

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
                <div class="container">
                    <div class="navbar-nav nav-fill">
                    <?php
                    $info = Page::find()
                        ->joinWith('translation')
                        ->leftJoin('page_parent','page.id = page_parent.page_id')
                        ->select(['name', 'slug'])
                        ->andWhere(['parent_id' => 6])
                        ->orderBy(['page.id' => SORT_DESC])
                        ->limit(5)
                        ->all();

                    $info_menu = [];

                    foreach ($info as $item) {
                        $info_menu[] = [
                            'label' => $item->name,
                            'url' => ['/info/view', 'slug' => $item->slug],
                        ];
                    }

                    $items = [
                        [
                            'label' => 'Главная',
                            'url' => ['/'],
                            'active' => in_array(Yii::$app->controller->id, ['site']) && in_array(Yii::$app->controller->action->id, ['index']),
                            /*'linkOptions' => [
                                'class' => in_array(Yii::$app->controller->id, ['site']) && in_array(Yii::$app->controller->action->id, ['index']) ? 'nav-item nav-link ml-3' : 'nav-item nav-link',
                            ],*/
                        ],
                        [
                            'label' => 'Каталог',
                            'url' => ['/category/index'],
                            'active' => in_array(Yii::$app->controller->id, ['category', 'product']),
                        ],
                        ['label' => 'Подобрать продукт', 'url' => ['/podbor/index']],
                        ['label' => 'Как заказать', 'url' => ['/site/how']],
                        ['label' => 'Вопросы и ответы', 'url' => ['/site/questions']],
                        [
                            'label' => 'Информация для клиентов',
                            'url' => ['/info/index'],
                            'items' => $info_menu,
                            'dropDownOptions' => [
                                'class' => '',
                            ],
                        ],
                        ['label' => 'Контакты', 'url' => ['/site/contacts']],
                        ['label' => 'Отзывы', 'url' => ['/site/reviews']],
                    ];
                    echo Nav::widget([
                        'items' => $items,
                        'activeClass' => 'active bg-gradient-primary',
                        'linkOptions' => [
                            'class' => 'nav-item nav-link',
                        ],
                    ]);
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="container my-2 my-md-3">
    <div class="row">
        <div class="col-md-4 col-lg-3">
            <div class="row">
                <div class="col-sm-6 col-md-12">
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
                    <div class="card border border-primary border-strong block-link">
                        <img class="card-img-top" src="/img/podbor.jpg" alt="Подобрать клей">
                        <div class="card-body text-center">
                            <a href="<?= Url::to(['/podbor/index']) ?>" class="card-text h4">Подобрать продукт</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-12">
                    <a href="#" class="btn btn-primary btn-lg btn-block my-3"><small>Техническая документация</small></a>
                    <a href="#" class="btn btn-warning btn-lg btn-block my-3"><small>Литература</small></a>
                    <div class="list-group list-article my-3">
                        <div class="list-group-item h4">Информация для клиентов</div>
                        <?php

                        foreach ($info as $item) {
                            echo Html::a($item->name, ['/info/view', 'slug' => $item->slug], ['class' => 'list-group-item']);
                        }
                        ?>
                    </div>
                </div>
            </div>
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

    <?php if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index') : ?>

    <div class="card how mt-3 mb-4">
        <div class="card-body text-center">
            <div class="h1">Схема заказа</div>
            <div class="row">
                <div class="col-sm-4 px-lg-5">
                    <div>
                        <img src="/img/how-1.png" alt="Заказ товара">
                    </div>
                    <div class="my-2">
                        <a href="#" class="h3"><span class="text-primary">1.</span> Заказ товара</a>
                    </div>
                    <div class="text-muted">
                        Описание описание описание описание описание описание описание описание описание описание описание
                    </div>
                </div>
                <div class="col-sm-4 px-lg-5">
                    <div>
                        <img src="/img/how-2.png" alt="100% предоплата">
                    </div>
                    <div class="my-2">
                        <a href="#" class="h3"><span class="text-primary">2.</span> 100% предоплата</a>
                    </div>
                    <div class="text-muted">
                        Описание описание описание описание описание описание описание описание описание описание описание
                    </div>
                </div>
                <div class="col-sm-4 px-lg-5">
                    <div>
                        <img src="/img/how-3.png" alt="Доставка">
                    </div>
                    <div class="my-2">
                        <a href="#" class="h3"><span class="text-primary">3.</span> Доставка</a>
                    </div>
                    <div class="text-muted">
                        Описание описание описание описание описание описание описание описание описание описание описание
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card how my-4">
        <div class="card-body">
            <div class="h1 text-center">Вопросы и ответы</div>
            <?php
            $question = Question::find()
                ->where(['status' => Question::STATUS_PUBLISHED])
                ->orderBy(['id' => SORT_DESC])
                ->limit(5)
                ->all();
            echo '<div class="question-list">';
            foreach ($question as $q) {
                echo '<div class="media">';
                echo $this->render('../site/_question_item', [
                    'model' => $q,
                ]);
                echo '</div>';
            }
            echo '</div>';
            ?>
        </div>
    </div>

    <div class="card how my-4">
        <div class="card-body">
            <div class="h1 text-center">Отзывы о компании</div>
            <?php
            $review = Review::find()
                ->where(['status' => Review::STATUS_PUBLISHED])
                ->orderBy(['id' => SORT_DESC])
                ->limit(5)
                ->all();
            echo '<div class="review-list">';
            foreach ($review as $r) {
                echo '<div class="media">';
                echo $this->render('../site/_review_item', [
                    'model' => $r,
                ]);
                echo '</div>';
            }
            echo '</div>';
            ?>
        </div>
    </div>

    <?php endif; ?>

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
                            <?php
                            $items = [
                                ['label' => 'Главная', 'url' => ['/']],
                                ['label' => 'Каталог', 'url' => ['/category/index']],
                                ['label' => 'Подобрать продукт', 'url' => ['/podbor/index']],
                                ['label' => 'Как заказать', 'url' => ['/site/how']],
                            ];
                            echo Nav::widget([
                                'items' => $items,
                                'activeClass' => '',
                            ]);
                            ?>
                        </nav>
                    </div>
                    <div class="col-md-6">
                        <nav class="nav flex-column">
                            <?php
                            $items = [
                                ['label' => 'Вопросы и ответы', 'url' => ['/site/qa']],
                                ['label' => 'Информация для клиентов', 'url' => ['/info/index']],
                                ['label' => 'Контакты', 'url' => ['/site/contacts']],
                                ['label' => 'Отзывы', 'url' => ['/guestbook/index']],
                            ];
                            echo Nav::widget([
                                'items' => $items,
                                'activeClass' => '',
                            ]);
                            ?>
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
