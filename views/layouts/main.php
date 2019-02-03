<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\FontAwesomeAsset;
use app\assets\SiteAsset;
use app\components\Nav;
use app\models\Question;
use app\models\Review;
use dench\cart\widgets\CartWidget;
use app\widgets\OrderScheme;
use dench\modal\Modal;
use dench\page\models\Page;
use dench\products\models\Category;
use kartik\typeahead\Typeahead;
use luya\bootstrap4\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\Menu;

SiteAsset::register($this);
FontAwesomeAsset::register($this);

$js = <<<JS
$('.block-link').click(function(){
    document.location.href = $(this).find('a').attr('href');
});
var minWidth = 768;
var sidebar = 1;
$(window).resize(function(){
    if ($(this).width() < minWidth) {
        goBottom();
    } else {
        goLeft();
    }
});
if ($(window).width() < minWidth) {
    goBottom();
} else {
    goLeft();
}
function goBottom() {
    var left = $('#sidebarleft');
    var bottom = $('#sidebarbottom');
    if (!sidebar) {
        bottom.html(left.html());
        left.html("");
        sidebar = 1;
    }
}
function goLeft() {
    var left = $('#sidebarleft');
    var bottom = $('#sidebarbottom');
    if (sidebar) {
        left.html(bottom.html());
        bottom.html("");
        sidebar = 0;
    }
}
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
                <form action="<?= Url::to(['/search']) ?>" class="input-group pt-1">
                    <?php
                    $template = '<a href="{{link}}">{{value}}</a>';
                    echo Typeahead::widget([
                        'name' => 'query',
                        'value' => Yii::$app->request->get('query'),
                        'container' => [
                            'style' => 'flex: 1;',
                        ],
                        'options' => [
                            'placeholder' => Yii::t('app', 'Search for...'),
                            'style' => 'border-bottom-right-radius: 0; border-top-right-radius: 0; font-size: 1rem;',
                        ],
                        'pluginOptions' => [
                            'highlight' => true,
                        ],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
                                'templates' => [
                                    'notFound' => '<div class="text-danger" style="padding:0 8px">По данному запросу ничего не найдено.</div>',
                                    'suggestion' => new JsExpression("Handlebars.compile('{$template}')"),
                                ],
                                'prefetch' => Url::to(['/search/list']),
                                'limit' => 10
                            ]
                        ]
                    ]);
                    ?>
                    <span class="input-group-append">
                        <button class="btn btn-primary" type="submit">Найти</button>
                    </span>
                </form>
            </div>
            <div class="col-6 col-md-4 text-right">
                <div class="phones">
                    <a href="tel:<?= Yii::$app->params['phone1'] ?>"><i class="fa fa-phone"></i> <?= Yii::$app->params['phone1f'] ?></a>
                    <a href="tel:<?= Yii::$app->params['phone2'] ?>"><i class="fa fa-phone"></i> <?= Yii::$app->params['phone2f'] ?></a>
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
                    /** @var Page[] $info */
                    $info = Page::find()
                        ->joinWith('translation')
                        ->leftJoin('page_parent','page.id = page_parent.page_id')
                        ->select(['name', 'slug'])
                        ->andWhere(['parent_id' => 6])
                        ->orderBy(['page.position' => SORT_ASC])
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
        <div class="sidebar col-md-4 col-lg-3">
            <div class="row">
                <div class="col-sm-6 col-md-12">

                    <?= CartWidget::widget() ?>

                    <nav class="navbar navbar-expand-md mb-3">
                        <button class="btn btn-dark btn-block d-md-none" type="button" data-toggle="collapse" data-target="#navbar-left" aria-controls="navbar-left" aria-expanded="false" aria-label="Toggle navigation">
                            Каталог товаров
                        </button>
                        <div class="collapse navbar-collapse" id="navbar-left">
                            <?php

                            /** @var $categories Category[] */
                            $categories = !Yii::$app->cache->exists('_categories-' . Yii::$app->language) ? Category::getMain() : [];

                            $items = [];

                            foreach ($categories as $category) {
                                $items[$category->id] = [
                                    'label' => $category->name,
                                    'url' => (count($category->categories)) ? ['category/pod', 'slug' => $category->slug] : ['category/view', 'slug' => $category->slug],
                                    'options' => [
                                        'tag' => false,
                                    ],
                                ];
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
                <div id="sidebarleft" class="col-sm-6 col-md-12">

                </div>
            </div>
        </div>
        <div class="mainblock col-md-8 col-lg-9">
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

    <?= OrderScheme::widget() ?>

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

    <div id="sidebarbottom">
        <div class="row">
            <div class="col-sm-6 col-md-12">
                <div class="card border border-primary border-strong block-link mb-3">
                    <a href="<?= Url::to(['/podbor/index']) ?>">
                        <img class="card-img-top" src="/img/podbor.jpg" alt="Подобрать клей">
                    </a>
                    <div class="card-body text-center">
                        <a href="<?= Url::to(['/podbor/index']) ?>" class="card-text h4">Подобрать продукт</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-12">
                <?php
                $item = $info[0];
                echo Html::a('<small>' . $item->name . '</small>', ['/info/view', 'slug' => $item->slug], ['class' => 'btn btn-primary btn-lg btn-block mb-3']);
                $item = $info[1];
                echo Html::a('<small>' . $item->name . '</small>', ['/info/view', 'slug' => $item->slug], ['class' => 'btn btn-warning btn-lg btn-block mb-3']);
                ?>
                <?php
                /*
                ?>
                <div class="list-group list-article my-3">
                    <div class="list-group-item h4">Информация для клиентов</div>
                    < ?php
                    foreach ($info as $item) {
                        echo Html::a($item->name, ['/info/view', 'slug' => $item->slug], ['class' => 'list-group-item']);
                    }
                    ? >
                </div>
                */
                ?>
            </div>
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
                                ['label' => 'Вопросы и ответы', 'url' => ['/site/questions']],
                                ['label' => 'Информация для клиентов', 'url' => ['/info/index']],
                                ['label' => 'Контакты', 'url' => ['/site/contacts']],
                                ['label' => 'Отзывы', 'url' => ['/site/reviews']],
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
        2017 - <?= date('Y') ?> © <a href="/"><?= Yii::$app->name ?></a>
    </div>
</footer>
<?= Modal::widget([
    'titleTag' => 'h3',
    'center' => true,
    'size' => 'modal-lg',
]); ?>
<?= $this->render('_counters') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
