<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 25.12.17
 * Time: 11:45
 *
 * @var $model app\models\Question
 */
?>
<div class="media-body p-3">
    <div class="mb-1">
        <b><?= $model->name ?></b> | <span class="text-muted"><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
    </div>
    <?= nl2br($model->question) ?>

    <?php if ($model->answer) : ?>
    <div class="media ml-5 p-2 mt-2 pb-0">
        <div class="media-body">
            <div class="text-muted mb-1">Ответ компании | <span><?= Yii::$app->formatter->asDate($model->created_at) ?></span></div>
            <?= $model->answer ?>
        </div>
    </div>
    <?php endif; ?>
</div>