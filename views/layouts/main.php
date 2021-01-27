<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\FontAwesomeAsset;
use app\assets\SiteAsset;
use app\components\Nav;
use app\models\Question;
use app\models\Review;
use app\widgets\Breadcrumbs;
use dench\cart\widgets\CartWidget;
use app\widgets\OrderScheme;
use dench\modal\Modal;
use dench\page\models\Page;
use dench\products\models\Category;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\Menu;

$asset = SiteAsset::register($this);
FontAwesomeAsset::register($this);

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(explode('?', Yii::$app->request->url)[0], true)]);
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
            <div class="search col-10 col-md-4 py-2 mt-1 mt-md-0">
                <form action="<?= Url::to(['/search']) ?>" class="input-group">
                    <?php
                    $template = '<a href="{{link}}">{{value}}</a>';
                    echo Typeahead::widget([
                        'id' => 'search',
                        'name' => 'query',
                        'value' => Yii::$app->request->get('query'),
                        'container' => [
                            'style' => 'flex: 1;',
                        ],
                        'options' => [
                            'placeholder' => Yii::t('app', 'Enter the name of the product'),
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
                                    'notFound' => '<div class="text-danger" style="padding:0 8px">' . Yii::t('app', 'No results were found for this request.') . '</div>',
                                    'suggestion' => new JsExpression("Handlebars.compile('{$template}')"),
                                ],
                                'remote' => [
                                    'url' => Url::to(['/search/list']) . '?q=%QUERY',
                                    'wildcard' => '%QUERY',
                                    'cache' => false,
                                ],
                                'limit' => 10
                            ]
                        ]
                    ]);
                    ?>
                    <span class="input-group-append">
                        <button class="btn btn-primary" type="submit"><?= Yii::t('app', 'Find') ?></button>
                    </span>
                </form>
                <div class="pt-1 text-white-50 small d-none d-md-block" style="position: absolute;">
                    <?= Yii::t('app', 'For example') ?>: <a href="#" onclick="return $('#search').val($(this).text());">loxeal 30-23</a>
                </div>
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
                            'label' => Yii::t('app', 'Home'),
                            'url' => ['/'],
                            'active' => in_array(Yii::$app->controller->id, ['site']) && in_array(Yii::$app->controller->action->id, ['index']),
                            /*'linkOptions' => [
                                'class' => in_array(Yii::$app->controller->id, ['site']) && in_array(Yii::$app->controller->action->id, ['index']) ? 'nav-item nav-link ml-3' : 'nav-item nav-link',
                            ],*/
                        ],
                        [
                            'label' => Yii::t('app', 'Catalog'),
                            'url' => ['/category/index'],
                            'active' => in_array(Yii::$app->controller->id, ['category', 'product']),
                        ],
                        ['label' => Yii::t('app', 'Find product'), 'url' => ['/podbor/index']],
                        ['label' => Yii::t('app', 'How to order'), 'url' => ['/site/how']],
                        ['label' => Yii::t('app', 'Questions and answers'), 'url' => ['/site/questions']],
                        [
                            'label' => Yii::t('app', 'Information for clients'),
                            'url' => ['/info/index'],
                            'items' => $info_menu,
                            'dropDownOptions' => [
                                'class' => '',
                            ],
                        ],
                        ['label' => Yii::t('app', 'Contacts'), 'url' => ['/site/contacts']],
                        ['label' => Yii::t('app', 'Reviews'), 'url' => ['/site/reviews']],
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
        <?php if (Yii::$app->controller->id !== 'site' || Yii::$app->controller->action->id !== 'index'): ?>
            <div class="sidebar col-md-4 col-lg-3">
                <div class="row">
                    <div class="col-sm-6 col-md-12">

                        <?= CartWidget::widget() ?>

                        <nav class="navbar navbar-expand-md mb-3">
                            <button class="btn btn-dark btn-block d-md-none" type="button" data-toggle="collapse" data-target="#navbar-left" aria-controls="navbar-left" aria-expanded="false" aria-label="Toggle navigation">
                                <?= Yii::t('app', 'Product catalog') ?>
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
        <?php else: ?>
            <div class="mainblock col-12">
        <?php endif; ?>
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

    <?= OrderScheme::widget(['baseUrl' => $asset->baseUrl]) ?>

    <div class="card how my-4">
        <div class="card-body">
            <div class="h1 text-center"><?= Yii::t('app', 'Questions and answers') ?></div>
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
            <div class="h1 text-center"><?= Yii::t('app', 'Reviews about the company') ?></div>
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
                        <img class="card-img-top" src="/img/podbor.jpg" alt="<?= Yii::t('app', 'Find glue') ?>">
                    </a>
                    <div class="card-body text-center">
                        <a href="<?= Url::to(['/podbor/index']) ?>" class="card-text h4"><?= Yii::t('app', 'Find product') ?></a>
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
                                ['label' => Yii::t('app', 'Home'), 'url' => ['/']],
                                ['label' => Yii::t('app', 'Catalog'), 'url' => ['/category/index']],
                                ['label' => Yii::t('app', 'Find product'), 'url' => ['/podbor/index']],
                                ['label' => Yii::t('app', 'How to order'), 'url' => ['/site/how']],
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
                                ['label' => Yii::t('app', 'Questions and answers'), 'url' => ['/site/questions']],
                                ['label' => Yii::t('app', 'Information for clients'), 'url' => ['/info/index']],
                                ['label' => Yii::t('app', 'Contacts'), 'url' => ['/site/contacts']],
                                ['label' => Yii::t('app', 'Reviews'), 'url' => ['/site/reviews']],
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
        <div class="text-white pb-4 text-center text-md-left">
            <div class="my-3"><?= Yii::t('app', 'Office and warehouse work') ?>: <?= Yii::$app->params['work_time'] ?></div>
            <div class="my-3"><?= Yii::$app->params['address_' . Yii::$app->language] ?></div>
            <div class="my-3"><?= Yii::$app->params['email'] ?></div>
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
