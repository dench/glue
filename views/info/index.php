<?php

use yii\helpers\Url;
use dench\image\helpers\ImageHelper;

/** @var $this yii\web\View */
/** @var $page dench\page\models\Page */
/** @var $dataProvider yii\data\ActiveDataProvider */
/** @var $childs dench\page\models\Page[] */

$this->params['breadcrumbs'][] = $page->name;
?>
<h1 class="mb-3"><?= $page->h1 ?></h1>

<?= $page->short ?>

<div class="row categories">
    <?php foreach ($childs as $item): ?>
        <div class="col-sm-6 col-lg-4 pb-3 px-2">
            <div class="card block-link">
                <a href="<?= Url::to(['info/view', 'slug' => $item->slug]) ?>" rel="nofollow">
                    <?php if ($item->image) { ?>
                        <img src="<?= ImageHelper::thumb($item->image->id, 'category') ?>" class="card-img-top" alt="<?= $item->image->alt ? $item->image->alt : $item->name ?>" title="<?= $item->title ?>">
                    <?php } else { ?>
                        <img src="<?= Yii::$app->params['image']['size']['category']['none'] ?>" class="card-img-top" alt="">
                    <?php } ?>
                </a>
                <div class="card-footer bg-gradient-dark text-center">
                    <a href="<?= Url::to(['info/view', 'slug' => $item->slug]) ?>" class="text-white"><?= $item->name ?></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $page->text ?>