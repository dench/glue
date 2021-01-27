<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 25.12.17
 * Time: 11:45
 *
 * @var $model app\models\Review
 */
?>
<div class="media-body p-3">
    <div class="mb-1">
        <div class="float-right">
            <?= Yii::t('app', 'Stars') ?>:
            <?php
            for ($i = 0; $i < $model->rating; $i++) {
                echo '<i class="fa fa-star text-warning"></i> ';
            }
            ?>
        </div>
        <b><?= $model->name ?></b>, <span class="text-muted"><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
    </div>
    <?= nl2br($model->text) ?>

    <?php if ($model->answer) : ?>
    <div class="media ml-5 p-2 mt-2 pb-0">
        <div class="media-body">
            <div class="text-muted mb-1"><?= Yii::t('app', 'Company response') ?>, <span><?= Yii::$app->formatter->asDate($model->created_at) ?></span></div>
            <?= $model->answer ?>
        </div>
    </div>
    <?php endif; ?>
</div>