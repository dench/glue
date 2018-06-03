<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 05.07.17
 * Time: 20:21
 *
 * @var $this yii\web\View
 * @var $model dench\page\models\Page
 */
use dench\image\helpers\ImageHelper;
use yii\helpers\Url;

?>
<?php
$url = Url::to((count($model->childs)) ? ['info/pod', 'slug' => $model->slug] : ['info/view', 'slug' => $model->slug]);
?>
<div class="card block-link">
    <a href="<?= $url ?>" rel="nofollow">
        <?php if ($model->image) { ?>
            <img src="<?= ImageHelper::thumb($model->image->id, 'category') ?>" class="card-img-top" alt="<?= $model->image->alt ? $model->image->alt : $model->name ?>" title="<?= $model->title ?>">
        <?php } else { ?>
            <img src="<?= Yii::$app->params['image']['size']['category']['none'] ?>" class="card-img-top" alt="">
        <?php } ?>
    </a>
    <div class="card-footer bg-gradient-dark text-center">
        <a href="<?= $url ?>" class="text-white"><?= $model->name ?></a>
    </div>
</div>