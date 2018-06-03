<?php

/** @var $this yii\web\View */
/** @var $page dench\page\models\Page */
/** @var $childs dench\page\models\Page[] */

use yii\helpers\Html;
use yii\helpers\Url;
use dench\image\helpers\ImageHelper;

$this->params['breadcrumbs'][] = ['label' => 'Информация для клиентов', 'url' => ['/info/index']];
if ($page->parent->id !== 6 && $page->parent) {
    $this->params['breadcrumbs'][] = ['label' => $page->parent->name, 'url' => ['/info/view', 'slug' => $page->parent->slug]];
}
$this->params['breadcrumbs'][] = $page->name;
?>
<h1 class="mb-3"><?= $page->h1 ?></h1>

<?= $page->short ?>

<?php if ($childs) : ?>
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
<?php endif; ?>

<div class="row mx-0">
    <?php foreach ($page->files as $key => $file) : ?>
        <?php
            switch ($file->extension) {
                case "pdf": $fa = "file-pdf-o"; break;
                case "doc": $fa = "file-word-o"; break;
                case "docx": $fa = "file-word-o"; break;
                case "xls": $fa = "file-excel-o"; break;
                case "xlsx": $fa = "file-excel-o"; break;
                case "zip": $fa = "file-archive-o"; break;
                case "rar": $fa = "file-archive-o"; break;
                case "jpg": $fa = "file-image-o"; break;
                case "png": $fa = "file-image-o"; break;
                default: $fa = "file-text-o";
            }
        ?>
        <div class="px-0 col-sm-6 col-md-6 col-lg-4">
            <?= Html::a('<i class="fa fa-' . $fa . ' fa-fw text-danger"></i> <span>' . $page->fileName[$key] . '</span>', ['image/default/file', 'name' => $file->name, 'extension' => $file->extension], ['target' => '_blank', 'class' => 'btn btn-file']) ?>
        </div>
    <?php endforeach; ?>
</div>

<?= $page->text ?>