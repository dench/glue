<?php

/** @var $this yii\web\View */
/** @var $page app\components\Page */
/** @var $categories dench\products\models\Category[] */
/** @var $dataProvider yii\data\ActiveDataProvider */

use dench\image\helpers\ImageHelper;
use dench\products\models\Category;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $page->name;
?>
<h1 class="mb-3"><?= $page->h1 ?></h1>

<?php if ($page->short) : ?>
    <div class="card mb-3">
        <div class="card-body">
            <?= $page->short ?>
        </div>
    </div>
<?php endif; ?>

<div class="row categories">
    <?php foreach ($categories as $category) : ?>
        <?php
        $url = Url::to((count($category->categories)) ? ['category/pod', 'slug' => $category->slug] : ['category/view', 'slug' => $category->slug]);
        ?>
        <div class="col-6 col-sm-4 col-lg-3 pb-3 px-1 px-sm-2">
            <div class="card block-link">
                <a href="<?= $url ?>" rel="nofollow">
                <?php if ($category->image) { ?>
                    <img src="<?= ImageHelper::thumb($category->image->id, 'category') ?>" class="card-img-top" alt="<?= $category->image->alt ? $category->image->alt : $category->name ?>" title="<?= $category->title ?>">
                <?php } else { ?>
                    <img src="<?= Yii::$app->params['image']['size']['category']['none'] ?>" class="card-img-top" alt="">
                <?php } ?>
                </a>
                <div class="card-footer bg-gradient-dark text-center px-0 px-sm-1">
                    <a href="<?= $url ?>" class="text-white"><?= $category->name ?></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<h2 class="mb-3"><?= Yii::t('app', 'Product catalog') ?></h2>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'layout' => "{items}\n{pager}",
    'emptyTextOptions' => [
        'class' => 'alert alert-danger',
    ],
    'options' => [
        'class' => 'list-group mb-4',
    ],
    'itemOptions' => [
        'class' => 'list-group-item',
    ],
]);
?>

<?php if (!Yii::$app->request->get('page') && $page->text) : ?>
    <div class="card mb-3">
        <div class="page-seo card-body">
            <?= $page->text ?>
        </div>
    </div>
<?php endif; ?>
