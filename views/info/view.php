<?php

/** @var $this yii\web\View */
/** @var $page dench\page\models\Page */

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => $page->parent->name, 'url' => ['/info/index']];
$this->params['breadcrumbs'][] = $page->name;
?>
<h1><?= $page->h1 ?></h1>

<?= $page->short ?>

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