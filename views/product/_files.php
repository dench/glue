<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 07.01.18
 * Time: 17:20
 *
 * @var $model dench\products\models\Product
 */

use yii\helpers\Html;

?>
<?php if ($model->files) : ?>
<div class="card my-3">
    <a class="card-header bg-dark text-white" id="headingDoc" data-toggle="collapse" href="#collapseDoc" aria-expanded="true" aria-controls="collapseText">
        <i class="fa fa-minus-square"></i><?= Yii::t('app', 'Documentation') ?>
    </a>
    <div id="collapseDoc" class="collapse show" aria-labelledby="headingDoc" data-parent="#accordion">
        <div class="card-body">
            <div class="list-group">
                <?php foreach ($model->files as $key => $file) : ?>
                    <?= Html::a('<i class="fa fa-file-o fa-fw"></i> ' . $model->fileName[$key], ['image/default/file', 'name' => $file->name, 'extension' => $file->extension], ['target' => '_blank', 'class' => 'list-group-item list-group-item-action']) ?>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>
<?php endif; ?>