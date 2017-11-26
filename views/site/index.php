<?php

/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */
/* @var $categories dench\products\models\Category[] */

use dench\image\helpers\ImageHelper;
use dench\products\models\Category;
use yii\helpers\Url;

?>

<section>
    <div class="row categories">
        <?php foreach (Category::findAll(['enabled' => 1]) as $category) : ?>
        <div class="col-sm-6 col-lg-4 pb-3 px-2">
            <div class="card block-link">
                <?php if ($category->image) { ?>
                    <img src="<?= ImageHelper::thumb($category->image->id, 'category') ?>" class="card-img-top" alt="<?= $category->image->alt ? $category->image->alt : $category->name ?>" title="<?= $category->title ?>">
                <?php } else { ?>
                    <img src="<?= Yii::$app->params['image']['none'] ?>" class="card-img-top" alt="">
                <?php } ?>
                <div class="card-footer bg-gradient-dark text-center">
                    <a href="<?= Url::to(['category/view', 'slug' => $category->slug]) ?>" class="text-white"><?= $category->name ?></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <h1><?= $page->h1 ?></h1>
    <?= $page->text ?>
</section>