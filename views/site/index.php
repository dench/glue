<?php

/* @var $this yii\web\View */
/* @var $page dench\page\models\Page */
/* @var $categories dench\products\models\Category[] */

use dench\image\helpers\ImageHelper;
use yii\helpers\Url;

?>

<section>
    <div class="row categories">
        <?php foreach ($categories as $category) : ?>
            <?php
            $url = Url::to((count($category->categories)) ? ['category/pod', 'slug' => $category->slug] : ['category/view', 'slug' => $category->slug]);
            ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pb-3 px-2">
                <div class="card block-link">
                    <a href="<?= $url ?>" rel="nofollow">
                        <?php if ($category->image) { ?>
                            <img src="<?= ImageHelper::thumb($category->image->id, 'category') ?>" class="card-img-top" alt="<?= $category->image->alt ? $category->image->alt : $category->name ?>" title="<?= $category->title ?>">
                        <?php } else { ?>
                            <img src="<?= Yii::$app->params['image']['size']['category']['none'] ?>" class="card-img-top" alt="">
                        <?php } ?>
                    </a>
                    <div class="card-footer bg-gradient-dark text-center">
                        <a href="<?= $url ?>" class="text-white"><?= $category->name ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!--<h1><?= $page->h1 ?></h1>-->
    <?= $page->text ?>
</section>